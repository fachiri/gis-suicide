@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Master Pelaku' => route('dashboard.master.perpetrators.index'),
        'Tambah Data' => null,
    ],
])
@section('title', 'Tambah Pelaku')
@push('css')
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Form Tambah Pelaku</h4>
				</div>
				<div class="card-body px-4">
					<x-form.layout.horizontal action="{{ route('dashboard.master.perpetrators.store') }}" method="POST">
						<x-form.input layout="horizontal" name="name" label="Nama Pelaku" placeholder="Nama Pelaku.." />
						<x-form.select layout="horizontal" name="gender" label="Jenis Kelamin" :options="[
						    (object) [
						        'label' => App\Constants\UserGender::MALE,
						        'value' => App\Constants\UserGender::MALE,
						    ],
						    (object) [
						        'label' => App\Constants\UserGender::FEMALE,
						        'value' => App\Constants\UserGender::FEMALE,
						    ],
						]" />
						<x-form.input type="number" layout="horizontal" name="age" label="Umur" placeholder="Umur.." />
						<x-form.select layout="horizontal" name="education" label="Pendidikan" :options="[
						    (object) [
						        'label' => 'SD',
						        'value' => 'SD',
						    ],
						    (object) [
						        'label' => 'SMP',
						        'value' => 'SMP',
						    ],
						    (object) [
						        'label' => 'SMA',
						        'value' => 'SMA',
						    ],
						    (object) [
						        'label' => 'Diploma',
						        'value' => 'Diploma',
						    ],
						    (object) [
						        'label' => 'Sarjana',
						        'value' => 'Sarjana',
						    ],
						    (object) [
						        'label' => 'Magister',
						        'value' => 'Magister',
						    ],
						    (object) [
						        'label' => 'Doktor',
						        'value' => 'Doktor',
						    ],
						]" />
						<x-form.textarea layout="horizontal" name="address" label="Alamat" placeholder="Alamat.." />
						<x-form.select layout="horizontal" name="marital_status" label="Status Pernikahan" :options="[
						    (object) [
						        'label' => 'Belum Menikah',
						        'value' => 'Belum Menikah',
						    ],
						    (object) [
						        'label' => 'Sudah Menikah',
						        'value' => 'Sudah Menikah',
						    ],
						]" />
						<x-form.input layout="horizontal" name="occupation" label="Pekerjaan" placeholder="Pekerjaan.." />
						<x-form.input type="date" layout="horizontal" name="incident_date" label="Tanggal Kasus" placeholder="Tanggal Kasus.." />
						<x-form.input layout="horizontal" name="suicide_method" label="Cara Bunuh Diri" placeholder="Cara Bunuh Diri.." />
						<x-form.input layout="horizontal" name="suicide_tool" label="Media/Alat" placeholder="Media/Alat.." />
						<x-form.textarea layout="horizontal" name="description" label="Keterangan" placeholder="Keterangan.." />
						<div class="col-md-4">
							<label>Lokasi</label>
						</div>
						<div class="col-md-8 form-group">
							<div class="mb-3">
								<div id="map" style="height: 280px"></div>
							</div>
							<div class="row">
								<div class="col-6">
									<x-form.input name="latitude" placeholder="Latitude" :readonly="true" />
								</div>
								<div class="col-6">
									<x-form.input name="longitude" placeholder="Longitude" :readonly="true" />
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
	<script>
		var map = L.map('map').setView([0.5400, 123.0600], 13);
		var marker = L.marker([0.5400, 123.0600]).addTo(map);

		L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 19,
			attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
		}).addTo(map);

		L.Control.geocoder().addTo(map);

		map.on('click', function(e) {
			var lat = e.latlng.lat.toFixed(6);
			var lng = e.latlng.lng.toFixed(6);

			document.getElementById('latitude').value = lat;
			document.getElementById('longitude').value = lng;

			marker.setLatLng(e.latlng);
		});
	</script>
@endpush
