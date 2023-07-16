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
                        <th>Kode Kriteria</th>
                        <th>Nama Kriteria</th>
                        <th>Bobot</th>
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
                    <h5 class="modal-title">Tambah kriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="form-add">
                    <div class="modal-body">
                        <div class="alert alert-danger error-message d-none" role="alert">
                            <ul class="m-0"></ul>
                        </div>

                        <div class="form-group">
                            <input type="text" name="code" maxlength="10" class="form-control"
                                placeholder="Masukan kode kriteria" autofocus autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Masukan nama kriteria"
                                autofocus autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <select name="type" class="form-control" required>
                                <option disabled selected>-- Pilih Tipe --</option>
                                <option value="benefit">Benefit</option>
                                <option value="cost">Cost</option>
                            </select>
                        </div>

                        <div class="form-group">
                            {{-- <label class="font-weight-bold">Bobot</label> --}}
                            <input autocomplete="off" type="number" name="weight" required step="0.01"
                                class="form-control" placeholder="Masukkan bobot kriteria">
                        </div>

                        <div class="form-group">
                            <select name="has_option" class="form-control" required="">
                                <option selected disabled>-- Pilih Cara Penilaian --</option>
                                <option value="0">Input Langsung</option>
                                <option value="1">Pilihan Sub Kriteria</option>
                            </select>
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
                    <h5 class="modal-title">Edit kriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="form-edit">
                    <div class="modal-body">
                        <div class="alert alert-danger error-message d-none" role="alert">
                            <ul class="m-0"></ul>
                        </div>

                        <div class="form-group">
                            <input type="text" name="code" maxlength="10" class="form-control"
                                placeholder="Masukan kode kriteria" autofocus autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="name" class="form-control"
                                placeholder="Masukan nama kriteria" autofocus autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <select name="type" class="form-control" required>
                                <option value='-' disabled selected>-- Pilih Tipe --</option>
                                <option value="benefit">Benefit</option>
                                <option value="cost">Cost</option>
                            </select>
                        </div>

                        <div class="form-group">
                            {{-- <label class="font-weight-bold">Bobot</label> --}}
                            <input autocomplete="off" type="number" name="weight" required step="0.01"
                                class="form-control" placeholder="Masukkan bobot kriteria">
                        </div>

                        <div class="form-group">
                            <select name="has_option" class="form-control" required="">
                                <option value='-' selected disabled>-- Pilih Cara Penilaian --</option>
                                <option value="0">Input Langsung</option>
                                <option value="1">Pilihan Sub Kriteria</option>
                            </select>
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
                ajax: '{{ route('eligibility.criterias') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'weight',
                        name: 'weight'
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
                        "targets": [0, 1, 3, 4]
                    },
                    {
                        "width": "5%",
                        "targets": 0
                    },
                    {
                        "width": "20%",
                        "targets": 4
                    },
                ]
            });

            $('#modal-add').on('shown.bs.modal', function() {
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
                    $('#form-add')[2],
                    $('#form-add')[3],
                    $('#form-add')[4]
                    );
                form.append('aksi', 'tambah');

                var opt = {
                    type: 'category',
                    method: 'POST',
                    aksi: 'tambah',
                    url: '{{ route('eligibility.criterias.store') }}',
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
            var modalEditCode = $('#modal-edit input[name="code"]');
            var modalEditWeight = $('#modal-edit input[name="weight"]');
            var modalEditType = $('#modal-edit select[name="type"]');
            var modalEditHasOpt = $('#modal-edit select[name="has_option"]');
            $('#modal-edit').on('hidden.bs.modal', function() {
                modalEditNama.val("");
                modalEditCode.val("");
                modalEditWeight.val("");
                modalEditType.val('-');
                modalEditHasOpt.val('-');
            });
            $('#table').on('click', '.edit', function(e) {
                e.preventDefault()

                var url = "{{ route('eligibility.criterias.show', ':id') }}";
                url = url.replace(':id', $(this).data('id'));

                $('#modal-edit button[name="submit"]').attr('data-id', $(this).data('id'));
                modalEditNama.attr("disabled", true);
                modalEditCode.attr("disabled", true);
                modalEditWeight.attr("disabled", true);
                modalEditType.attr("disabled", true);
                modalEditHasOpt.attr("disabled", true);

                $.ajax({
                    url: url,
                    method: "GET",
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(msg) {
                    modalEditNama.attr("disabled", false);
                    modalEditCode.attr("disabled", false);
                    modalEditWeight.attr("disabled", false);
                    modalEditType.attr("disabled", false);
                    modalEditHasOpt.attr("disabled", false);

                    modalEditNama.trigger('focus');

                    modalEditNama.val(msg.data.name);
                    modalEditCode.val(msg.data.code);
                    modalEditWeight.val(msg.data.weight);
                    modalEditType.val(msg.data.type);
                    modalEditHasOpt.val(msg.data.has_option);
                }).fail(function(err) {
                    alert("Terjadi kesalahan pada server");
                    modalEditNama.attr("disabled", false);
                    modalEditCode.attr("disabled", false);
                    modalEditWeight.attr("disabled", false);
                    modalEditType.attr("disabled", false);
                    modalEditHasOpt.attr("disabled", false);
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
                    $('#form-edit')[2],
                    $('#form-edit')[3],
                    $('#form-edit')[4]
                    );
                form.append('aksi', 'edit');
                form.append('_method', 'PATCH');

                var url = "{{ route('eligibility.criterias.update', ':id') }}";
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
                var url = "{{ route('eligibility.criterias.delete', ':id') }}";
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
