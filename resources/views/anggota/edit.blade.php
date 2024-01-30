@extends('layouts.main')

@section('evoting')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $label }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">{{ ucwords($menu) }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Nama
                                            <code>*</code></label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            maxlength="25" onkeyup="this.value = this.value.toUpperCase();" autocomplete="off" value="{{ $editdata->nama }}" required>
                                        <input type="text" class="form-control" id="id" name="id"
                                            maxlength="25" onkeyup="this.value = this.value.toUpperCase();" autocomplete="off" value="{{ $editdata->id }}" hidden>
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                        {!! $errors->first('nama', '<div class="invalid-validasi">:message</div>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Jabatan
                                            <code>*</code></label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan"
                                            maxlength="25" onkeyup="this.value = this.value.toUpperCase();" value="Anggota" readonly>
                                        <div class="invalid-feedback">
                                            Data Wajib diisi
                                        </div>
                                        {!! $errors->first('jabatan', '<div class="invalid-validasi">:message</div>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Piket
                                            <code>*</code></label>
                                        <select class="form-control select select2 piket" name="piket" id="piket">
                                            <option value=""> -- pilih --</option>
                                                @foreach ($datapiket as $drop)
                                                    <option value="{{ $drop->id }}"  {{ $editdata->piket == $drop->id ? 'selected' : '' }}> {{ $drop->kode }}</option>
                                                @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Data Wajib diisi
                                        </div>
                                        {!! $errors->first('piket', '<div class="invalid-validasi">:message</div>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <a href="{{ route('anggota.index') }}" class="btn btn-secondary waves-effect">Batal</a>
                                    <button class="btn btn-primary" type="button" style="float: right" id="simpanDataBtn">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#simpanDataBtn').click(function () {
            var nama = $('#nama').val();
            var id = $('#id').val();
            var piket = $('#piket').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route("anggota.simpanData") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'nama': nama,
                        'id': id,
                        'piket': piket
                    },
                    success: function (data) {
                        // Handle success response
                        console.log(data);
                        // Redirect or perform any other actions
                    },
                    error: function (error) {
                        // Handle error response
                        console.error(error);
                        // Display error messages or perform any other actions
                    }
                });
            });
        });
    </script>
@endsection
