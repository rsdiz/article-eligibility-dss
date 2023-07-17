@extends('layouts.index')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
@endpush

@section('content')
    <div class="col-12 my-4">
        <h2>Proses Penilaian</h2>

        <div class="bg-light p-5 contact-form">
            <div class="form-group">
                <label for="dateInput">Artikel</label>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Artikel</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="form-group d-flex align-items-center justify-content-center">
                <a href="{{ route('eligibility.calculate.process.it', ['id' => request('id')]) }}" class="btn btn-primary py-2 px-5">Proses</a>
            </div>
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
                ajax: '{{ route('eligibility.calculate.process', ['id' => request('id')]) }}',
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                columnDefs: [{
                        "className": "text-center",
                        "targets": [0, 2]
                    },
                    {
                        "width": "5%",
                        "targets": 0
                    },
                    {
                        "width": "20%",
                        "targets": 2
                    },
                ]
            });

            $('#table').on('click', '.add', function(event) {
                var url = "{{ route('eligibility.calculate.article.add', ['id' => request('id')]) }}";

                var form = new FormData()
                form.append('post', $(this).data('id'))

                var opt = {
                    url: url,
                    type: 'category',
                    method: 'POST',
                    aksi: 'tambah',
                    table: table
                };

                var txt = {
                    msgAlert: "Tambahkan artikel ke penilaian!",
                    msgText: "tambahkan",
                    msgTitle: 'Data berhasil ditambahkan'
                };

                requestAjaxPostOnly(opt, form, txt);
            });

            $('#table').on('click', '.remove', function(event) {
                var url = "{{ route('eligibility.calculate.article.remove', ['id' => request('id')]) }}";

                var form = new FormData()
                form.append('post', $(this).data('id'))

                var opt = {
                    url: url,
                    type: 'category',
                    method: 'POST',
                    aksi: 'hapus',
                    table: table
                };

                var txt = {
                    msgAlert: "Hapus data dari penilaian!",
                    msgText: "hapus",
                    msgTitle: 'Data berhasil dihapus'
                };

                requestAjaxPostOnly(opt, form, txt);
            });
        });
    </script>
@endpush
