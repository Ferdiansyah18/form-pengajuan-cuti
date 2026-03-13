<x-app-layout>

<x-slot name="header">
<h2 class="fw-bold fs-4 text-dark">
    Dashboard HRD
</h2>
</x-slot>

<div class="py-4">
<div class="container">

@if(session('success'))
<div class="alert alert-success shadow-sm">
{{ session('success') }}
</div>
@endif


<!-- STATISTIC CARDS -->

<div class="row g-3 mb-4">

<div class="col-md-3">
<div class="card border-0 shadow-sm h-100">
<div class="card-body">

<h6 class="text-muted small mb-1">
Total Pengajuan
</h6>

<h3 class="fw-bold">
{{ $requests->count() }}
</h3>

</div>
</div>
</div>


<div class="col-md-3">
<div class="card border-0 shadow-sm h-100">
<div class="card-body">

<h6 class="text-muted small mb-1">
Pending
</h6>

<h3 class="fw-bold text-warning">
{{ $requests->where('status','pending')->count() }}
</h3>

</div>
</div>
</div>


<div class="col-md-3">
<div class="card border-0 shadow-sm h-100">
<div class="card-body">

<h6 class="text-muted small mb-1">
Disetujui
</h6>

<h3 class="fw-bold text-success">
{{ $requests->where('status','approved')->count() }}
</h3>

</div>
</div>
</div>


<div class="col-md-3">
<div class="card border-0 shadow-sm h-100">
<div class="card-body">

<h6 class="text-muted small mb-1">
Ditolak
</h6>

<h3 class="fw-bold text-danger">
{{ $requests->where('status','rejected')->count() }}
</h3>

</div>
</div>
</div>

</div>



<!-- MAIN CARD -->

<div class="card border-0 shadow-lg">

<div class="card-body">


<!-- HEADER + FILTER -->

<div class="row align-items-center mb-4">

    <!-- Judul -->
    <div class="col-md-5 mb-3 mb-md-0">
        <h4 class="fw-bold mb-1">
            Daftar Pengajuan Cuti / Izin
        </h4>
        <p class="text-muted small mb-0">
            Kelola semua permintaan cuti pegawai
        </p>
    </div>

    <!-- Filter Form (Rata Kanan) -->
    <div class="col-md-7">
        <form action="{{ route('hrd.dashboard') }}" method="GET" class="d-flex justify-content-md-end gap-2 flex-nowrap">
        
            <!-- Pencarian Nama -->
            <input 
                type="text" 
                name="search" 
                class="form-control form-control-sm border-secondary-subtle font-monospace" 
                placeholder="Cari nama..." 
                value="{{ request('search') }}" 
                style="min-width: 120px;"
            >

            <!-- Filter Bulan -->
            <select name="month" class="form-select form-select-sm border-secondary-subtle" style="width: auto;">
                <option value="">Bulan</option>
                @php
                    $months = [
                        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                    ];
                @endphp
                @foreach($months as $num => $name)
                    <option value="{{ str_pad($num, 2, '0', STR_PAD_LEFT) }}" {{ request('month') == $num ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>

            <!-- Filter Tahun -->
            <select name="year" class="form-select form-select-sm border-secondary-subtle" style="width: auto;">
                <option value="">Tahun</option>
                @for($i = date('Y') - 1; $i <= date('Y') + 2; $i++)
                    <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>

            <button type="submit" class="btn btn-sm btn-primary px-3">
                Cari
            </button>

            @if(request('search') || request('month') || request('year'))
                <a href="{{ route('hrd.dashboard') }}" class="btn btn-sm btn-outline-danger px-3">
                    X
                </a>
            @endif

        </form>
    </div>

</div>



<!-- TABLE -->

<div class="table-responsive">

<table class="table align-middle table-hover">

<thead class="border-bottom">

<tr class="text-muted small text-uppercase text-center">

<th>Tanggal</th>
<th>Pegawai</th>
<th>Kategori</th>
<th>Tanggal Cuti</th>
<th>Status</th>
<th>Aksi</th>

</tr>

</thead>


<tbody>

@forelse($requests as $req)

<tr class="text-center align-middle">

<td>
{{ $req->tanggal_pengajuan->format('d/m/Y') }}
</td>

<td class="fw-semibold">
{{ $req->user->name }}
</td>

<td>

@php $categories = json_decode($req->category, true); @endphp

{{ is_array($categories) ? implode(', ', $categories) : $req->category }}

</td>

<td class="text-muted">

@php $dates = json_decode($req->tanggal_cuti, true); @endphp

{{ is_array($dates) ? implode(', ', $dates) : $req->tanggal_cuti }}

</td>

<td>

@if($req->status === 'pending')

<span class="badge rounded-pill bg-warning text-dark px-3 py-2">
Pending
</span>

@elseif($req->status === 'approved')

<span class="badge rounded-pill bg-success px-3 py-2">
Approved
</span>

@else

<span class="badge rounded-pill bg-danger px-3 py-2">
Rejected
</span>

@endif

</td>

<td>

<a
href="{{ route('hrd.review', $req->id) }}"
class="btn btn-sm btn-dark"
>
Review
</a>

</td>

</tr>

@empty

<tr>

<td colspan="6" class="text-center text-muted py-5">

Belum ada data pengajuan

</td>

</tr>

@endforelse

</tbody>

</table>

</div>


</div>

</div>

</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</x-app-layout>