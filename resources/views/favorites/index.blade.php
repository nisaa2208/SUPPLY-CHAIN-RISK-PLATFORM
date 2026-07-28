@extends('adminlte::page')

@section('title', 'Daftar Favorit Saya')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-star text-warning mr-2"></i>
            Daftar Favorit & Watchlist
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Negara & Entitas Pasokan yang Anda Tandai untuk Pemantauan Khusus
        </div>
    </div>
</div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <h3 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-bookmark text-warning mr-2"></i> Tambah Negara ke Daftar Favorit
        </h3>
    </div>
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-9 mb-3 mb-md-0">
                <form id="addFavoriteForm" action="" method="POST" class="d-flex gap-2">
                    @csrf
                    <select id="countrySelect" class="form-control custom-select" required>
                        <option value="" disabled selected>-- Pilih Negara untuk Ditambahkan --</option>
                        @foreach($allCountries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }} ({{ $country->region }})</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="col-md-3">
                <button type="button" onclick="submitFavorite()" class="btn btn-warning btn-block shadow-sm">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Favorit
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-3">
        <h3 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-star text-warning mr-2"></i> Negara Favorit Saya ({{ $watchlists->count() }})
        </h3>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="thead-light">
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Nama Negara</th>
                        <th>Wilayah</th>
                        <th width="180">Skor Risiko</th>
                        <th>Level Risiko</th>
                        <th>Shipping Status</th>
                        <th width="140" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($watchlists as $item)
                    @if($item->country)
                    <tr>
                        <td class="text-center text-muted font-weight-bold">{{ $loop->iteration }}</td>

                        <td>
                            <a href="{{ route('countries.show', $item->country->id) }}" class="font-weight-bold text-dark hover-primary">
                                <i class="fas fa-flag text-primary mr-2"></i>{{ $item->country->name }}
                            </a>
                        </td>

                        <td><span class="text-muted">{{ $item->country->region }}</span></td>

                        <td>
                            <div class="d-flex align-items-center">
                                <span class="font-weight-bold mr-2" style="width: 38px;">{{ $item->country->risk_score }}%</span>
                                <div class="progress flex-grow-1" style="height: 6px; border-radius: 4px;">
                                    <div class="progress-bar {{ $item->country->risk_score >= 70 ? 'bg-danger' : ($item->country->risk_score >= 40 ? 'bg-warning' : 'bg-success') }}" 
                                         style="width: {{ $item->country->risk_score }}%;"></div>
                                </div>
                            </div>
                        </td>

                        <td>
                            @if($item->country->risk_level == 'High')
                                <span class="badge badge-high">High Risk</span>
                            @elseif($item->country->risk_level == 'Medium')
                                <span class="badge badge-medium">Medium Risk</span>
                            @else
                                <span class="badge badge-low">Low Risk</span>
                            @endif
                        </td>

                        <td>
                            @if($item->country->shipping_status == 'Critical')
                                <span class="badge badge-danger">Critical</span>
                            @elseif($item->country->shipping_status == 'Delayed')
                                <span class="badge badge-warning">Delayed</span>
                            @else
                                <span class="badge badge-success">Normal</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <form action="{{ route('favorites.toggle', $item->country->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus dari Favorit">
                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-star fa-3x mb-3 text-warning opacity-50"></i>
                            <h6 class="font-weight-bold">Belum Ada Negara Favorit</h6>
                            <p class="text-muted mb-0">Pilih negara di atas untuk ditambahkan ke daftar favorit pemantauan Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop

@section('js')
<script>
function submitFavorite() {
    var countryId = document.getElementById('countrySelect').value;
    if (!countryId) {
        alert('Silakan pilih negara terlebih dahulu.');
        return;
    }
    var form = document.getElementById('addFavoriteForm');
    form.action = "{{ url('/favorites/toggle') }}/" + countryId;
    form.submit();
}
</script>
@stop
