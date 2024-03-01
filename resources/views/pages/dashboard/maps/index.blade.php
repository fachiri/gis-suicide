@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Maps' => '#',
    ],
])
@section('title', 'Maps')
@push('css')
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 table-responsive px-4">
					<div id="map" style="height: 90vh"></div>
				</div>
			</div>
		</div>
	</section>
@endsection
@push('scripts')
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
	<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
	<script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js'></script>
	<script>
		const geoJsonPath = [
			@json(asset('geojson/kabupatenboalemo.geojson')),
			@json(asset('geojson/kabupatenbonebolago.geojson')),
			@json(asset('geojson/kabupatengorontalo.geojson')),
			@json(asset('geojson/kabupatengorontaloutara.geojson')),
			@json(asset('geojson/kabupatenpohuwato.geojson')),
			@json(asset('geojson/kotagorontalo.geojson'))
		];

		const map = L.map('map').setView([0.5400, 123.0600], 9);

		L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 19,
			attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
		}).addTo(map);

		L.Control.geocoder().addTo(map);

		geoJsonPath.forEach(path => {
			omnivore.geojson(path).addTo(map);
		});
	</script>
@endpush
