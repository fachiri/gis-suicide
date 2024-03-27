@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Master Pelaku' => route('dashboard.master.perpetrators.index'),
        $perpetrator->name => null,
    ],
])
@section('title', 'Detail Pelaku')
@push('css')
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card shadow-lg">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Detail Pelaku</h4>
					<div class="d-flex gap-2">
						<a href="{{ route('dashboard.master.perpetrators.edit', $perpetrator->uuid) }}" class="btn btn-success btn-sm">
							<i class="bi bi-pencil-square"></i>
							Edit
						</a>
						<x-modal.delete :id="'deleteModal-'. $perpetrator->uuid" :route="route('dashboard.master.perpetrators.destroy', $perpetrator->uuid)" :data="$perpetrator->name" text="Hapus" />
					</div>
				</div>
				<div class="card-body px-4">
					<table class="table-striped table-detail table">
						<tr>
							<th>Nama Pelaku</th>
							<td>{{ $perpetrator->name }}</td>
						</tr>
						<tr>
							<th>Jenis Kelamin</th>
							<td>{{ $perpetrator->genderCriteria->name }}</td>
						</tr>
						<tr>
							<th>Umur</th>
							<td>{{ $perpetrator->age }} ({{ $perpetrator->ageClassCriteria->name }})</td>
						</tr>
						<tr>
							<th>Pendidikan</th>
							<td>{{ $perpetrator->educationCriteria->name }}</td>
						</tr>
						<tr>
							<th>Alamat</th>
							<td>{{ $perpetrator->address }}</td>
						</tr>
						<tr>
							<th>Status Pernikahan</th>
							<td>{{ $perpetrator->maritalStatusCriteria->name }}</td>
						</tr>
						<tr>
							<th>Pekerjaan</th>
							<td>{{ $perpetrator->occupationCriteria->name }}</td>
						</tr>
						<tr>
							<th>Tanggal Kasus</th>
							<td>{{ $perpetrator->incident_date }}</td>
						</tr>
						<tr>
							<th>Cara Bunuh Diri</th>
							<td>{{ $perpetrator->suicide_method }}</td>
						</tr>
						<tr>
							<th>Media / Alat</th>
							<td>{{ $perpetrator->suicide_tool }}</td>
						</tr>
						<tr>
							<th>Motif</th>
							<td>{{ $perpetrator->motiveCriteria->name }}</td>
						</tr>
						<tr>
							<th>Keterangan</th>
							<td>{{ $perpetrator->description ?? '-' }}</td>
						</tr>
						<tr>
							<th>Lokasi</th>
							<td>
								<div id="map" style="height: 250px"></div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</section>
@endsection
@push('scripts')
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
	<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
	<script>
		const gorontaloBounds = L.latLngBounds(
			L.latLng(1.058404, 121.161003),
			L.latLng(0.174064, 123.568904)
		);
		const latitude = '{{ $perpetrator->latitude }}';
		const longitude = '{{ $perpetrator->longitude }}';

		var map = L.map('map', {
			maxBounds: gorontaloBounds,
			maxBoundsViscosity: 1.0
		}).setView([latitude, longitude], 13);
		var marker = L.marker([latitude, longitude]).addTo(map);

		L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			minZoom: 9,
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
