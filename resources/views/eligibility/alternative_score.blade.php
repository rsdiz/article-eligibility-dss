@extends('layouts.index')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
@endpush

@section('content')
    <div class="col-12 my-4">
        <h2>Penilaian</h2>

        <form action="{{ route('eligibility.alternatives.score.update', ['id' => request('id')]) }}" method="POST" class="bg-light p-5 contact-form">
            @csrf
            @method('PATCH')
            @forelse ($criterias as $criteria)
                @php
                    $score = $current_alternative->scores->firstWhere('criteria_id', $criteria->id);
                @endphp

                @if ($criteria->has_option)
                    <div class="form-group">
                        <label class="font-weight-bold">({{ $criteria->code }}) {{ $criteria->name }}</label>
                        <select name="criteria[{{ $criteria->code }}]" class="form-control" required>
                            <option value="-" disabled @selected(!$score)>-- Pilih --</option>
                            @foreach ($criteria->subCriterias as $sub)
                                <option value="{{ $sub->value }}" @selected($score->value == $sub->value)>{{ $sub->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="form-group">
                        <label class="font-weight-bold">({{ $criteria->code }}) {{ $criteria->name }}</label>
                        <input value="{{ $score->value }}" autocomplete="off" type="number" name="criteria[{{ $criteria->code }}]" required
                            step="0.01" class="form-control" placeholder="Masukkan Penilaian">
                    </div>
                @endif
            @empty
                <div class="alert alert-danger">
                    Tidak ada kriteria!
                </div>
            @endforelse
            <div class="form-group">
                <button type="submit" class="btn btn-primary py-2 px-5">Simpan</button>
            </div>
        </form>
    </div>
@endsection
