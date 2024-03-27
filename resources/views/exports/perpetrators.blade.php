@extends('layouts.export')
@section('title', 'Laporan Pelaku')
@section('content')
	<table class="table-striped table">
		<thead>
			<tr>
				<th>NO.</th>
				<th>NAMA PELAKU</th>
				<th>JENIS KELAMIN</th>
				<th>UMUR</th>
				<th>PENDIDIKAN</th>
				<th>ALAMAT</th>
				<th>STATUS PERKAWINAN</th>
				<th>PEKERJAAN</th>
				<th>HARI/TGL/JAM KASUS</th>
				<th>CARA BN</th>
				<th>MEDIA/ALAT</th>
				<th>KET.</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($perpetrators as $perpetrator)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $perpetrator->name }}</td>
					<td>{{ $perpetrator->genderCriteria->name }}</td>
					<td>{{ $perpetrator->age }} ({{ $perpetrator->ageClassCriteria->name }})</td>
					<td>{{ $perpetrator->educationCriteria->name }}</td>
					<td>{{ $perpetrator->address }}</td>
					<td>{{ $perpetrator->maritalStatusCriteria->name }}</td>
					<td>{{ $perpetrator->occupationCriteria->name }}</td>
					<td>{{ \Carbon\Carbon::parse($perpetrator->incident_date)->isoFormat('dddd, DD MMMM Y') }}</td>
					<td>{{ $perpetrator->suicide_method }}</td>
					<td>{{ $perpetrator->suicide_tool }}</td>
					<td>{{ $perpetrator->description }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection
