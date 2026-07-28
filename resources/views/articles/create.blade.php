@extends('adminlte::page')

@section('title', 'Tulis Artikel Analisis Baru')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-pen-nib text-primary mr-2"></i> Tulis Artikel Analisis Risiko Baru (Admin Only)
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Kelola Artikel & Publikasi Hasil Analisis Risiko Rantai Pasok Global (PDF Spec Hal 6)
        </div>
    </div>

    <a href="{{ route('articles.index') }}" class="btn btn-secondary btn-sm shadow-sm font-weight-bold">
        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Artikel
    </a>
</div>
@stop

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('articles.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <!-- Judul Artikel -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Judul Artikel Analisis <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Contoh: Analisis Dampak Konflik Geopolitik Terhadap Rute Logistik Asia-Eropa" required>
                        @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <!-- Ringkasan Singkat -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Ringkasan Eksekutif (Summary) <span class="text-danger">*</span></label>
                        <textarea name="summary" rows="3" class="form-control @error('summary') is-invalid @enderror" placeholder="Ringkasan singkat poin-poin utama analisis..." required>{{ old('summary') }}</textarea>
                        @error('summary') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <!-- Isi Lengkap Artikel -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Isi Lengkap Artikel Analisis <span class="text-danger">*</span></label>
                        <textarea name="content" rows="10" class="form-control @error('content') is-invalid @enderror" placeholder="Tuliskan isi analisis mendalam, data cuaca, inflasi, sentimen berita, dan rekomendasi logistik..." required>{{ old('content') }}</textarea>
                        @error('content') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4 border-left">
                    <!-- Kategori -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Kategori Analisis <span class="text-danger">*</span></label>
                        <select name="category" class="form-control custom-select @error('category') is-invalid @enderror" required>
                            <option value="Logistics & Shipping" {{ old('category') == 'Logistics & Shipping' ? 'selected' : '' }}>Logistics & Shipping</option>
                            <option value="Geopolitics & News" {{ old('category') == 'Geopolitics & News' ? 'selected' : '' }}>Geopolitics & News</option>
                            <option value="Economic & Inflation" {{ old('category') == 'Economic & Inflation' ? 'selected' : '' }}>Economic & Inflation</option>
                            <option value="Climate & Port Weather" {{ old('category') == 'Climate & Port Weather' ? 'selected' : '' }}>Climate & Port Weather</option>
                        </select>
                        @error('category') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <!-- Penulis -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Nama Penulis / Analis <span class="text-danger">*</span></label>
                        <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', auth()->user()->name) }}" required>
                        @error('author') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <!-- Sumber -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Sumber Data / Lembaga</label>
                        <input type="text" name="source" class="form-control" value="{{ old('source', 'Tim Analis SupplyRisk') }}" placeholder="Contoh: World Bank, Open-Meteo API">
                    </div>

                    <!-- Status Publikasi -->
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">Status Publikasi <span class="text-danger">*</span></label>
                        <select name="status" class="form-control custom-select" required>
                            <option value="Published" {{ old('status') == 'Published' ? 'selected' : '' }}>Published (Publikasikan)</option>
                            <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft (Simpan Konsep)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block font-weight-bold shadow-sm py-2">
                        <i class="fas fa-save mr-1"></i> Simpan & Publikasikan Artikel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@stop
