<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Geojson;
use App\Models\Perpetrator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $geojsons = Geojson::all();
        $query = Perpetrator::query();

        $oldestCaseYear = Perpetrator::orderBy('incident_date', 'asc')->value('incident_date');
        $oldestCaseYear = Carbon::parse($oldestCaseYear)->format('Y');
        $currentYear = Carbon::now()->year;

        if ($request->has("year")) {
            $query->whereYear("incident_date", $request->year);
        } else {
            return redirect()->route('dashboard.index', ['year' => $currentYear]);
        }

        $perpetrators = $query->get();

        $monthlyCases = $perpetrators->groupBy(function ($perpetrator) {
            return Carbon::parse($perpetrator->incident_date)->format('n');
        })->map->count()->toArray();

        $criteriaMale = Criteria::where('code', 'A1')->first();
        $criteriaFemale = Criteria::where('code', 'A2')->first();
        $perpetratorMaleCount = Perpetrator::where('gender', $criteriaMale->id)->count();
        $perpetratorFemaleCount = Perpetrator::where('gender', $criteriaFemale->id)->count();

        $maps = [];
        foreach ($geojsons as $key => $geojson) {
            $file = File::get(public_path('storage/uploads/geojsons/' . $geojson->file));
            $data = json_decode($file, true);
            
            $maps[$key] = $data;
            $maps[$key]['uuid'] = $geojson->uuid;
            $maps[$key]['area'] = $geojson->area;

            foreach ($maps[$key]['features'] as $idx => $feature) {
                $fid = $feature['properties']['fid'];

                $count = Perpetrator::where('district_code', $fid)->count();
                $maps[$key]['features'][$idx]['properties']['count'] = $count;

                $color = $count >= 20 ? '#bf323c' : ($count >= 10 ? '#ffcb3d' : '#2c7348');
                $maps[$key]['features'][$idx]['properties']['graph']['color'] = $color;

                $cases = Perpetrator::where('district_code', $fid)->get();

                $casesByYear = $cases->groupBy(function ($case) {
                    $date = Carbon::createFromFormat('Y-m-d', $case->incident_date);
                    return $date->format('Y');
                });
                
                $casesByYear = $casesByYear->sortBy(function($value, $key) {
                    return $key;
                });

                $casesByMonth = $cases->groupBy(function ($case) {
                    return Carbon::createFromFormat('Y-m-d', $case->incident_date)->format('F Y');
                });

                $graphData = [];
                $graphCategories = [];

                foreach ($casesByYear as $year => $data) {
                }

                $maps[$key]['features'][$idx]['properties']['graph']['data'] = $graphData;
                $maps[$key]['features'][$idx]['properties']['graph']['categories'] = $graphCategories;
            }
        }

        return view('pages.dashboard.index', compact('monthlyCases', 'oldestCaseYear', 'currentYear', 'perpetratorMaleCount', 'perpetratorFemaleCount', 'geojsons', 'maps'));
    }
}
