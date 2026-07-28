@extends('adminlte::page')

@section('title', 'Tambah Pelabuhan Baru')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-plus-circle text-success mr-2"></i> Tambah Pelabuhan Baru ke Dataset (Admin Only)
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Kelola Dataset Pelabuhan Maritim Dunia (PDF Spec Hal 6)
        </div>
    </div>

    <a href="{{ route('ports.index') }}" class="btn btn-secondary btn-sm shadow-sm font-weight-bold">
        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dataset Pelabuhan
    </a>
</div>
@stop

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('ports.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <!-- Nama Pelabuhan -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Nama Pelabuhan <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: Port of Hamburg" required>
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <!-- Kode Pelabuhan -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Kode Pelabuhan (UN/LOCODE) <span class="text-danger">*</span></label>
                        <input type="text" name="port_code" class="form-control @error('port_code') is-invalid @enderror" value="{{ old('port_code') }}" placeholder="Contoh: DEHAM" required>
                        @error('port_code') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <!-- Negara -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Negara <span class="text-danger">*</span></label>
                        <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country') }}" placeholder="Contoh: Germany" required>
                        @error('country') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <!-- Kota -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Kota / Wilayah <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" placeholder="Contoh: Hamburg" required>
                        @error('city') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-6 border-left">
                    <!-- Latitude -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Koordinat Latitude (GIS) <span class="text-danger">*</span></label>
                        <input type="number" step="any" name="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude') }}" placeholder="Contoh: 53.5461" required>
                        @error('latitude') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <!-- Longitude -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Koordinat Longitude (GIS) <span class="text-danger">*</span></label>
                        <input type="number" step="any" name="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude') }}" placeholder="Contoh: 9.9664" required>
                        @error('longitude') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <!-- Risk Level -->
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">Tingkat Risiko Logistik Pelabuhan <span class="text-danger">*</span></label>
                        <select name="risk_level" class="form-control custom-select @error('risk_level') is-invalid @enderror" required>
                            <option value="Low Risk" {{ old('risk_level') == 'Low Risk' ? 'selected' : '' }}>Low Risk (Normal / Kondusif)</option>
                            <option value="Medium Risk" {{ old('risk_level') == 'Medium Risk' ? 'selected' : '' }}>Medium Risk (Waspada Keterlambatan)</option>
                            <option value="High Risk" {{ old('risk_level') == 'High Risk' ? 'selected' : '' }}>High Risk (Kemacetan / Badai Ekstrem)</option>
                        </select>
                        @error('risk_level') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-success btn-block font-weight-bold shadow-sm py-2">
                        <i class="fas fa-save mr-1"></i> Simpan Pelabuhan Baru
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@stop
