@extends('adminlte::page')

@section('title', 'Fitur AI & Lexicon Sentiment Engine Manager')

@section('content_header')
<!-- Hero Header -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 p-4 rounded shadow-sm" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%); color: #ffffff;">
    <div>
        <h1 class="font-weight-bold text-white mb-0" style="font-size: 1.8rem;">
            <i class="fas fa-brain text-purple mr-2"></i>
            Fitur AI / Data Science Engine (Lexicon Sentiment Analysis)
        </h1>
    </div>
    <div class="mt-3 mt-md-0">
        <span class="badge badge-purple px-3 py-2 font-weight-bold shadow-sm" style="background:#8b5cf6; font-size:0.85rem; border-radius: var(--radius-pill);">
            <i class="fas fa-robot mr-1"></i> PHP Lexicon Sentiment Engine Active
        </span>
    </div>
</div>
@stop

@section('css')
<style>
.ai-card {
    border-radius: var(--radius-lg);
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
    background: #ffffff;
    margin-bottom: 1.5rem;
}
.word-badge-pos {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
    padding: 4px 10px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.82rem;
    display: inline-block;
    margin: 2px;
}
.word-badge-neg {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
    padding: 4px 10px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.82rem;
    display: inline-block;
    margin: 2px;
}
</style>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Interactive AI Lexicon Tester (PDF Spec Page 7 & 8) -->
<div class="card ai-card shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <h4 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-microchip text-primary mr-2"></i> Pengujian Mesin AI Lexicon Sentiment (Interactive Playground)
        </h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.ai.sentiment') }}" method="GET">
            <div class="form-group mb-3">
                <label class="font-weight-bold text-dark mb-1">
                    <i class="fas fa-align-left text-primary mr-1"></i> Masukkan Teks Berita / Paragraf Analisis Logistik:
                </label>
                <textarea name="test_text" class="form-control form-control-lg" rows="3" placeholder="Masukkan teks berita logistik..." style="font-size:0.95rem; border-radius: var(--radius-md);">{{ $testText }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary font-weight-bold px-4 shadow-sm" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border:none; border-radius: var(--radius-md);">
                <i class="fas fa-cogs mr-2"></i> Jalankan Analisis Sentimen AI
            </button>
        </form>

        <hr class="my-4">

        <!-- AI Output Results (PDF Spec Page 7-8) -->
        <h5 class="font-weight-bold text-dark mb-3">
            <i class="fas fa-chart-pie text-purple mr-2"></i> Hasil Analisis AI Lexicon (PDF Spec Page 7-8):
        </h5>

        <div class="row align-items-center">
            <!-- Left: Score Cards -->
            <div class="col-lg-4 mb-3 mb-lg-0">
                <div class="card border bg-light p-3 text-center" style="border-radius: var(--radius-md);">
                    <small class="text-muted font-weight-bold text-uppercase d-block" style="font-size:0.75rem;">HASIL SENTIMEN</small>
                    <div class="h2 font-weight-bold my-2" style="color: {{ $testResult['sentiment'] === 'Positive' ? '#10b981' : ($testResult['sentiment'] === 'Negative' ? '#ef4444' : '#64748b') }};">
                        {{ $testResult['sentiment'] }}
                    </div>
                    <div class="d-flex justify-content-center align-items-center" style="font-size:0.85rem;">
                        <span class="badge badge-success px-2 py-1 mr-2 font-weight-bold">Positive: {{ $testResult['positive_score'] }}</span>
                        <span class="badge badge-danger px-2 py-1 font-weight-bold">Negative: {{ $testResult['negative_score'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Right: Matched Lexicon Words -->
            <div class="col-lg-8">
                <div class="p-3 bg-light rounded border" style="font-size:0.88rem;">
                    <div class="mb-2">
                        <strong class="text-success mr-2"><i class="fas fa-plus-circle mr-1"></i> Positive Words Found:</strong>
                        @forelse($testResult['matched_positive'] as $w)
                            <span class="word-badge-pos">{{ $w }}</span>
                        @empty
                            <span class="text-muted">-</span>
                        @endforelse
                    </div>

                    <div>
                        <strong class="text-danger mr-2"><i class="fas fa-minus-circle mr-1"></i> Negative Words Found:</strong>
                        @forelse($testResult['matched_negative'] as $w)
                            <span class="word-badge-neg">{{ $w }}</span>
                        @empty
                            <span class="text-muted">-</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dictionaries Management Row (PDF Spec Page 7: positive_words & negative_words) -->
<div class="row">
    <!-- Positive Words Dictionary Manager -->
    <div class="col-lg-6 mb-4">
        <div class="card ai-card shadow-sm h-100">
            <div class="card-header bg-success text-white py-3">
                <h4 class="card-title font-weight-bold mb-0">
                    <i class="fas fa-plus-circle mr-2"></i> Kamus Kata Positif (tabel: positive_words)
                </h4>
            </div>

            <div class="card-body p-3">
                <form action="{{ route('admin.ai.positive.add') }}" method="POST" class="mb-3">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="word" class="form-control" placeholder="Tambah kata positif baru (e.g. boom, surge, gain)..." required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success font-weight-bold">
                                <i class="fas fa-plus mr-1"></i> Tambah
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-hover table-bordered mb-0 align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th width="50" class="text-center">No</th>
                                <th>Kata Positif</th>
                                <th width="80" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($positiveWords as $pw)
                            <tr>
                                <td class="text-center text-muted font-weight-bold">{{ $loop->iteration }}</td>
                                <td><span class="word-badge-pos">{{ $pw->word }}</span></td>
                                <td class="text-center">
                                    <form action="{{ route('admin.ai.positive.delete', $pw->id) }}" method="POST" onsubmit="return confirm('Hapus kata ini dari kamus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger font-weight-bold">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Kamus positif kosong</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Negative Words Dictionary Manager -->
    <div class="col-lg-6 mb-4">
        <div class="card ai-card shadow-sm h-100">
            <div class="card-header bg-danger text-white py-3">
                <h4 class="card-title font-weight-bold mb-0">
                    <i class="fas fa-minus-circle mr-2"></i> Kamus Kata Negatif (tabel: negative_words)
                </h4>
            </div>

            <div class="card-body p-3">
                <form action="{{ route('admin.ai.negative.add') }}" method="POST" class="mb-3">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="word" class="form-control" placeholder="Tambah kata negatif baru (e.g. strike, embargo, hazard)..." required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-danger font-weight-bold">
                                <i class="fas fa-plus mr-1"></i> Tambah
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-hover table-bordered mb-0 align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th width="50" class="text-center">No</th>
                                <th>Kata Negatif</th>
                                <th width="80" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($negativeWords as $nw)
                            <tr>
                                <td class="text-center text-muted font-weight-bold">{{ $loop->iteration }}</td>
                                <td><span class="word-badge-neg">{{ $nw->word }}</span></td>
                                <td class="text-center">
                                    <form action="{{ route('admin.ai.negative.delete', $nw->id) }}" method="POST" onsubmit="return confirm('Hapus kata ini dari kamus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger font-weight-bold">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Kamus negatif kosong</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
