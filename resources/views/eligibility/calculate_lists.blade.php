@extends('layouts.index')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
@endpush

@section('content')
    <a href="{{ route('eligibility.calculate.add') }}" class="btn btn-primary mt-3 mr-3 ml-auto">Tambah</a>
    <div class="clearfix"></div>

    <div class="col-12 my-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            var table = $('#table').DataTable({
                processing: true,
                ajax: '{{ route('eligibility.calculate') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'headline_date',
                        name: 'headline_date'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                columnDefs: [{
                        "className": "text-center",
                        "targets": [0, 2, 3]
                    },
                    {
                        "width": "5%",
                        "targets": 0
                    },
                    {
                        "width": "20%",
                        "targets": 3
                    },
                ]
            });

            $('#table').on('click', '.delete', function(event) {
                var url = "{{ route('eligibility.calculate.delete', ':id') }}";
                url = url.replace(':id', $(this).data('id'));

                var opt = {
                    url: url,
                    type: 'category',
                    method: 'DELETE',
                    aksi: 'hapus',
                    table: table
                };

                var txt = {
                    msgAlert: "Data akan dihapus!",
                    msgText: "hapus",
                    msgTitle: 'Data berhasil dihapus'
                };

                requestAjaxDelete(opt, txt);
            });
        });
    </script>
@endpush
