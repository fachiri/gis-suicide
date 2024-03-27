<?php

namespace App\Http\Controllers;

use App\Models\Perpetrator;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function users(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.dashboard.reports.users');
    }

    public function users_pdf_preview(Request $request)
    {
        $users = User::all();

        $Pdf = Pdf::loadView('exports.users', compact('users'));

        return $Pdf->stream();
    }

    public function perpetrators(Request $request)
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
                ->addColumn('motive', function ($row) {
                    return $row->motiveCriteria->name;
                })
                ->make(true);
        }

        return view('pages.dashboard.reports.perpetrators');
    }

    public function perpetrators_pdf_preview(Request $request)
    {
        $perpetrators = Perpetrator::all();

        $Pdf = Pdf::loadView('exports.perpetrators', compact('perpetrators'))->setPaper('legal', 'landscape');

        return $Pdf->stream();
    }
}
