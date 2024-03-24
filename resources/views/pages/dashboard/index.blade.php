@extends('layouts.dashboard', [
    'breadcrumbs' => [
        'Dasbor' => null,
    ],
])
@section('title', 'Dasbor')
@push('css')
	<link rel="stylesheet" href="{{ asset('css/iconly.css') }}">
@endpush
@section('content')
	<section class="row">
		<div class="col-12">
			{{-- <div class="row">
				<div class="col-6 col-lg-3 col-md-6">
					<div class="card">
						<div class="card-body py-4-5 px-4">
							<div class="row">
								<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
									<div class="stats-icon purple mb-2">
										<i class="iconly-boldShow"></i>
									</div>
								</div>
								<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
									<h6 class="text-muted font-semibold">Profile Views</h6>
									<h6 class="mb-0 font-extrabold">112.000</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6 col-lg-3 col-md-6">
					<div class="card">
						<div class="card-body py-4-5 px-4">
							<div class="row">
								<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
									<div class="stats-icon blue mb-2">
										<i class="iconly-boldProfile"></i>
									</div>
								</div>
								<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
									<h6 class="text-muted font-semibold">Followers</h6>
									<h6 class="mb-0 font-extrabold">183.000</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6 col-lg-3 col-md-6">
					<div class="card">
						<div class="card-body py-4-5 px-4">
							<div class="row">
								<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
									<div class="stats-icon green mb-2">
										<i class="iconly-boldAdd-User"></i>
									</div>
								</div>
								<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
									<h6 class="text-muted font-semibold">Following</h6>
									<h6 class="mb-0 font-extrabold">80.000</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6 col-lg-3 col-md-6">
					<div class="card">
						<div class="card-body py-4-5 px-4">
							<div class="row">
								<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
									<div class="stats-icon red mb-2">
										<i class="iconly-boldBookmark"></i>
									</div>
								</div>
								<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
									<h6 class="text-muted font-semibold">Saved Post</h6>
									<h6 class="mb-0 font-extrabold">112</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> --}}
			<div class="row">
				<div class="col-9">
					<div class="card">
						<form action="{{ route('dashboard.index') }}" method="GET" class="card-header d-flex justify-content-between align-items-start" id="monthly-cases">
							<h4>Jumlah Kasus BN Tahun {{ request('year') }}</h4>
							<select name="year" id="year" class="form-select form-select-sm" style="width: 100px" onchange="document.getElementById('monthly-cases').submit()">
								@for ($i = $oldestCaseYear; $i <= $currentYear; $i++)
									<option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
								@endfor
							</select>
						</form>
						<div class="card-body">
							<div id="chart-monthly-case"></div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-3">
					<div class="card">
						<div class="card-header">
							<h4>Pelaku Berdasarkan Jenis Kelamin</h4>
						</div>
						<div class="card-body">
							<div id="chart-perpetrators-gender"></div>
						</div>
					</div>
				</div>
			</div>
			<div id="kasus-per-wilayah" class="row">
				@foreach ($maps as $map)
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h4>Kasus Per-Wilayah {{ $map['area'] }}</h4>
							</div>
							<div class="card-body">
								<div class="row">
									@foreach ($map['features'] as $feature)
										<div class="col-6">
											<div class="row">
												<div class="col-7">
													<div class="d-flex align-items-center">
														<svg class="bi text-primary" width="32" height="32" fill="blue" style="width:10px">
															<use xlink:href="assets/static/images/bootstrap-icons.svg#circle-fill" />
														</svg>
														<h5 class="mb-0 ms-3">{{ $feature['properties']['nama'] }}</h5>
													</div>
												</div>
												<div class="col-5">
													<h5 class="mb-0 text-end">{{ $feature['properties']['count'] }}</h5>
												</div>
												<div class="col-12">
													<div id="chart-{{ $feature['properties']['fid'] }}"></div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>
@endsection
@push('scripts')
	<script src="{{ asset('js/extensions/apexcharts.min.js') }}"></script>
	<script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js'></script>
	<script>
		const monthlyCases = Object.values(@json($monthlyCases));

		new ApexCharts(
			document.querySelector("#chart-monthly-case"), {
				annotations: {
					position: "back",
				},
				dataLabels: {
					enabled: false,
				},
				chart: {
					type: "bar",
					height: 300,
				},
				fill: {
					opacity: 1,
				},
				plotOptions: {},
				series: [{
					name: "Jumlah Kasus",
					data: monthlyCases,
				}, ],
				colors: "#435ebe",
				xaxis: {
					categories: [
						"Jan",
						"Feb",
						"Mar",
						"Apr",
						"May",
						"Jun",
						"Jul",
						"Aug",
						"Sep",
						"Oct",
						"Nov",
						"Dec",
					],
				},
			}
		).render()

		new ApexCharts(
			document.getElementById("chart-perpetrators-gender"), {
				series: [+'{{ $perpetratorMaleCount }}', +'{{ $perpetratorFemaleCount }}'],
				labels: ["{{ App\Constants\UserGender::MALE }}", "{{ App\Constants\UserGender::FEMALE }}"],
				colors: ["#435ebe", "#55c6e8"],
				chart: {
					type: "donut",
					width: "100%",
					height: "350px",
				},
				legend: {
					position: "bottom",
				},
				plotOptions: {
					pie: {
						donut: {
							size: "30%",
						},
					},
				},
			}
		).render()
	</script>
	@foreach ($maps as $map)
		@foreach ($map['features'] as $feature)
			<script>
				new ApexCharts(
					document.getElementById('chart-{{ $feature["properties"]["fid"] }}'), {
						series: [{
							name: "Jumlah Kasus",
							data: @json($feature["properties"]["graph"]["data"]),
						}, ],
						chart: {
							height: 80,
							type: "area",
							toolbar: {
								show: false,
							},
						},
						colors: ['{{ $feature["properties"]["graph"]["color"] }}'],
						stroke: {
							width: 2,
						},
						grid: {
							show: false,
						},
						dataLabels: {
							enabled: false,
						},
						xaxis: {
							categories: @json($feature["properties"]["graph"]["categories"]),
							axisBorder: {
								show: false,
							},
							axisTicks: {
								show: false,
							},
							labels: {
								show: false,
							},
						},
						show: false,
						yaxis: {
							labels: {
								show: false,
							},
						},
						tooltip: {
							x: {
								format: "text",
							},
						},
					}
				).render()
			</script>
		@endforeach
	@endforeach
@endpush
