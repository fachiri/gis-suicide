@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => route('dashboard.index'),
        'Maps' => route('dashboard.maps.index'),
				'Geojson' => route('dashboard.maps.geojson.index'),
				'Tambah Data' => null
    ],
])
@section('title', 'Tambah Data')
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center pb-0">
					<h4 class="card-title pl-1">Tambah Data</h4>
				</div>
				<div class="card-body py-4-5 table-responsive px-4 pt-0">
					<x-form.layout.horizontal action="{{ route('dashboard.maps.geojson.store') }}" method="POST" enctype="multipart/form-data">
						<x-form.input layout="horizontal" name="area" label="Nama Wilayah" />
						<x-form.input layout="horizontal" type="file" name="file" label="File Geojson" />
					</x-form.layout.horizontal>					
				</div>
			</div>
		</div>
	</section>
@endsection
