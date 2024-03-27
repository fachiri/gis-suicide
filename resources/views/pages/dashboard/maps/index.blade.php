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
	<link rel="stylesheet" href="{{ asset('css/extensions/leaflet.legend.css') }}">
	<link rel="stylesheet" href="https://unpkg.com/leaflet-fullscreen/dist/leaflet.fullscreen.css" />
	<style>
		.title-card {
			position: absolute;
			top: 10px;
			left: 10px;
			background-color: white;
			padding: 10px;
			border-radius: 5px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
		}
	</style>
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
	<script src="https://unpkg.com/leaflet-fullscreen/dist/Leaflet.fullscreen.min.js"></script>
	<script src="{{ asset('js/extensions/leaflet.legend.js') }}"></script>
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
			area: geoJson.area,
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

		const customIcon = L.icon({
			iconUrl: `{{ asset('gis/marker7.svg') }}`,
			iconSize: [32, 32],
			iconAnchor: [16, 32],
			popupAnchor: [0, -32]
		})

		perpetrators.forEach(perpetrator => {
			const latlng = [perpetrator.latitude, perpetrator.longitude];
			let marker = L.marker(latlng, {
				icon: customIcon
			}).addTo(map);

			let popupContent = `
				<table class="table-striped table-sm">
					<tbody>
						<tr>
							<td>Nama</td>
							<th>${perpetrator.name}</th>
						</tr>
						<tr>
							<td>Cara</td>
							<th>${perpetrator.suicide_method}</th>
						</tr>
						<tr>
							<td>Alat</td>
							<th>${perpetrator.suicide_tool}</th>
						</tr>
						<tr>
							<td>
								<a href="${route.replace("uuid", perpetrator.uuid)}">Detail</a>
							</td>
							<td>
							</td>
						</tr>
					</tbody>
				</table>
			`;

			marker.bindPopup(popupContent);

			marker.on('mouseover', function() {
				marker.openPopup();
			});
		});

		function getColor(count) {
			return count >= 10 ? '#dc3b45' :
				count >= 5 ? '#ffc23d' :
				'#368755';
		}

		geoJsonPath.forEach((geoJson, index) => {
			omnivore.geojson(geoJson.path)
				.on('ready', function() {
					this.eachLayer(async function(layer) {
						let defaultOptions = {
							fillOpacity: 0.3,
							weight: 1
						};

						const districtCode = layer?.feature?.properties?.fid
						const response = await fetch(`/dashboard/maps/perpetrators/count/${districtCode}`, {
							method: 'GET',
							headers: {
								'Content-Type': 'application/json',
							},
						});
						const data = await response.json();

						defaultOptions.fillColor = getColor(data.count)

						layer.setStyle(defaultOptions);

						layer.on('mouseover', function(e) {
							this.setStyle({
								fillOpacity: 0.6,
								weight: 2
							});

						});

						layer.on('mouseout', function() {
							this.setStyle(defaultOptions);
						});
					});
				})
				.addTo(map);
		});

		const CustomControl = L.Control.extend({
			onAdd: function(map) {
				var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control bg-white px-2 py-1');
				container.innerHTML = `${geoJsons.map(e => `
									<div class="d-flex gap-2 fw-bold">
										<label class="form-check-label" for="show-${e.uuid}">
											${e.area}
										</label>
										<input class="form-check-input" type="checkbox" id="show-${e.uuid}" checked>
									</div>
								`)}`;

				return container;
			}
		});
		new CustomControl({
			position: 'bottomleft'
		}).addTo(map);

		L.Control.geocoder().addTo(map);

		map.addControl(new L.Control.Fullscreen({
			position: 'topright',
			title: 'View Full Screen',
		}));

		L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			minZoom: 9,
			attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
		}).addTo(map);
	</script>
@endpush
