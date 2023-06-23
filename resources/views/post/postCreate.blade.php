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
            <label>Judul</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="Masukan judul">
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" placeholder="Masukan deskripsi">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label>Body</label>
            <textarea name="body" id="body" class="form-control" placeholder="Masukan body">{{ old('body') }}</textarea>
        </div>
        <div class="form-group">
            <label>Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control">
        </div>
        <div class="form-group">
            <label>Kategori</label> <br>
            @foreach ($categories as $item)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="categories[]" type="checkbox" id="check-{{ $item->id }}" value="{{ $item->id }}">
                    <label class="form-check-label" for="check-{{ $item->id }}">{{ $item->name }}</label>
                </div>
            @endforeach
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
   createCkeditor('body', '{{ asset("vendor/autogrow/plugin.js") }}');
});
</script>
@endpush