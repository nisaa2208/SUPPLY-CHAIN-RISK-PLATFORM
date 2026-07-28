@extends('adminlte::page')

@section('title', 'Admin Dashboard & Management')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-0" style="font-size: 1.75rem;">
            <i class="fas fa-user-shield text-danger mr-2"></i>
            Admin Control Panel & Management (PDF Spec Hal 6)
        </h1>
    </div>

    <div>
        <span class="badge badge-danger px-3 py-2 font-weight-bold" style="font-size: 0.85rem;">
            <i class="fas fa-lock mr-1"></i> Administrator Privileges Active
        </span>
    </div>
</div>
@stop

@section('content')

<!-- Stat Cards Overview -->
<div class="row">
    <div class="col-md-4">
        <div class="small-box bg-info shadow-sm">
            <div class="inner">
                <h3>{{ $totalUsers }}</h3>
                <p>Total User Sistem ({{ $totalAdmins }} Admin / {{ $totalRegularUsers }} Analyst)</p>
            </div>
            <div class="icon">
                <i class="fas fa-users-cog"></i>
            </div>
            <a href="{{ route('users.index') }}" class="small-box-footer">
                Kelola User <i class="fas fa-arrow-circle-right ml-1"></i>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3>{{ $totalPorts }}</h3>
                <p>Dataset Pelabuhan Dunia ({{ $highRiskPorts }} High Risk)</p>
            </div>
            <div class="icon">
                <i class="fas fa-anchor"></i>
            </div>
            <a href="{{ route('ports.index') }}" class="small-box-footer">
                Lihat & Tambah Dataset Pelabuhan <i class="fas fa-arrow-circle-right ml-1"></i>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="small-box bg-purple shadow-sm" style="background-color: #8b5cf6 !important; color: white;">
            <div class="inner">
                <h3>{{ $totalArticles }}</h3>
                <p>Artikel Analisis Risiko ({{ $publishedArticles }} Published)</p>
            </div>
            <div class="icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <a href="{{ route('articles.index') }}" class="small-box-footer" style="color: white !important;">
                Kelola Artikel Analisis <i class="fas fa-arrow-circle-right ml-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- Main Admin Management Cards (PDF Hal 6) -->
<div class="row mb-4">
    <!-- Card 1: Kelola User -->
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h4 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-users text-primary mr-2"></i> 1. Kelola User
                </h4>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <p class="text-muted text-sm leading-relaxed mb-4">
                    Manajemen pengguna sistem, pendaftaran user baru, pengubahan role (Administrator vs User Analis), dan manajemen kata sandi.
                </p>
                <div class="d-flex gap-2">
                    <a href="{{ route('users.index') }}" class="btn btn-primary btn-block shadow-sm">
                        <i class="fas fa-list mr-1"></i> Daftar User
                    </a>
                    <a href="{{ route('users.create') }}" class="btn btn-outline-primary shadow-sm ml-2">
                        <i class="fas fa-user-plus mr-1"></i> Tambah
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Kelola Dataset Pelabuhan -->
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h4 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-ship text-success mr-2"></i> 2. Kelola Dataset Pelabuhan
                </h4>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <p class="text-muted text-sm leading-relaxed mb-4">
                    Manajemen dataset pelabuhan maritim publik (World Port Index), pembaruan titik koordinat GIS, kode UN/LOCODE, dan indikator risiko.
                </p>
                <div class="d-flex gap-2">
                    <a href="{{ route('ports.index') }}" class="btn btn-success btn-block shadow-sm">
                        <i class="fas fa-anchor mr-1"></i> Peta Pelabuhan
                    </a>
                    <a href="{{ route('ports.create') }}" class="btn btn-outline-success shadow-sm ml-2">
                        <i class="fas fa-plus mr-1"></i> Tambah
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Kelola Artikel Analisis -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h4 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-file-alt text-purple mr-2" style="color:#8b5cf6;"></i> 3. Kelola Artikel Analisis
                </h4>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <p class="text-muted text-sm leading-relaxed mb-4">
                    Publikasi laporan & artikel analisis risiko rantai pasok global untuk pemangku kepentingan dan tim manajerial impor.
                </p>
                <div class="d-flex gap-2">
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary btn-block shadow-sm">
                        <i class="fas fa-book-open mr-1"></i> Daftar Artikel
                    </a>
                    <a href="{{ route('articles.create') }}" class="btn btn-outline-secondary shadow-sm ml-2">
                        <i class="fas fa-pen-nib mr-1"></i> Tulis
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent System Data Tables -->
<div class="row">
    <!-- User Table -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-users-cog text-info mr-2"></i> Pengguna Terbaru
                </h3>
                <a href="{{ route('users.index') }}" class="btn btn-xs btn-outline-info font-weight-bold">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $u)
                            <tr>
                                <td class="font-weight-bold">{{ $u->name }}</td>
                                <td class="text-muted">{{ $u->email }}</td>
                                <td>
                                    <span class="badge {{ $u->isAdmin() ? 'badge-danger' : 'badge-primary' }} px-2 py-1">
                                        {{ $u->role ?? 'User' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Articles Table -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-newspaper text-warning mr-2"></i> Artikel Analisis Terbaru
                </h3>
                <a href="{{ route('articles.index') }}" class="btn btn-xs btn-outline-warning font-weight-bold">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Judul Artikel</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentArticles as $art)
                            <tr>
                                <td class="font-weight-bold text-dark">{{ Str::limit($art->title, 35) }}</td>
                                <td><span class="badge badge-info">{{ $art->category }}</span></td>
                                <td class="text-muted">{{ $art->author }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">Belum ada artikel analisis.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
