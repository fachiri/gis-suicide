@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Maps' => route('dashboard.maps.index'),
        'Geojson' => null,
    ],
])
@section('title', 'Geojson')
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card shadow-lg">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title pl-1">Geojson</h4>
					<div class="d-flex gap-2">
						<a href="{{ route('dashboard.maps.geojson.create') }}" class="btn btn-primary btn-sm">
							<i class="bi bi-plus-square"></i>
							Tambah Data
						</a>
					</div>
				</div>
				<div class="card-body table-responsive px-4">
					<table class="table-striped data-table table">
						<thead>
							<tr>
								<th>Nama Wilayah</th>
								<th>File</th>
								<th style="white-space: nowrap">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($geojsons as $geojson)
								<tr>
									<td>{{ $geojson->area }}</td>
									<td>{{ $geojson->file }}</td>
									<td>
										<x-modal.delete :id="'deleteModal-' . $geojson->uuid" :route="route('dashboard.maps.geojson.destroy', $geojson->uuid)" :data="$geojson->area" />
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
@endsection
