@extends('layouts.index')

@push('styles')
@endpush

@section('content')
    <div class="col-12 my-4">
        <div class="row m-4">
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <h3 class="mb-0 text-dark">Kriteria</h3>
                        <p class="card-text mb-auto">Kriteria adalah faktor atau atribut yang digunakan untuk mengevaluasi atau mengukur kinerja atau kualitas alternatif yang tersedia. Pemilihan kriteria yang tepat sangat penting dalam SPK karena akan mempengaruhi hasil akhir dari pengambilan keputusan.</p>
                        <a href="{{ route('eligibility.criterias') }}">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <h3 class="mb-0 text-dark">Alternatif</h3>
                        <p class="card-text mb-auto">Alternatif adalah pilihan-pilihan atau opsi-opsi yang tersedia untuk dipilih atau dipertimbangkan dalam proses pengambilan keputusan. Pemilihan alternatif yang tepat harus didasarkan pada pemenuhan kriteria yang telah ditetapkan.</p>
                        <a href="{{ route('eligibility.alternatives') }}">Lihat</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-4">
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <h3 class="mb-0 text-dark">Perhitungan</h3>
                        <p class="card-text mb-auto">Pilih mana saja Alternatif yang ingin diproses pada Sistem Pendukung Keputusan menggunakan metode VIKOR.</p>
                        <a href="{{ route('eligibility.calculate') }}">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <h3 class="mb-0 text-dark">Hasil Akhir</h3>
                        <p class="card-text mb-auto">Ranking dari alternatif yang sudah dihitung dapat dilihat disini. Pilih alternatif mana yang akan dijadikan artikel pilihan yang akan tampil pada menu berita pilihan!</p>
                        <a href="{{ route('eligibility.results') }}">Lihat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
