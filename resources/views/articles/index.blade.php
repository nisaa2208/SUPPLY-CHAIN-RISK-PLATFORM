@extends('adminlte::page')

@section('title', 'Artikel & Laporan Analisis Risiko')

@section('content_header')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-2">
    <div>
        <h1 class="font-weight-bold mb-0" style="font-size: 1.85rem; letter-spacing: -0.02em;">
            <i class="fas fa-book-open text-primary mr-2"></i>
            Artikel & Laporan Analisis Risiko
        </h1>
    </div>

    @if(auth()->user()->isAdmin())
    <div>
        <a href="{{ route('articles.create') }}" class="btn btn-primary shadow-sm font-weight-bold px-3 py-2" style="border-radius: var(--radius-pill);">
            <i class="fas fa-pen-nib mr-1"></i> Tulis Artikel Baru (Admin)
        </a>
    </div>
    @endif
</div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-radius: var(--radius-md);">
    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Search & Category Filter Card -->
<div class="card shadow-sm border-0 mb-4" style="border-radius: var(--radius-lg);">
    <div class="card-body p-3">
        <form action="{{ route('articles.index') }}" method="GET" class="row align-items-center">
            <div class="col-md-5 mb-2 mb-md-0">
                <div class="input-group input-group-lg" style="border-radius: var(--radius-md); overflow:hidden;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-primary"></i></span>
                    </div>
                    <input type="text" name="search" class="form-control border-left-0 pl-0" style="font-size:0.95rem;" placeholder="Cari judul artikel, kata kunci, atau penulis..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-4 mb-2 mb-md-0">
                <select name="category" class="form-control form-control-lg custom-select shadow-sm" style="border-radius: var(--radius-md); font-size:0.95rem;" onchange="this.form.submit()">
                    <option value="">📁 Semua Kategori Artikel</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-block btn-lg font-weight-bold shadow-sm">
                    <i class="fas fa-filter mr-1"></i> Filter Artikel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Articles Grid List -->
<div class="row">
    @forelse($articles as $art)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card border shadow-sm h-100 d-flex flex-column justify-content-between overflow-hidden" style="border-radius: var(--radius-lg); transition: transform 0.25s ease, box-shadow 0.25s ease;">
            <div>
                <!-- Article Header Thumbnail Bar -->
                <div class="position-relative bg-dark" style="height: 160px; overflow: hidden;">
                    <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=600&q=80" class="w-100 h-100" style="object-fit: cover; opacity: 0.85;" alt="{{ $art->title }}">
                    <span class="badge badge-primary position-absolute font-weight-bold px-3 py-1" style="top: 12px; left: 12px; font-size:0.75rem; border-radius: var(--radius-pill); background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                        <i class="fas fa-bookmark mr-1"></i> {{ $art->category }}
                    </span>
                    <span class="badge badge-dark position-absolute font-weight-bold px-2 py-1" style="bottom: 12px; right: 12px; font-size:0.73rem; background: rgba(15,23,42,0.85); backdrop-filter: blur(4px);">
                        <i class="far fa-clock mr-1"></i> {{ optional($art->published_at)->format('d M Y') ?? 'Draft' }}
                    </span>
                </div>

                <div class="p-3 p-md-4">
                    <h5 class="font-weight-bold text-dark mb-2" style="line-height: 1.4; font-size: 1.05rem;">
                        <a href="{{ route('articles.show', $art->id) }}" class="text-dark hover:text-primary">
                            {{ $art->title }}
                        </a>
                    </h5>

                    <p class="text-muted mb-3" style="font-size: 0.88rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $art->summary }}
                    </p>
                </div>
            </div>

            <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center" style="border-bottom-left-radius: var(--radius-lg); border-bottom-right-radius: var(--radius-lg);">
                <small class="text-muted font-weight-bold"><i class="fas fa-user-edit text-primary mr-1"></i> {{ $art->author }}</small>

                <div class="d-flex align-items-center gap-1">
                    <a href="{{ route('articles.show', $art->id) }}" class="btn btn-sm btn-outline-primary font-weight-bold px-3">
                        Baca Selengkapnya <i class="fas fa-chevron-right ml-1"></i>
                    </a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('articles.edit', $art->id) }}" class="btn btn-sm btn-warning ml-1 text-white" title="Edit (Admin)">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('articles.destroy', $art->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus artikel ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger ml-1" title="Hapus (Admin)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 text-muted">
        <i class="fas fa-book-open fa-4x mb-3 text-muted opacity-50"></i>
        <h5 class="font-weight-bold">Belum Ada Artikel Analisis</h5>
        <p class="mb-0">Artikel analisis risiko rantai pasok belum tersedia atau tidak cocok dengan filter pencarian.</p>
    </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $articles->links() }}
</div>

@stop
