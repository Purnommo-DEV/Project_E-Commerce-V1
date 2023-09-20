@extends('Back.layout.master', ['title' => 'Dashboard'])
@section('konten-admin')
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Produk</h6>
                                    <h6 class="font-extrabold mb-0">{{ $total_produk }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Pesanan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $total_pesanan }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Pelanggan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $total_pelanggan }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-5" style="padding-left: 10%!important;">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="{{ asset('Back/assets/images/faces/2.jpg') }}" alt="Face 1">
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold">{{ Auth::user()->name }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Grafik Penjualan</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-profile-visit"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Produk Terlaris</h4>
                    </div>
                    <div class="card-content pb-4">
                        @foreach ($produk_banyak_terjual as $data_produk_banyak_terjual)
                            <div class="recent-message d-flex px-4 py-3">
                                <div class="avatar avatar-lg">
                                    <img
                                        src="{{ asset('storage/' . $data_produk_banyak_terjual->relasi_produk->relasi_gambar->path) }}">
                                </div>
                                <div class="name ms-4">
                                    <h5 class="mb-1">{{ $data_produk_banyak_terjual->relasi_produk->nama_produk }}</h5>
                                    </h5>
                                    <h6 class="text-muted mb-0">Terjual :
                                        {{ $data_produk_banyak_terjual->alias_total_terjual }}
                                    </h6>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        var data_total_penjualan = @json($total_penjualan);
        var data_bulan_memiliki_penjualan = @json($bulan_memiliki_penjualan);

        var optionsProfileVisit = {
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
                name: "Penjualan",
                data: data_total_penjualan,
            }, ],
            colors: "#435ebe",
            xaxis: {
                categories: data_bulan_memiliki_penjualan
            },
        };

        var chartProfileVisit = new ApexCharts(
            document.querySelector("#chart-profile-visit"),
            optionsProfileVisit
        );
        chartProfileVisit.render();
    </script>
@endsection
