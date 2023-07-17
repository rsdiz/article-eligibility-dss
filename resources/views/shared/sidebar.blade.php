<div class="col-xl-4 sidebar ftco-animate bg-light pt-5">
    <div class="sidebar-box pt-md-4">
        <form action="{{ route('search') }}" method="GET" class="search-form">
            <div class="form-group">
                <span class="icon icon-search"></span>
                <input type="text" name="q" class="form-control" placeholder="Cari berita..." value="{{ Request::input('q') }}">
            </div>
        </form>
    </div>
    <div class="sidebar-box ftco-animate">
        <h3 class="sidebar-heading">Kategori</h3>
        <ul class="categories">
            @foreach ($categories as $item)
                <li><a href="{{ route('search', ['category' => $item->id]) }}">{{ $item->name }}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="sidebar-box ftco-animate">
        <h3 class="sidebar-heading">Berita Terbaru</h3>
        @foreach ($newPosts as $item)
            <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url({{ asset('storage/'.$item->thumbnail) }});"></a>
                <div class="text">
                    <h3 class="heading"><a href="{{ route('postShow', $item->id) }}">{{ $item->title }}</a></h3>
                    <div class="meta">
                        <div><a href="#"><span class="icon-calendar"></span> {{ date('d-m-Y', strtotime($item->created_at)) }}</a></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="sidebar-box ftco-animate">
        <h3 class="sidebar-heading">Berita Pilihan</h3>
        @foreach ($featuredPosts as $item)
            <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url({{ asset('storage/'.$item->thumbnail) }});"></a>
                <div class="text">
                    <h3 class="heading"><a href="{{ route('postShow', $item->id) }}">{{ $item->title }}</a></h3>
                    <div class="meta">
                        <div><a href="#"><span class="icon-calendar"></span> {{ date('d-m-Y', strtotime($item->created_at)) }}</a></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
