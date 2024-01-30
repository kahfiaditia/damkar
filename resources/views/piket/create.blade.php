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
                                {{-- <li class="breadcrumb-item">{{ $aksi }}</li> --}}
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <form class="needs-validation" action="{{ route('piket.store') }}" method="POST" novalidate>
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-6">
                                            <label for="validationCustom02" class="form-label">Kode  <code>*</code>
                                            </label>
                                            <input type="text" class="form-control" id="kode" name="kode"
                                                autofocus maxlength="12" onkeyup="this.value = this.value.toUpperCase();" placeholder="Kode Piket etc: A">
                                            <div class="invalid-feedback"  maxlength="15" required>
                                                    Data wajib diisi.
                                            </div>
                                            {!! $errors->first('kode', '<div class="invalid-validasi">:message</div>') !!}

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-6">
                                            <label for="validationCustom02" class="form-label">Deskripsi
                                            </label>
                                            <input type="text" class="form-control" id="deskripsi" name="deskripsi"
                                                autofocus maxlength="20" onkeyup="this.value = this.value.toUpperCase();"   placeholder="Deskripsi">
                                        </div>
                                    </div>
                                
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('piket.index') }}"
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
@endsection
