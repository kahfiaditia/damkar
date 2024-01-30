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
                                            maxlength="25" onkeyup="this.value = this.value.toUpperCase();" required>
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
        $(document).ready(function() {
            $('.divFoto').hide();
            $.ajax({
                type: "POST",
                url: '{{ route('anggota.get_grup_data') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: response => {
                    $.each(response.data, function(i, item) {
                        $('.piket').append(
                            `<option value="${item.id}" data-id="${item.kode}" >${item.kode}</option>`
                        )
                    });
                },
                error: (err) => {
                    console.log(err);
                },
            });

            $('#simpanDataBtn').on('click', function() {
                var nama = $('#nama').val();
                var jabatan = $('#jabatan').val();
                var piketId = $('#piket').val();

                if (!nama || !piketId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tanda * (bintang) wajib diisi',
                        text: 'Isi Nama dan Piket',
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    return;
                }

                // untuk Kirim data ke controller
                $.ajax({
                    type: "POST",
                    url: '{{ route('anggota.store') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "nama": nama,
                        "jabatan": jabatan,
                        "piket_id": piketId
                    },
                    success: (response) => {
                        // console.log(response);
                        if (response.code === 200) {

                            Swal.fire(
                                'Success',
                                'Data Anggota Berhasil di masukan',
                                'success'
                            ).then(() => {
                                var APP_URL = {!! json_encode(url('/')) !!}
                                window.location = APP_URL + '/anggota'
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Tanda * (bintang) wajib diisi',
                                showConfirmButton: false,
                                timer: 1500,
                            })
                        }
                    },
                    error: err => console.log(err)
                });
            });
        });
    </script>
@endsection
