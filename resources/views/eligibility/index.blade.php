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
                        <p class="card-text mb-auto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam quas,
                            velit
                            modi culpa quia, dolore sunt quos temporibus molestiae quae, esse quidem? Pariatur rem quidem
                            debitis ducimus accusamus fugiat quasi!</p>
                        <a href="{{ route('eligibility.criterias') }}">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <h3 class="mb-0 text-dark">Alternatif</h3>
                        <p class="card-text mb-auto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium
                            laudantium eveniet quod error minus aliquid harum fugit eius. Repellat dolor unde odio maxime
                            omnis.
                            Tempora ut illo quisquam voluptatem officiis.</p>
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
                        <p class="card-text mb-auto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam quas,
                            velit
                            modi culpa quia, dolore sunt quos temporibus molestiae quae, esse quidem? Pariatur rem quidem
                            debitis ducimus accusamus fugiat quasi!</p>
                        <a href="{{ route('eligibility.calculate') }}">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <h3 class="mb-0 text-dark">Hasil Akhir</h3>
                        <p class="card-text mb-auto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium
                            laudantium eveniet quod error minus aliquid harum fugit eius. Repellat dolor unde odio maxime
                            omnis.
                            Tempora ut illo quisquam voluptatem officiis.</p>
                        <a href="#">Lihat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
