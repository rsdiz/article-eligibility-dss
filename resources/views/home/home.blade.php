@extends('layouts.index')

@section('content')
<div class="col-xl-8 py-5 px-md-5">
    <div class="row pt-md-4">
        @foreach ($posts as $item)    
            <div class="col-md-12">
                <div class="blog-entry ftco-animate d-md-flex">
                    <a href="{{ route('postShow', $item->id) }}" class="img img-2" style="background-image: url({{ asset('storage/'.$item->thumbnail) }});"></a>
                    <div class="text text-2 pl-md-4">
                        <h3 class="mb-2"><a href="{{ route('postShow', $item->id) }}">{{ $item->title }}</a></h3>
                        <div class="meta-wrap">
                            <p class="meta">
                                <span><i class="icon-calendar mr-2"></i>{{ date('d-m-Y', strtotime($item->created_at)) }}</span>
                            </p>
                        </div>
                        <div class="tagcloud">
                            @foreach ($item->categories as $row)
                                <a href="{{ route('search', ['category' => $row->id]) }}" class="tag-cloud-link">{{ $row->name }}</a>
                            @endforeach
                        </div>
                        <p class="mb-4">
                            @if (strlen($item->description) > 150)
                                {{ substr($item->description, 0, 150) . '...' }}
                            @else
                                {{ $item->description }}
                            @endif
                        </p>
                        <p><a href="{{ route('postShow', $item->id) }}" class="btn-custom">Baca selengkapnya <span class="ion-ios-arrow-forward"></span></a></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-12">
            <div class="block-27 text-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@include('shared.sidebar')
@endsection