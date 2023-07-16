@extends('layouts.index')

@section('content')
    <div class="col-12 my-4">
        <h2>Tambah Post</h2>
        <form action="{{ route('postStore') }}" method="POST" class="bg-light p-5 contact-form" enctype="multipart/form-data">
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
                <label>Nama Jurnalis</label>
                <input type="text" name="journalist" value="{{ old('journalist') }}" class="form-control"
                    placeholder="Masukan Nama Jurnalis">
            </div>
            <div class="form-group">
                <label>Kategori</label> <br>
                <select name="category_id" class="form-control" required>
                    <option value='-' disabled @selected(empty(old('category_id')))>-- Pilih Kategori --</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}" @selected(old('category_id') == $item->id)>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="dateInput">Tanggal Kejadian:</label>
                <input type="date" class="form-control" id="dateInput" name="incident_date" value="{{ old('incident_date') }}">
            </div>
            <div class="form-group">
                <label>Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control">
            </div>
            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control"
                    placeholder="Masukan judul">
            </div>
            <div class="form-group">
                <label>Body</label>
                <textarea name="body" id="body" class="form-control" placeholder="Masukan body">{{ old('body') }}</textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary py-2 px-5">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            createCkeditor('body', '{{ asset('vendor/autogrow/plugin.js') }}');
        });
    </script>
@endpush
