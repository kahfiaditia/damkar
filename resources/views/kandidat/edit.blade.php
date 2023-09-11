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

            <form class="needs-validation" action="{{ route('kandidat.update', $kandidat->id) }}"
                enctype="multipart/form-data" method="POST" novalidate>
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Ketua<code>*</code></label>
                                            <select class="form-control select select2 ketua" name="ketua" id="ketua"
                                                required>
                                                <option value=""> -- Pilih --</option>
                                                @foreach ($pilihan as $item)
                                                    <option value="{{ $item->id }}"
                                                        @if ($item->id == $kandidat->id_ketua) selected @endif>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('ketua', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="nis_ketua_container" style="display: none;">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">NIS
                                                Ketua<code>*</code></label>
                                            <input type="text" class="form-control" id="nisketua" name="nisketua"
                                                value="" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Wakil
                                                <code>*</code></label>
                                            <select class="form-control select select2 wakil" name="wakil" id="wakil"
                                                required>
                                                @foreach ($pilihan as $item567)
                                                    <option value="{{ $item567->id }}"
                                                        @if ($item567->id == $kandidat->id_wakil) selected @endif>
                                                        {{ $item567->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('wakil', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="nis_wakil_container" style="display: none;">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">NIS
                                                wakil<code>*</code></label>
                                            <input type="text" class="form-control" id="niswakil" name="niswakil"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Qoute
                                                <code>*</code></label>
                                            <textarea class="form-control" name="quote" id="quote">{{ $kandidat->quote }}</textarea>
                                        </div>
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                        {!! $errors->first('quote', '<div class="invalid-validasi">:message</div>') !!}
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Periode
                                                <code>*</code></label>
                                            <select class="form-control select select2" name="periode" id="periode">
                                                <option value=""> -- Pilih --</option>
                                                @foreach ($periode as $item)
                                                    <option value="{{ $item->id }}" date-id="{{ $item->type_foto }}"
                                                        @if ($item->id == $kandidat->id_periode) selected @endif>
                                                        {{ $item->periode_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('periode', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Nomor Urut Calon
                                                <code>*</code></label>
                                            <select class="form-control select select2" name="urut" id="urut"
                                                data-select2-id="urut">
                                                <option value=""> -- Pilih --</option>
                                                <option value="1" @if ($kandidat->no_urut == 1) selected @endif> 1
                                                </option>
                                                <option value="2" @if ($kandidat->no_urut == 2) selected @endif> 2
                                                </option>
                                                <option value="3" @if ($kandidat->no_urut == 3) selected @endif> 3
                                                </option>
                                                <option value="4" @if ($kandidat->no_urut == 4) selected @endif> 4
                                                </option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('urut', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3 divFoto">
                                        <div class="mb-3">
                                            <label for="avatar" class="form-label">Foto (.jpg, .jpeg,
                                                .png) max 2048kb</label>
                                            <input type="file" class="form-control" name="avatar" id="avatar"
                                                required accept=".jpg, .jpeg, .png" autocomplete="off">
                                            @if ($kandidat->avatar_kandidat)
                                                <a href="javascript:void(0)" data-id="" id="get_data"
                                                    data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
                                                    <i
                                                        class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>Lihat
                                                    Foto
                                                </a>
                                            @endif
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Deskripsi Visi dan Misi
                                                <code>*</code></label>
                                            <textarea name="editor1" id="editor1">{{ $kandidat->visi_misi }}</textarea>
                                        </div>
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                        {!! $errors->first('editor1', '<div class="invalid-validasi">:message</div>') !!}
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('kandidat.index') }}"
                                            class="btn btn-secondary waves-effect">Batal</a>
                                        <button class="btn btn-primary" type="submit"
                                            style="float: right">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ URL::asset('avatar_kandidat/' . $kandidat->avatar_kandidat) }}" style="width: 100%">
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
    <script>
        CKEDITOR.replace('editor1');

        function typeChoice(whichbox) {
            if (whichbox.value == 'Kandidat') {
                $('.divFoto').show();
                document.getElementById("avatar").required = true
            } else {
                $('.divFoto').hide();
                document.getElementById("avatar").required = false
            }
        }

        // ketua//
        $(document).ready(function() {
            // Menambahkan event listener untuk perubahan dropdown ketua
            $('.ketua').change(function() {
                var selectedKetuaId = $(this).val();
                if (selectedKetuaId) {
                    $('#nis_ketua_container').show();
                    fetchNISKetua(selectedKetuaId);
                    // console.log(selectedKetuaId);
                } else {
                    $('#nis_ketua_container').hide();
                    $('#nisketua').val(''); // Reset value NIS ketua saat opsi ketua tidak dipilih
                }
            });

            // Fungsi untuk mengambil data NIS ketua melalui AJAX
            function fetchNISKetua(ketuaId) {

                $.ajax({
                    type: "POST",
                    url: '{{ route('kandidat.edit_get_nisketua') }}', // Ubah route sesuai dengan route yang Anda miliki
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id_ketua": ketuaId
                    },
                    success: function(response) {
                        if (response.code === 200 && response.data && response.data.nis) {
                            $('#nisketua').val(response.data.nis);
                        } else {
                            $('#nisketua').val('');
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    },
                });
            }

            // Memeriksa nilai id_ketua saat halaman dimuat dan memanggil fungsi fetchNISKetua jika opsi ketua sudah terpilih
            var selectedKetuaId = $('.ketua').val();
            if (selectedKetuaId) {
                fetchNISKetua(selectedKetuaId);
            }
        });
        // ketua//



        // wakil//
        $(document).ready(function() {

            // Menambahkan event listener untuk perubahan dropdown ketua
            $('.wakil').change(function() {
                var selectedWakilId = $(this).val();
                if (selectedWakilId) {
                    $('#nis_wakil_container').show();
                    fetchNISWakil(selectedWakilId);
                    // console.log(selectedKetuaId);
                } else {
                    $('#nis_wakil_container').hide();
                    $('#niswakil').val(''); // Reset value NIS ketua saat opsi ketua tidak dipilih
                }
            });

            // Fungsi untuk mengambil data NIS ketua melalui AJAX
            function fetchNISWakil(wakilId) {

                $.ajax({
                    type: "POST",
                    url: '{{ route('kandidat.edit_get_niswakil') }}', // Ubah route sesuai dengan route yang Anda miliki
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id_wakil": wakilId
                    },
                    success: function(response) {
                        if (response.code === 200 && response.data && response.data.nis) {
                            $('#niswakil').val(response.data.nis);
                        } else {
                            $('#niswakil').val('');
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    },
                });
            }

            // Memeriksa nilai id_ketua saat halaman dimuat dan memanggil fungsi fetchNISKetua jika opsi ketua sudah terpilih
            var selectedWakilId = $('.wakil').val();
            if (selectedWakilId) {
                fetchNISWakil(selectedWakilId);
            }
        });
        // wakil//
    </script>
@endsection
