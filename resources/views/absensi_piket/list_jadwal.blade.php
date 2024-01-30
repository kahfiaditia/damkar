@extends('layouts.main')
@section('evoting')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">{{ $menu }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">{{ $title }}</li>
                                <li class="breadcrumb-item active">{{ $kegiatan }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="">
                        <div class="table-responsive">
                            <div class="">
                                <div class="alert alert-warning mb-0" role="alert" style="font-size: 18px;">
                                    Data absensi akan tampil sesuai jadwal yang telah di input pada menu Jadwal, Misal Diinput Hari Senin, Maka akan Tampil hanya Hari Senin
                                </div>
                            </div>
                            <table class="table project-list-table table-nowrap align-middle table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 100px">#</th>
                                        <th scope="col">Ketua Kelompok</th>
                                        <th scope="col">Hari</th>
                                        <th scope="col">Grup Piket</th>
                                        <th scope="col">Mulai</th>
                                        <th scope="col">Akhir</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                {{-- {{ dd($list) }} --}}
                                <tbody>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->ketua_kelompok }}</td>
                                            <td>{{ $item->nama_hari }}</td>
                                            <td>{{ $item->kode }}</td>
                                            <td>{{ $item->jam_mulai }}</td>
                                            <td>{{ $item->jam_selesai }}</td>
                                            <td>
                                                <a href="{{ route('absensi_piket.edit', $item->id) }}"
                                                    class="text-warning" data-toggle="tooltip" data-placement="top"
                                                    title="Absensi">
                                                    <i class="mdi mdi-file-document-edit-outline font-size-18"></i>
                                                </a>
                                                {{-- <a href="#" class="text-danger delete_confirm"><i
                                                        class="mdi mdi-delete font-size-18"></i></a> --}}
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
