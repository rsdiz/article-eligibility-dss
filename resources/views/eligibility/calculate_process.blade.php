@extends('layouts.index')

@section('content')
    <div class="col-12 my-4">
        @forelse ($data as $result)
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> {{ $result['title'] }}</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead class="bg-primary text-white">
                                <tr align="center">
                                    @if (!array_key_exists('hide_name', $result))
                                        <th width="5%" rowspan="2">No</th>
                                        <th>Nama Alternatif</th>
                                    @endif

                                    @if (array_key_exists('header', $result))
                                        @if (is_array($result['header']))
                                            @foreach ($result['header'] as $header)
                                                <th>{!! $header !!}</th>
                                            @endforeach
                                        @else
                                            @foreach ($result['value'] as $value)
                                                <th>{{ $result['header'] }}<sub>{{ $loop->iteration }}</sub></th>
                                            @endforeach
                                        @endif
                                    @else
                                        @forelse ($criterias as $criteria)
                                            <th>{{ $criteria->code }}</th>
                                        @empty
                                            <th>Tidak ada kriteria</th>
                                        @endforelse
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($result['show'] == 'vertical')
                                    @forelse ($alternatives as $alternative)
                                        <tr align="center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td align="left">{{ $alternative->post->title }}</td>
                                            @if ($result['type'] == 0)
                                                @forelse ($criterias as $criteria)
                                                    <td>{{ $result['value'][$criteria->id][$alternative->id] }}</td>
                                                @empty
                                                    <td>-</td>
                                                @endforelse
                                            @else
                                                <td>{{ $result['value'][$alternative->id] }}</td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr align="center">
                                            Tidak ada alternatif
                                        </tr>
                                    @endforelse
                                @else
                                <tr align="center">
                                    @if ($result['type'] == 0)
                                        @forelse ($result['value'] as $value)
                                            <td>{{ $value }}</td>
                                        @empty
                                            <td>Kosong</td>
                                        @endforelse
                                    @else
                                        @forelse ($alternatives as $alternative)
                                            @if ($result['type'] == 1)
                                                <td>{{ $result['value'][$alternative->id] }}</td>
                                            @else
                                                @forelse ($criterias as $criteria)
                                                    <td>{{ $result['value'][$criteria->id][$alternative->id] }}</td>
                                                @empty
                                                    <td>-</td>
                                                @endforelse
                                            @endif
                                        @empty
                                            Tidak ada alternatif
                                        @endforelse
                                    @endif
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            Kosong
        @endforelse

        <div class="form-group d-flex align-items-center justify-content-center">
            <a href="{{ route('eligibility.calculate') }}" class="btn btn-primary py-2 px-5 mr-2">Kembali</a>
            <a href="{{ route('eligibility.result.show', ['id' => request('id')]) }}" class="btn btn-primary py-2 px-5 ml-2">Lihat Hasil</a>
        </div>
    </div>
@endsection
