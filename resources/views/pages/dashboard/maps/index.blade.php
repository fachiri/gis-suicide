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
			<div class="card shadow-lg">
				<div class="card-header d-flex justify-content-between align-items-center pb-0">
					<h4 class="card-title pl-1">Persebaran</h4>
					<div class="d-flex gap-2">
						<a href="{{ route('dashboard.maps.geojson.index') }}" class="btn btn-success btn-sm fw-medium">
							<i class="bi bi-filetype-json"></i>
							Geojson
						</a>
					</div>
				</div>
				<div class="card-body py-4-5 table-responsive px-4 pt-0">
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
		const gorontaloBounds = L.latLngBounds(
			L.latLng(1.058404, 121.161003),
			L.latLng(0.174064, 123.568904)
		);

		const map = L.map('map', {
			maxBounds: gorontaloBounds,
			maxBoundsViscosity: 1.0
		}).setView([0.5400, 123.0600], 9);

		map.setMaxBounds(gorontaloBounds);

    const geoJsons = @json($geojsons);

    const geoJsonPath = geoJsons.map(geoJson => ({
      label: 'Merah',
      path: @json(asset('storage/uploads/geojsons/')) + `/${geoJson.file}`
    }))

		const colors = [{
				label: 'Merah',
				color: 'red'
			},
			{
				label: 'Kuning',
				color: 'yellow'
			},

			{
				label: 'Hijau',
				color: 'green'
			}
		];

		const perpetrators = @json($perpetrators);
		const route = @json(route('dashboard.master.perpetrators.show', 'uuid'));

		perpetrators.forEach(perpetrator => {
			const latlng = [perpetrator.latitude, perpetrator.longitude];
			let marker = L.marker(latlng).addTo(map);

			let popupContent = `
        <div>
            <div class="d-flex justify-content-between align-items-center gap-1 mb-1">
                <span>Nama</span>
                <b>${perpetrator.name}</b>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 mb-1">
                <span>Cara</span>
                <b>${perpetrator.suicide_method}</b>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 mb-1">
                <span>Alat</span>
                <b>${perpetrator.suicide_tool}</b>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <a href="${route.replace("uuid", perpetrator.uuid)}">Detail</a>
            </div>
        </div>
    `;

			marker.bindPopup(popupContent);

			marker.on('mouseover', function() {
				marker.openPopup();
			});
		});

		geoJsonPath.forEach((geoJson, index) => {
			omnivore.geojson(geoJson.path)
				.on('ready', function() {
					this.eachLayer(function(layer) {
						const color = colors.find(c => c.label === geoJson.label).color;
						layer.setStyle({
							fillColor: color,
							color: '#000',
							fillOpacity: 0.3,
							weight: .5
						});
					});
				})
				.addTo(map);
		});

		L.Control.geocoder().addTo(map);

		L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			minZoom: 9,
			attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
		}).addTo(map);
	</script>
@endpush
