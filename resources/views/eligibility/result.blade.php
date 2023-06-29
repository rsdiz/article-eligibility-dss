@extends('layouts.index')

@section('content')
    <div class="col-12 my-4">
		<div class="card mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Hasil Akhir Perankingan Metode VIKOR</h6>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" width="100%" cellspacing="0">
						<thead class="bg-primary text-white">
							<tr align="center">
								<th>Nama Alternatif</th>
								<th>Nilai Qi</th>
								<th width="15%">Rank</th>
						</thead>
                        <tbody>
                            @foreach ($data as $result)
                                <tr align="center">
                                    <td align="left">{{ $result->alternative->name }}</td>
                                    <td>{{ $result->value }}</td>
                                    <td>{{ $loop->iteration }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
