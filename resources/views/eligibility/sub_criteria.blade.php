@extends('layouts.index')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
@endpush

@section('content')
    <a href="#" class="btn btn-primary mt-3 mr-3 ml-auto" data-toggle="modal" data-target="#modal-add">Tambah</a>
    <div class="clearfix"></div>

    <div class="col-12 my-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Sub Kriteria</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah sub kriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="form-add">
                    <div class="modal-body">
                        <div class="alert alert-danger error-message d-none" role="alert">
                            <ul class="m-0"></ul>
                        </div>

                        <input type="hidden" name="criteria_id" value="{{ $criteria->id }}">

                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Masukan nama sub kriteria"
                                autofocus autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <input autocomplete="off" type="number" name="value" required step="0.01"
                                class="form-control" placeholder="Masukkan nilai">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" name="close-modal" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-edit" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit sub kriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="form-edit">
                    <div class="modal-body">
                        <div class="alert alert-danger error-message d-none" role="alert">
                            <ul class="m-0"></ul>
                        </div>

                        <input type="hidden" name="criteria_id" value="{{ $criteria->id }}">

                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Masukan nama sub kriteria"
                                autofocus autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <input autocomplete="off" type="number" name="value" required step="0.01"
                                class="form-control" placeholder="Masukkan nilai">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" name="close-modal" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" data-id="" name="submit" class="btn btn-warning">Edit Data</button>
                    </div>
                </form>
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
                ajax: '{{ route('eligibility.criterias.sub', $criteria->id) }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'value',
                        name: 'value'
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
                        "targets": [0, 3]
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

            $('#modal-add').on('shown.bs.modal', function() {
                $('#modal-add input[name="criteria_id"]').val('{{ $criteria->id }}');
                $('#modal-add input[name="name"]').trigger('focus');
            });
            var add = $("#modal-add button[name='submit']");
            add.click(function(e) {
                e.preventDefault();

                add.attr("disabled", true);
                add.text('Loading');

                $('.error-message').addClass('d-none');
                $('.error-message ul').empty();

                var form = new FormData(
                    $('#form-add')[0],
                    $('#form-add')[1],
                    $('#form-add')[2]
                    );
                form.append('aksi', 'tambah');

                var opt = {
                    type: 'category',
                    method: 'POST',
                    aksi: 'tambah',
                    url: '{{ route('eligibility.criterias.sub.store', $criteria->id) }}',
                    table: table,
                    element: add
                };

                var txt = {
                    btnText: 'Tambah Data',
                    msgAlert: 'Data berhasil ditambahkan',
                    msgText: 'ditambah'
                };

                requestAjaxPost(opt, form, txt);
            });


            var modalEditNama = $('#modal-edit input[name="name"]');
            var modalEditValue = $('#modal-edit input[name="value"]');
            $('#modal-edit').on('hidden.bs.modal', function() {
                modalEditNama.val("");
                modalEditValue.val("");
            });
            $('#table').on('click', '.edit', function(e) {
                e.preventDefault()

                var url = "{{ route('eligibility.criterias.sub.show', ':id') }}";
                url = url.replace(':id', $(this).data('id'));

                $('#modal-edit button[name="submit"]').attr('data-id', $(this).data('id'));
                modalEditNama.attr("disabled", true);
                modalEditValue.attr("disabled", true);

                $.ajax({
                    url: url,
                    method: "GET",
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(msg) {
                    modalEditNama.attr("disabled", false);
                    modalEditValue.attr("disabled", false);

                    modalEditNama.trigger('focus');

                    $('#modal-edit input[name="criteria_id"]').val('{{ $criteria->id }}');
                    modalEditNama.val(msg.data.name);
                    modalEditValue.val(msg.data.value);
                }).fail(function(err) {
                    alert("Terjadi kesalahan pada server");
                    modalEditNama.attr("disabled", false);
                    modalEditValue.attr("disabled", false);
                });
            });


            var edit = $("#modal-edit button[name='submit']");
            edit.click(function(e) {
                e.preventDefault();

                edit.attr("disabled", true);
                edit.text('Loading');

                $('.error-message').addClass('d-none');
                $('.error-message ul').empty();

                var form = new FormData(
                    $('#form-edit')[0],
                    $('#form-edit')[1],
                    $('#form-edit')[2]
                    );
                form.append('aksi', 'edit');
                form.append('_method', 'PATCH');

                var url = "{{ route('eligibility.criterias.sub.update', ':id') }}";
                url = url.replace(':id', $(this).data('id'));

                var opt = {
                    type: 'category',
                    method: 'POST',
                    aksi: 'edit',
                    url: url,
                    table: table,
                    element: edit
                };

                var txt = {
                    btnText: 'Edit Data',
                    msgAlert: 'Data berhasil diedit',
                    msgText: 'diedit'
                };

                requestAjaxPost(opt, form, txt);
            });


            $('#table').on('click', '.delete', function(event) {
                var url = "{{ route('eligibility.criterias.sub.delete', ':id') }}";
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
