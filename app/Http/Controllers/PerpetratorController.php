<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePerpetratorRequest;
use App\Http\Requests\UpdatePerpetratorRequest;
use App\Models\Geojson;
use App\Models\Perpetrator;
use App\Models\Criteria;
use App\Utils\GetUtils;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class PerpetratorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Perpetrator::all();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('gender', function ($row) {
                    return $row->genderCriteria->name;
                })
                ->addColumn('age_class', function ($row) {
                    return $row->ageClassCriteria->name;
                })
                ->addColumn('education', function ($row) {
                    return $row->educationCriteria->name;
                })
                ->addColumn('marital_status', function ($row) {
                    return $row->maritalStatusCriteria->name;
                })
                ->addColumn('occupation', function ($row) {
                    return $row->occupationCriteria->name;
                })
                ->addColumn('economic_status', function ($row) {
                    return $row->economicStatusCriteria->name;
                })
                ->addColumn('motive', function ($row) {
                    return $row->motiveCriteria->name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <a href="' . route('dashboard.master.perpetrators.show', $row->uuid) . '" class="btn btn-primary btn-sm" style="white-space: nowrap">
                            <i class="bi bi-list-ul"></i>
                            Detail
                        </a> 
                        ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.dashboard.master.perpetrators.index');
    }

    public function create()
    {
        $districts = Geojson::all();
        $genders = Criteria::where('type', 'gender')->get();
        $occupations = Criteria::where('type', 'occupation')->get();
        $motives = Criteria::where('type', 'motive')->get();
        $educations = Criteria::where('type', 'education')->get();
        $maritalStatus = Criteria::where('type', 'marital_status')->get();
        $economicStatus = Criteria::where('type', 'economic_status')->get();

        return view('pages.dashboard.master.perpetrators.create', compact('districts', 'genders', 'occupations', 'motives', 'educations', 'maritalStatus', 'economicStatus'));
    }

    public function store(StorePerpetratorRequest $request)
    {
        try {
            $data = $request->all();
            $data['age_class'] = GetUtils::getAgeClass($data['age']);

            Perpetrator::create($data);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function show(Perpetrator $perpetrator)
    {
        return view('pages.dashboard.master.perpetrators.show', compact('perpetrator'));
    }

    public function edit(Perpetrator $perpetrator)
    {
        $districts = Geojson::all();
        $genders = Criteria::where('type', 'gender')->get();
        $occupations = Criteria::where('type', 'occupation')->get();
        $motives = Criteria::where('type', 'motive')->get();
        $educations = Criteria::where('type', 'education')->get();
        $maritalStatus = Criteria::where('type', 'marital_status')->get();
        $economicStatus = Criteria::where('type', 'economic_status')->get();

        return view('pages.dashboard.master.perpetrators.edit', compact('perpetrator', 'districts', 'genders', 'occupations', 'motives', 'educations', 'maritalStatus', 'economicStatus'));
    }

    public function update(UpdatePerpetratorRequest $request, Perpetrator $perpetrator)
    {
        try {
            $perpetrator->name = $request->name;
            $perpetrator->gender = $request->gender;
            $perpetrator->age = $request->age;
            $perpetrator->age_class = GetUtils::getAgeClass($request->age);
            $perpetrator->education = $request->education;
            $perpetrator->address = $request->address;
            $perpetrator->marital_status = $request->marital_status;
            $perpetrator->occupation = $request->occupation;
            $perpetrator->economic_status = $request->economic_status;
            $perpetrator->incident_date = $request->incident_date;
            $perpetrator->suicide_method = $request->suicide_method;
            $perpetrator->suicide_tool = $request->suicide_tool;
            $perpetrator->motive = $request->motive;
            $perpetrator->description = $request->description;
            $perpetrator->district_code = $request->district_code;
            $perpetrator->latitude = $request->latitude;
            $perpetrator->longitude = $request->longitude;
            $perpetrator->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function destroy(Perpetrator $perpetrator)
    {
        $perpetrator->delete();

        return redirect()->route('dashboard.master.perpetrators.index')->with('success', 'Data berhasil dihapus');
    }

    public function count($districtCode)
    {
        try {
            $count = Perpetrator::where('district_code', $districtCode)->count();

            return response()->json(['count' => $count]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Terjadi kesalahan dalam menghitung jumlah pelaku.']);
        }
    }
}
