<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGeojsonRequest;
use App\Models\Geojson;
use Illuminate\Support\Facades\Storage;

class GeojsonController extends Controller
{
    public function index()
    {
        $geojsons = Geojson::all();

        return view('pages.dashboard.maps.geojson.index', compact('geojsons'));
    }

    public function create()
    {
        return view('pages.dashboard.maps.geojson.create');
    }

    public function store(StoreGeojsonRequest $request)
    {
        try {
            $geojson = new Geojson();
            $geojson->area = $request->area;

            if ($request->hasFile('file')) {
                $geojson->file = basename($request->file('file')->store('public/uploads/geojsons'));
            }

            $geojson->save();

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function destroy(Geojson $geojson)
    {
        try {
            Storage::delete('public/uploads/geojsons/' . $geojson->file);
            $geojson->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }
}
