@extends('adminlte::page')

@section('title', $article->title)

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <span class="badge badge-info px-3 py-1 mb-2 font-weight-bold" style="font-size:0.82rem;">{{ $article->category }}</span>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            {{ $article->title }}
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            <i class="fas fa-user-edit mr-1"></i> Penulis: <strong>{{ $article->author }}</strong> &bull; 
            <i class="far fa-clock mr-1"></i> Dipublikasikan: <strong>{{ optional($article->published_at)->format('d F Y H:i') ?? 'Draft' }}</strong>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('articles.index') }}" class="btn btn-secondary btn-sm shadow-sm font-weight-bold mr-2">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>

        @if(auth()->user()->isAdmin())
            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning btn-sm text-white font-weight-bold shadow-sm">
                <i class="fas fa-edit mr-1"></i> Edit Artikel (Admin)
            </a>
        @endif
    </div>
</div>
@stop

@section('content')

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4 sm:p-5">
        <!-- Summary Box -->
        <div class="alert alert-light border p-3 mb-4" style="border-left: 4px solid #3b82f6 !important; border-radius: var(--radius-sm);">
            <strong class="text-dark d-block mb-1"><i class="fas fa-bookmark text-primary mr-1"></i> Ringkasan Eksekutif Analisis:</strong>
            <p class="text-muted mb-0 font-italic leading-relaxed">{{ $article->summary }}</p>
        </div>

        <!-- Main Content -->
        <div class="article-content text-dark leading-relaxed" style="font-size: 1.05rem; line-height: 1.8;">
            {!! nl2br(e($article->content)) !!}
        </div>

        <div class="border-top pt-3 mt-5 d-flex justify-content-between text-muted" style="font-size: 0.85rem;">
            <span><i class="fas fa-database mr-1"></i> Sumber Data: <strong>{{ $article->source ?? 'Internal Risk Intelligence Platform' }}</strong></span>
            <span><i class="fas fa-shield-alt mr-1"></i> Supply Chain Risk Intelligence Report</span>
        </div>
    </div>
</div>

@stop
