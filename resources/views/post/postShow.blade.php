@extends('layouts.index')

@section('content')
<div class="col-xl-8 py-5 px-md-5">
    <div class="row pt-md-4">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif

            <h1>{{ $data->title }}</h1>
            <p class="meta">
                <span><i class="icon-calendar mr-2"></i>{{ date('d-m-Y', strtotime($data->created_at)) }}</span>
                @if (!is_null(Auth::user()))
					@if (Auth::user()->role == 'reader')
                        @if ($check)
                            <a href="{{ route('savedDelete', $data->id) }}" class="btn btn-primary btn-sm ml-3">Tersimpan</a>
                        @else
                            <a href="{{ route('savedStore', $data->id) }}" class="btn btn-primary btn-sm ml-3">Simpan</a>
                        @endif
					@endif
				@endif
            </p>
            <div class="tagcloud">
                @foreach ($data->categories as $item)
                    <a href="{{ route('search', ['category' => $item->id]) }}" class="tag-cloud-link">{{ $item->name }}</a>
                @endforeach
            </div>
            {!! $data->body !!}
        </div>
    </div>
</div>
@include('shared.sidebar')
@endsection