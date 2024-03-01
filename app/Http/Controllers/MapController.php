<?php

namespace App\Http\Controllers;

use App\Models\Geojson;
use App\Models\Perpetrator;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $perpetrators = Perpetrator::all();
        $geojsons = Geojson::all();

        return view('pages.dashboard.maps.index', compact('perpetrators', 'geojsons'));
    }
}
