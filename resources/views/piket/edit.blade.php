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
            <form class="needs-validation" action="{{ route('piket.update', $data->id) }}" enctype="multipart/form-data"
                method="POST" novalidate>
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label for="nama" class="form-label">Kode <code>*</code></label>
                                            <input type="text" class="form-control" name="kode" id="kode" onkeyup="this.value = this.value.toUpperCase();" maxlength="15"
                                                value="{{ $data->kode }}" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label for="nis" class="form-label">Deskripsi </label>
                                            <input type="text" class="form-control" name="deskripsi" id="deskripsi" onkeyup="this.value = this.value.toUpperCase();"
                                                value="{{ $data->deskripsi }}" maxlength="20" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label for="flag" class="form-label">Status ? <code>*</code></label>
                                            <br>
                                            <input type="checkbox" name="status" id="flagSwitch" switch="none"
                                                {{ $data->status == 1 ? 'checked' : '' }} />
                                            <label for="flagSwitch" data-on-label="On" data-off-label="Off"></label>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                    </div>



                                </div>
                                <div class="row">

                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('pembina.index') }}"
                                            class="btn btn-secondary waves-effect">Batal</a>
                                        <button class="btn btn-primary" type="submit" style="float: right"
                                            id="submit">Simpan</button>
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
                    <img src="{{ URL::asset('avatar/' . $data->avatar) }}" style="width: 100%">
                </div>
            </div>
        </div>
    </div>
@endsection
