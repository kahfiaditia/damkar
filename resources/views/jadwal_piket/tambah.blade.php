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
                                            <label for="validationCustom02" class="form-label">Pilih Grup Piket
                                                <code>*</code></label>
                                            <select class="form-control select select2 piket" name="piket"
                                                id="piket" required>
                                                <option value=""> -- Pilih --</option>
                                                <!-- Hanya atribut required di sini -->
                                                @foreach ($piket as $item)
                                                    <option value="{{ $item->id }}">{{ $item->kode }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Katua kelompok
                                                <code>*</code></label>
                                            <select class="form-control select select2 kelompok" name="kelompok"
                                                id="kelompok" required>
                                                <option value="" required> -- Pilih --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                            {!! $errors->first('kelompok', '<div class="invalid-validasi">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">NIK Ketua Kelompok
                                            </label>
                                            <input type="text" class="form-control" id="nikketua" name="nikketua"
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
                                                    <th class="text-center" width="25%">Hari</th>
                                                    <th class="text-center" width="20%">Jam Mulai</th>
                                                    <th class="text-center" width="20%">Jam Selesai</th>
                                                    <th class="text-center" width="5%">Aksi</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $index = 1;
                                            @endphp

                                            <tr>
                                                <td>
                                                    {{ $index++ }}
                                                </td>
                                                <td>
                                                    <select class="form-control select select2" name="hari[]"
                                                        id="hari" required>
                                                        <option value=""> -- Pilih --</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="time" name="jam_mulai[]"
                                                        value="13:45:00" id="example-time-input">
                                                </td>
                                                <td>
                                                    <input class="form-control" type="time" name="jam_selesai[]"
                                                        value="13:45:00" id="example-time-input">
                                                </td>
                                                <td class="text-center">

                                                </td>
                                            </tr>
                                        </table>
                                        <div class="row mt-4">
                                            <div class="col-sm-12">
                                                <button class="btn btn-primary" type="button" id="tambahBaris">Tambah
                                                    Hari</button>
                                            </div>
                                        </div>
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
        //attas
        $(document).ready(function() {
            $('.divFoto').hide();

            $.ajax({
                type: "POST",
                url: '{{ route('jadwal_piket.ketua_kelompok') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                },

                success: response => {
                    $.each(response.data, function(i, item) {
                        $('.kelompok').append(
                            `<option value="${item.id}" data-id="${item.name}" data-value="${item.nis}" data-value1="${item.nik}" data-value2="${item.class_id}" data-value3="${item.email}">${item.name}</option>`
                        )
                    })

                    $(".kelompok").change(function() {
                        var nikketua = $('option:selected', this).attr('data-value');
                        document.getElementById("nikketua").value = nikketua;
                    });

                },
                error: (err) => {
                    console.log(err);
                },
            });

            $(document).ready(function() {

                function isiPilihanHari() {
                    $.ajax({
                        type: "GET",
                        url: '{{ route('jadwal_piket.get_hari') }}',
                        dataType: "json",
                        success: function(response) {
                            var select = $("#hari");
                            select.empty();

                            // Tambahkan opsi "-- Pilih --" kembali
                            select.append('<option value=""> -- Pilih --</option>');

                            $.each(response.data, function(index, hari) {
                                select.append('<option value="' + hari.kode + '">' +
                                    hari.nama_hari + '</option>');
                            });
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                }
                isiPilihanHari();

            })
        });

        var index = 2;
        // Fungsi untuk menghapus baris form input
        function hapusBaris(element) {
            $(element).closest("tr").remove();
            updateIndex();
        }

        // Fungsi untuk menambahkan baris form input
        $(document).ready(function() {
            $("#tambahBaris").on("click", function() {
                var newRow = $("<tr>");
                var cols = "";

                cols += '<td>' + index + '</td>';

                // Buat elemen <select> untuk hari
                var selectHari = document.createElement("select");
                selectHari.className = "form-control select select2 hari" + index;
                selectHari.name = "hari[]";
                selectHari.id = "hari" + index;
                selectHari.required = true;
                selectHari.style.width = "315px";

                // Tambahkan opsi default
                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "-- Pilih --";
                selectHari.appendChild(defaultOption);

                cols += '<td>' + selectHari.outerHTML + '</td>';

                cols +=
                    '<td><input class="form-control" type="time" value="13:45:00" name="jam_mulai[]"></td>';
                cols +=
                    '<td><input class="form-control" type="time" value="13:45:00" name="jam_selesai[]"></td>';
                cols +=
                    '<td class="text-left"><a href="#" class="text-danger delete_confirm" onclick="hapusBaris(this)"><i class="mdi mdi-delete font-size-18"></i></a></td>';

                newRow.append(cols);
                $("#tableList").append(newRow);
                index++;

                // Mengambil data hari dari server dengan AJAX
                $.ajax({
                    type: "POST",
                    url: '{{ route('jadwal_piket.cari_hari') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        // Loop melalui data dari respons AJAX
                        $.each(response.data, function(index, hari) {
                            $("#" + selectHari.id).append($('<option>', {
                                value: hari.kode,
                                text: hari.nama_hari
                            }));
                        });

                        $("#" + selectHari.id).select2();
                    },
                    error: function(err) {
                        console.log(err); // Tangani kesalahan jika terjadi
                    }
                });
            });
        });

        // Fungsi untuk mengupdate nomor indeks di kolom pertama

        function updateIndex() {
            var rows = $("#tableList tbody tr");
            rows.each(function(index, element) {
                $(element).find("td:first").text(index + 1);
            });
        }

        function ambilNilaiSelect() {
            var nilaiSelect = [];
            $('tbody tr').each(function() {
                var nameSelect = $(this).find('select[name="hari[]"]')
                    .val(); // Ambil nilai elemen <select> berdasarkan name
                nilaiSelect.push(nameSelect);
            });
            return nilaiSelect;
        }

        //simpan
        $(document).ready(function() {
            $('#simpanDataBtn').click(function() {
                var nilaiSelect = ambilNilaiSelect();
                var index = 0;

                var piket = document.getElementById('piket').value;
                var kelompok = document.getElementById('kelompok').value;

                var datajadwal = [];

                $('tbody tr').each(function(index) {
                    var jam_mulai = $(this).find('input[name="jam_mulai[]"]').val();
                    var jam_selesai = $(this).find('input[name="jam_selesai[]"]').val();

                    var item = {
                        piket: piket,
                        kelompok: kelompok,
                        nilaiSelect: nilaiSelect[index],
                        jam_mulai: jam_mulai,
                        jam_selesai: jam_selesai,
                    };
                    datajadwal.push(item);
                });

                // Cetak datajadwal dalam format JSON
                // datajadwal.forEach(function(item) {
                //     console.log(JSON.stringify(item));
                // });

                $.ajax({
                    type: 'POST',
                    url: '{{ route('jadwal_piket.simpan_data_piket') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        datajadwal: datajadwal,
                    },
                    success: response => {
                        if (response.code == 200) {
                            Swal.fire({
                                title: 'Input Jadwal Berhasil',
                                text: `${response.message}`,
                                icon: 'success',
                                timer: 1000,
                                willClose: () => {
                                    // Mengarahkan ke route jadwal.index
                                    window.location.href =
                                        '{{ route('jadwal_piket.index') }}';
                                }
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 1500,
                                willClose: () => {
                                    location.reload();
                                }
                            })
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
