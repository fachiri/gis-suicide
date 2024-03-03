<?php

namespace App\Http\Controllers;

use App\Constants\UserGender;
use App\Models\Perpetrator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Perpetrator::query();

        $oldestCaseYear = Perpetrator::orderBy('incident_date', 'asc')->value('incident_date');
        $oldestCaseYear = Carbon::parse($oldestCaseYear)->format('Y');
        $currentYear = Carbon::now()->year;

        if ($request->has("year")) {
            $query->whereYear("incident_date", $request->year);
        } else {
            return redirect()->route('dashboard.index', ['year'=> $currentYear]);
        }

        $perpetrators = $query->get();

        $monthlyCases = $perpetrators->groupBy(function ($perpetrator) {
            return Carbon::parse($perpetrator->incident_date)->format('n');
        })->map->count()->toArray();

        $perpetratorMaleCount = Perpetrator::where('gender', UserGender::MALE)->count();
        $perpetratorFemaleCount = Perpetrator::where('gender', UserGender::FEMALE)->count();

        return view('pages.dashboard.index', compact('monthlyCases', 'oldestCaseYear', 'currentYear', 'perpetratorMaleCount', 'perpetratorFemaleCount'));
    }
}
