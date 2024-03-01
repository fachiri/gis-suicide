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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perpetrator $perpetrator)
    {
        //
    }
}
