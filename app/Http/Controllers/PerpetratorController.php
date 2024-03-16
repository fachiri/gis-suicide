<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePerpetratorRequest;
use App\Http\Requests\UpdatePerpetratorRequest;
use App\Models\Perpetrator;
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
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <a href="' . route('dashboard.master.perpetrators.show', $row->uuid) . '" class="btn btn-primary btn-sm">
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
        return view('pages.dashboard.master.perpetrators.create');
    }

    public function store(StorePerpetratorRequest $request)
    {
        try {
            Perpetrator::create($request->all());

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
        return view('pages.dashboard.master.perpetrators.edit', compact('perpetrator'));
    }

    public function update(UpdatePerpetratorRequest $request, Perpetrator $perpetrator)
    {
        try {
            $perpetrator->name = $request->name;
            $perpetrator->gender = $request->gender;
            $perpetrator->age = $request->age;
            $perpetrator->education = $request->education;
            $perpetrator->address = $request->address;
            $perpetrator->marital_status = $request->marital_status;
            $perpetrator->occupation = $request->occupation;
            $perpetrator->incident_date = $request->incident_date;
            $perpetrator->suicide_method = $request->suicide_method;
            $perpetrator->suicide_tool = $request->suicide_tool;
            $perpetrator->description = $request->description;
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
}
