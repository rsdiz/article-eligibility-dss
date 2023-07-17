@extends('layouts.index')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
@endpush

@section('content')
    <div class="col-12 my-4">
        <h2>Hasil Akhir Penilaian</h2>

        <div class="bg-light p-5 contact-form">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="table" style="width: 100%">
                            <thead class="bg-primary text-white">
                                <tr align="center">
                                    <th>Alternatif</th>
                                    <th>Nilai Qi</th>
                                    <th width="15%">Rank</th>
                                    <th>Artikel<br>Pilihan</th>
                            </thead>
                        </table>
                    </div>
                </div>
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
                order: [
                    [2, "asc"]
                ],
                ajax: '{{ route('eligibility.result.show', ['id' => request('id')]) }}',
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'value',
                        name: 'value'
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
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
                        "targets": [1, 2, 3]
                    },
                    {
                        "width": "20%",
                        "targets": 3
                    },
                ]
            });

            $('#table').on('click', '.add', function(event) {
                var url = "{{ route('eligibility.result.featured.add') }}";

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
                    msgAlert: "Tambahkan artikel ke artikel pilihan!",
                    msgText: "tambahkan",
                    msgTitle: 'Data berhasil ditambahkan'
                };

                requestAjaxPostOnly(opt, form, txt);
            });

            $('#table').on('click', '.remove', function(event) {
                var url = "{{ route('eligibility.result.featured.remove') }}";

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
                    msgAlert: "Hapus artikel dari artikel pilihan!",
                    msgText: "hapus",
                    msgTitle: 'Data berhasil dihapus'
                };

                requestAjaxPostOnly(opt, form, txt);
            });
        });
    </script>
@endpush
