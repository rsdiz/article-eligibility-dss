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
                        <th>Artikel</th>
                        <th>Penilaian</th>
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
                    <h5 class="modal-title">Tambah Alternatif</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="form-add">
                    <div class="modal-body">
                        <div class="alert alert-danger error-message d-none" role="alert">
                            <ul class="m-0"></ul>
                        </div>

                        <div class="alert alert-primary">
                            Alternatif
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Artikel</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukan artikel"
                                autofocus autocomplete="off" required>
                        </div>

                        <div class="alert alert-info">
                            Penilaian
                        </div>

                        @forelse ($criterias as $criteria)
                            @if ($criteria->has_option)
                                <div class="form-group">
                                    <label class="font-weight-bold">({{ $criteria->code }}) {{ $criteria->name }}</label>
                                    <select name="criteria[{{ $criteria->code }}]" class="form-control" required>
                                        <option value="-" disabled selected>-- Pilih --</option>
                                        @foreach ($criteria->subCriterias as $sub)
                                            <option value="{{ $sub->value }}">{{ $sub->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="form-group">
                                    <label class="font-weight-bold">({{ $criteria->code }}) {{ $criteria->name }}</label>
                                    <input autocomplete="off" type="number" name="criteria[{{ $criteria->code }}]" required
                                        step="0.01" class="form-control" placeholder="Masukkan Penilaian">
                                </div>
                            @endif
                        @empty
                            <div class="alert alert-danger">
                                Tidak ada kriteria!
                            </div>
                        @endforelse
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
                    <h5 class="modal-title">Edit Alternatif</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="form-edit">
                    <div class="modal-body">
                        <div class="alert alert-danger error-message d-none" role="alert">
                            <ul class="m-0"></ul>
                        </div>

                        <div class="alert alert-primary">
                            Alternatif
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Artikel</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukan artikel"
                                autofocus autocomplete="off" required>
                        </div>

                        <div class="alert alert-info">
                            Penilaian
                        </div>

                        @forelse ($criterias as $criteria)
                            @if ($criteria->has_option)
                                <div class="form-group">
                                    <label class="font-weight-bold">({{ $criteria->code }}) {{ $criteria->name }}</label>
                                    <select name="criteria[{{ $criteria->code }}]" class="form-control" required>
                                        <option value="-" disabled selected>-- Pilih --</option>
                                        @foreach ($criteria->subCriterias as $sub)
                                            <option value="{{ $sub->value }}">{{ $sub->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="form-group">
                                    <label class="font-weight-bold">({{ $criteria->code }}) {{ $criteria->name }}</label>
                                    <input autocomplete="off" type="number" name="criteria[{{ $criteria->code }}]" required
                                        step="0.01" class="form-control" placeholder="Masukkan Penilaian">
                                </div>
                            @endif
                        @empty
                            <div class="alert alert-danger">
                                Tidak ada kriteria!
                            </div>
                        @endforelse
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
                ajax: '{{ route('eligibility.alternatives') }}',
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
                        data: 'result_text',
                        name: 'result_text',
                        orderable: false,
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
                    @foreach ($criterias as $criteria)
                        $('#form-add')[{{ $loop->iteration }}],
                    @endforeach
                    );
                form.append('aksi', 'tambah');

                var opt = {
                    type: 'category',
                    method: 'POST',
                    aksi: 'tambah',
                    url: '{{ route('eligibility.alternatives.store') }}',
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

            var modalEditName = $('#modal-edit input[name="name"]');
            @foreach ($criterias as $criteria)
                @if ($criteria->has_option)
                    var modalEdit{{ $criteria->code }} = $('#modal-edit select[name="criteria[{{ $criteria->code }}]"]');
                @else
                    var modalEdit{{ $criteria->code }} = $('#modal-edit input[name="criteria[{{ $criteria->code }}]"]');
                @endif
            @endforeach
            $('#modal-edit').on('hidden.bs.modal', function() {
                modalEditName.val('');
            @foreach ($criterias as $criteria)
                @if ($criteria->has_option)
                    modalEdit{{ $criteria->code }}.val('-');
                @else
                    modalEdit{{ $criteria->code }}.val('');
                @endif
            @endforeach
                $('#modal-edit button[name="submit"]').attr('data-id', '');
            });
            $('#table').on('click', '.edit', function(e) {
                e.preventDefault()

                $('#modal-edit button[name="submit"]').attr('data-id', $(this).data('id'));

                var url = "{{ route('eligibility.alternatives.show', ':id') }}";
                url = url.replace(':id', $(this).data('id'));
                console.log("edit button get : " + url);

                modalEditName.attr("disabled", true);
                @foreach ($criterias as $criteria)
                    modalEdit{{ $criteria->code }}.attr("disabled", true);
                @endforeach
                $.ajax({
                    url: url,
                    method: "GET",
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(msg) {
                    modalEditName.attr("disabled", false);
                    @foreach ($criterias as $criteria)
                        modalEdit{{ $criteria->code }}.attr("disabled", false);
                    @endforeach

                    modalEditName.trigger('focus');

                    modalEditName.val(msg.data.name);
                    @foreach ($criterias as $criteria)
                        modalEdit{{ $criteria->code }}.val(msg.data.scores[{{ $loop->index }}].value);
                    @endforeach
                }).fail(function(err) {
                    alert("Terjadi kesalahan pada server");
                    modalEditName.attr("disabled", false);
                    @foreach ($criterias as $criteria)
                        modalEdit{{ $criteria->code }}.attr("disabled", false);
                    @endforeach
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
                    @foreach ($criterias as $criteria)
                        $('#form-edit')[{{ $loop->iteration }}],
                    @endforeach
                    );
                form.append('aksi', 'edit');
                form.append('_method', 'PATCH');

                var url = "{{ route('eligibility.alternatives.update', ':id') }}";
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
                var url_delete = "{{ route('eligibility.alternatives.delete', ':id') }}";
                url_delete = url_delete.replace(':id', $(this).data('id'));
                console.log("edit button delete : " + url_delete);

                var opt = {
                    url: url_delete,
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
