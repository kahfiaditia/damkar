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

            <form class="needs-validation">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Grup Piket
                                                <code>*</code></label>
                                                <input type="text" class="form-control" value="{{ $absen_kegiatan->kode }}" id="grup_piket" name="grup_piket" readonly>
                                                <input type="text" class="form-control" value="{{ $absen_kegiatan->id }}" id="grup_piket_id" name="grup_piket_id" hidden>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Katua Kelompok
                                                <code>*</code></label>
                                                <input type="text" class="form-control" value="{{ $absen_kegiatan->ketua_kelompok }}" id="ketua_kelompok" name="ketua_kelompok" readonly>
                                                <input type="text" class="form-control" value="{{ $absen_kegiatan->id_ketua }}" id="ketua_kelompok_id" name="ketua_kelompok_id" hidden>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Hari
                                                <code>*</code></label>
                                                <input type="text" class="form-control" value="{{ $absen_kegiatan->nama_hari }}" id="nama_hari" name="nama_hari" readonly>
                                                <input type="text" class="form-control" value="{{ $absen_kegiatan->id_hari }}" id="id_hari" name="id_hari" hidden>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Jumlah Anggota Grup
                                            </label>
                                            <input type="text" class="form-control" value="{{ $jumlah_anggota }}" id="jumlah" name="jumlah"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-responsive table-bordered table-striped" id="tableList">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="5%">No</th>
                                                    <th class="text-center" hidden>id</th>
                                                    <th class="text-center" width="25%">Nama</th>
                                                    <th class="text-center" width="20%">Jabatan</th>
                                                    <th class="text-center" width="20%">Status Piket</th>
                                                    <th class="text-center" width="20%">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($absensinya as $anggota)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td id="id_anggota[]" name="id_anggota[]" hidden>{{ $anggota->id }}</td>
                                                <td id="nama_anggota[]" name="nama_anggota[]">{{ $anggota->nama }}</td>
                                                <td id="jabatan[]" name="jabatan[]">{{ $anggota->jabatan }}</td>
                                                <td>
                                                    <select class="form-control select select2 status_piket[]" name="status_piket[]"  style="width: 100%">
                                                        <option value=""> -- Pilih --</option>
                                                        <option value="1">Piket Hadir</option>
                                                        <option value="2">Tidak Hadir</option>
                                                        <option value="3">Cadangan Piket</option>
                                                    </select>                                                    
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="keterangan[]" name="keterangan[]" maxlength="15">
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        </table>
                                        
                                        <div class="row mt-4">
                                            <div class="col-sm-12">
                                                <a href="{{ route('jadwal_piket.index') }}"
                                                    class="btn btn-secondary waves-effect">Batal</a>
                                                <button class="btn btn-primary" type="button" style="float: right"
                                                    id="simpanDataBtn">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </form>
        </div>
    </div>
    <script script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
    <script script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Get additional data
            var grupPiketId = $('#grup_piket_id').val();
            var grupPiket = $('#grup_piket').val();
            var ketuaKelompok = $('#ketua_kelompok').val();
            var ketuaKelompokid = $('#ketua_kelompok_id').val();
            var namaHari = $('#nama_hari').val();
            var idHari = $('#id_hari').val();
            var jumlahAnggota = $('#jumlah').val();

            
        
            $('#simpanDataBtn').on('click', function() {
               
                var dataToSend = [];
        
                $('#tableList tbody tr').each(function() {
                   
                    var idAnggota = $(this).find('[name="id_anggota[]"]').text().trim();
                    var namaAnggota = $(this).find('[name="nama_anggota[]"]').text().trim();
                    var jabatan = $(this).find('[name="jabatan[]"]').text().trim();
                    var statusPiket = $(this).find('[name="status_piket[]"]').val();
                    var keterangan = $(this).find('[name="keterangan[]"]').val();
        
                   
                    var rowData = {
                        id_anggota: idAnggota,
                        nama_anggota: namaAnggota,
                        jabatan: jabatan,
                        status_piket: statusPiket,
                        keterangan: keterangan
                    };
        
                    dataToSend.push(rowData);
                });

                var isStatusPiketNull = dataToSend.some(function(row) {
                        return row.status_piket === null || row.status_piket === undefined || row.status_piket === '';
                });

                if (isStatusPiketNull) {
                    
                    Swal.fire({
                        icon: 'warning',
                        title: 'Isi Dulu Status Piket',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return; 
                }
        
               
                $.ajax({
                    type: 'POST',
                    url: '{{ route("absensi_piket.store") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        dataToSend: dataToSend,
                        grup_piket: grupPiket,
                        grup_piket_id: grupPiketId,
                        ketua_kelompok_id: ketuaKelompokid,
                        ketua_kelompok: ketuaKelompok,
                        nama_hari: namaHari,
                        id_hari: idHari,
                        jumlah_anggota: jumlahAnggota
                    },
                    success: response => {
                        if (response.code == 200) {
                            Swal.fire({
                                title: 'Absensi Berhasil',
                                text: `${response.message}`,
                                icon: 'success',
                                timer: 1000,
                                willClose: () => {
                                    // Mengarahkan ke route jadwal.index
                                    window.location.href = '{{ route('absensi_piket.index') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 1500,
                                willClose: () => {
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });
        });
    </script>
@endsection
