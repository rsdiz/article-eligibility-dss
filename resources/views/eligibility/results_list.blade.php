@extends('layouts.index')

@section('content')
    <div class="col-12 my-4">

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th class="center">Tanggal</th>
                        <th class="center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $calculation)
                        <tr align="center">
                            <td width="5%">{{ $loop->iteration }}</td>
                            <td align="left">{{ $calculation->title }}</td>
                            <td>{{ $calculation->headline_date }}</td>
                            <td><a href="{{ route('eligibility.result.show', ['id' => $calculation->id])}} " class="btn btn-sm mr-2 btn-success">Lihat</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
