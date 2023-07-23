@extends('layouts.index')

@section('content')
<div class="row m-auto">
    <div class="col-md-12">
        <div class="mt-5">
            <h2 class="text-center">Kabarin | Login</h2>
            <form action="{{ route('loginPost') }}" method="POST" class="bg-light p-5 contact-form">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="pl-3 mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('dangerLogin'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('dangerLogin') }}
                    </div>
                @endif

                @csrf
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Masukan email">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Masukan password">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary py-2 px-5">Login</button>
                </div>
            </form>
        </div>
    </div>
    {{-- <div class="col-md-6">
        <div class="mt-5 mb-5">
            <h2 class="text-center">Kabarin | Register</h2>
            <form action="{{ route('registerPost') }}" method="POST" class="bg-light p-5 contact-form">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="pl-3 mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('dangerRegister'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('dangerRegister') }}
                    </div>
                @endif

                @csrf
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Masukan nama">
                </div>
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Masukan email">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Masukan password">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary py-2 px-5">Register</button>
                </div>
            </form>
        </div>
    </div> --}}
</div>
@endsection
