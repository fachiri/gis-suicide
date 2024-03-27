@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Master Pelaku' => route('dashboard.master.perpetrators.index'),
        $perpetrator->name => route('dashboard.master.perpetrators.show', $perpetrator->uuid),
        'Edit' => null,
    ],
])
@section('title', 'Edit Pelaku')
@push('css')
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card shadow-lg">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Form Edit Pelaku</h4>
				</div>
				<div class="card-body px-4">
					<x-form.layout.horizontal action="{{ route('dashboard.master.perpetrators.update', $perpetrator->uuid) }}" method="PUT" submit-text="Perbarui">
						<x-form.input layout="horizontal" name="name" label="Nama Pelaku" placeholder="Nama Pelaku.." :value="$perpetrator->name" />
						<x-form.select layout="horizontal" name="gender" label="Jenis Kelamin" :value="$perpetrator->gender" :options="$genders->map(function ($item) {
						    return (object) [
						        'label' => $item->name,
						        'value' => $item->id,
						    ];
						})" />
						<x-form.input type="number" layout="horizontal" name="age" label="Umur" placeholder="Umur.." :value="$perpetrator->age" />
						<x-form.select layout="horizontal" name="education" label="Pendidikan" :value="$perpetrator->education" :options="$educations->map(function ($item) {
						    return (object) [
						        'label' => $item->name,
						        'value' => $item->id,
						    ];
						})" />
						<x-form.textarea layout="horizontal" name="address" label="Alamat" placeholder="Alamat.." :value="$perpetrator->address" />
						<x-form.select layout="horizontal" name="marital_status" label="Status Pernikahan" :value="$perpetrator->marital_status" :options="$maritalStatus->map(function ($item) {
						    return (object) [
						        'label' => $item->name,
						        'value' => $item->id,
						    ];
						})" />
						<x-form.select layout="horizontal" name="occupation" label="Pekerjaan" :value="$perpetrator->occupation" :options="$occupations->map(function ($item) {
						    return (object) [
						        'label' => $item->name,
						        'value' => $item->id,
						    ];
						})" />
						<x-form.input type="date" layout="horizontal" name="incident_date" label="Tanggal Kasus" placeholder="Tanggal Kasus.." :value="$perpetrator->incident_date" />
						<x-form.input layout="horizontal" name="suicide_method" label="Cara Bunuh Diri" placeholder="Cara Bunuh Diri.." :value="$perpetrator->suicide_method" />
						<x-form.input layout="horizontal" name="suicide_tool" label="Media/Alat" placeholder="Media/Alat.." :value="$perpetrator->suicide_tool" />
						<x-form.select layout="horizontal" name="motive" label="Motif Bunuh Diri" :value="$perpetrator->motive" :options="$motives->map(function ($item) {
						    return (object) [
						        'label' => $item->name,
						        'value' => $item->id,
						    ];
						})" />
						<x-form.select layout="horizontal" name="district_code" label="Wilayah" :options="[]" />
						<x-form.textarea layout="horizontal" name="description" label="Keterangan" placeholder="Keterangan.." :value="$perpetrator->description" />
						<div class="col-md-4">
							<label>Lokasi</label>
						</div>
						<div class="col-md-8 form-group">
							<div class="mb-3">
								<div id="map" style="height: 280px"></div>
							</div>
							<div class="row">
								<div class="col-6">
									<x-form.input name="latitude" placeholder="Latitude" :readonly="true" :value="$perpetrator->latitude" />
								</div>
								<div class="col-6">
									<x-form.input name="longitude" placeholder="Longitude" :readonly="true" :value="$perpetrator->longitude" />
								</div>
							</div>
						</div>
					</x-form.layout.horizontal>
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
		const inputWilayah = document.querySelector('#district_code');
		const gorontaloBounds = L.latLngBounds(
			L.latLng(1.058404, 121.161003),
			L.latLng(0.174064, 123.568904)
		);

		const latitude = '{{ $perpetrator->latitude }}';
		const longitude = '{{ $perpetrator->longitude }}';

		const customIcon = L.icon({
			iconUrl: `{{ asset('gis/marker7.svg') }}`,
			iconSize: [32, 32],
			iconAnchor: [16, 32],
			popupAnchor: [0, -32]
		})

		var map = L.map('map', {
			maxBounds: gorontaloBounds,
			maxBoundsViscosity: 1.0
		}).setView([latitude, longitude], 13);

		const geoJsons = @json($districts);
		var currentLayer = null;

		const geoJsonPath = geoJsons.map(geoJson => ({
			area: geoJson.area,
			path: @json(asset('storage/uploads/geojsons/')) + `/${geoJson.file}`
		}))

		const removeMarker = () => {
			map.eachLayer(function(layer) {
				if (layer instanceof L.Marker) {
					map.removeLayer(layer);
				}
			});
		}

		inputWilayah.addEventListener('change', e => {
			const selectedOption = e.target.selectedOptions[0];
			const value = selectedOption.value;

			if (currentLayer) {
				currentLayer.setStyle({
					fillOpacity: 0.3,
					weight: 1
				});
			}

			map.eachLayer(layer => {
				if (layer.feature && layer.feature.properties && layer.feature.properties.fid === value) {
					currentLayer = layer;
					layer.setStyle({
						fillOpacity: 0.5,
						weight: 2
					});
					map.fitBounds(layer.getBounds());
					document.getElementById('latitude').value = '';
					document.getElementById('longitude').value = '';
					removeMarker()
				}
			});
		});

		geoJsonPath.forEach((geoJson, index) => {
			omnivore.geojson(geoJson.path)
				.on('ready', function() {
					this.eachLayer(function(layer) {
						layer.setStyle({
							fillOpacity: 0.3,
							weight: 1
						});

						const fid = layer.feature.properties.fid;
						const nama = layer.feature.properties.nama;

						const option = document.createElement('option');
						option.value = fid;
						option.textContent = nama;

						if (fid == '{{ $perpetrator->district_code }}') {
							option.selected = true;
							map.fitBounds(layer.getBounds());
							currentLayer = layer.setStyle({
								fillOpacity: 0.5,
								weight: 1
							});
						}

						inputWilayah.appendChild(option);
					});
				}).addTo(map);
		});

		L.marker([latitude, longitude], {
			icon: customIcon
		}).addTo(map);

		map.on('click', function(e) {
			if (!currentLayer) {
				return alert('Pilih Wilayah terlebih dahulu')
			}

			if (!currentLayer.getBounds().contains(e.latlng)) {
				return alert(`Lokasi berada di luar wilayah ${currentLayer.feature.properties.nama}`);
			}

			var lat = e.latlng.lat.toFixed(6);
			var lng = e.latlng.lng.toFixed(6);

			document.getElementById('latitude').value = lat;
			document.getElementById('longitude').value = lng;

			removeMarker()

			L.marker(e.latlng, {
				icon: customIcon
			}).addTo(map)
		});

		L.Control.geocoder().addTo(map);

		L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			minZoom: 9,
			attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
		}).addTo(map);
	</script>
@endpush
