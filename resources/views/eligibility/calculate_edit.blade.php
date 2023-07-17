@extends('layouts.index')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
@endpush

@section('content')
    <div class="col-12 my-4">
        <h2>Tambah Penilaian</h2>
        <form action="{{ route('eligibility.calculate.update', ['id' => request('id')]) }}" method="POST" class="bg-light p-5 contact-form">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="pl-3 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @csrf
            <div class="form-group">
                <label>Judul Penilaian</label>
                <input type="text" name="title" value="{{ $data->title ?? '' }}" class="form-control"
                    placeholder="Masukan Judul Penilaian">
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" class="form-control" required>
                    <option value='-' disabled @selected(empty($data->category_id))>-- Pilih Kategori --</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}" @selected($data->category_id == $item->id)>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="dateInput">Tanggal Headline</label>
                <input type="date" class="form-control" id="dateInput" name="headline_date" value="{{ $data->headline_date }}">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary py-2 px-5">Simpan</button>
            </div>
        </form>
    </div>
@endsection
