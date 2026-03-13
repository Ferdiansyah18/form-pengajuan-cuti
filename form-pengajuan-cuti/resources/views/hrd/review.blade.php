```html
<x-app-layout>

<x-slot name="header">
<h2 class="fw-bold fs-4">
Review Pengajuan Cuti / Izin
</h2>
</x-slot>


<div class="py-4">
<div class="container" style="max-width:1000px;">


<!-- HEADER CARD -->

<div class="card border-0 shadow-sm mb-4">
<div class="card-body d-flex justify-content-between align-items-center">

<div>
<h5 class="fw-bold mb-1">
Form Pengajuan #{{ $leaveRequest->id }}
</h5>

<p class="text-muted small mb-0">
Detail permohonan cuti pegawai
</p>
</div>

<div>

@if($leaveRequest->status === 'pending')

<span class="badge rounded-pill bg-warning text-dark px-3 py-2">
Pending
</span>

@elseif($leaveRequest->status === 'approved')

<span class="badge rounded-pill bg-success px-3 py-2">
Approved
</span>

@else

<span class="badge rounded-pill bg-danger px-3 py-2">
Rejected
</span>

@endif

</div>

</div>
</div>



<!-- INFORMASI PEGAWAI -->

<div class="card border-0 shadow-sm mb-4">
<div class="card-body">

<h5 class="fw-bold mb-4">
Informasi Pegawai
</h5>

<div class="row g-3">

<div class="col-md-6">

<div class="row mb-3">
<div class="col-5 text-muted small">
Nama Pegawai
</div>
<div class="col-7 fw-semibold">
{{ $leaveRequest->user->name }}
</div>
</div>

<div class="row mb-3">
<div class="col-5 text-muted small">
Nomor Induk / NIK
</div>
<div class="col-7">
{{ $leaveRequest->user->nik ?? '-' }}
</div>
</div>

<div class="row mb-3">
<div class="col-5 text-muted small">
Jabatan
</div>
<div class="col-7">
{{ $leaveRequest->user->jabatan ?? '-' }}
</div>
</div>

<div class="row mb-3">
<div class="col-5 text-muted small">
Bagian
</div>
<div class="col-7">
{{ $leaveRequest->user->bagian ?? '-' }}
</div>
</div>

</div>



<div class="col-md-6">

<div class="row mb-3">
<div class="col-5 text-muted small">
Tanggal Pengajuan
</div>
<div class="col-7">
{{ $leaveRequest->tanggal_pengajuan->format('d F Y') }}
</div>
</div>

<div class="row mb-3">
<div class="col-5 text-muted small">
Kategori
</div>
<div class="col-7">

@php $categories = json_decode($leaveRequest->category, true); @endphp

{{ is_array($categories) ? implode(', ', $categories) : $leaveRequest->category }}

</div>
</div>

<div class="row mb-3">
<div class="col-5 text-muted small">
Tanggal Cuti
</div>
<div class="col-7">

@php $dates = json_decode($leaveRequest->tanggal_cuti, true); @endphp

{{ is_array($dates) ? implode(', ', $dates) : $leaveRequest->tanggal_cuti }}

</div>
</div>

</div>

</div>

</div>
</div>



<!-- ALASAN + SIGNATURE -->

<div class="row g-4 mb-4">

<div class="col-md-6">

<div class="card border-0 shadow-sm h-100">
<div class="card-body">

<h5 class="fw-bold mb-3">
Alasan Pengajuan
</h5>

<div class="bg-light rounded p-3 small text-muted" style="white-space:pre-line;">
{{ $leaveRequest->reason }}
</div>

</div>
</div>

</div>



<div class="col-md-6">

<div class="card border-0 shadow-sm text-center h-100">
<div class="card-body">

<h5 class="fw-bold mb-3">
Tanda Tangan Pemohon
</h5>

<div class="border rounded bg-light p-3">

@if($leaveRequest->signature_path)

<img
src="{{ asset('storage/' . $leaveRequest->signature_path) }}"
class="img-fluid"
style="max-height:150px"
>

@else

<p class="text-muted small mb-0">
Tidak ada tanda tangan
</p>

@endif

</div>

</div>
</div>

</div>

</div>



@php
    $categories = json_decode($leaveRequest->category, true);
    $catArray = is_array($categories) ? $categories : [$leaveRequest->category];
    $isCutiType = in_array('Cuti', $catArray) || in_array('Ijin Potong Cuti (IPC)', $catArray);
@endphp

@if($isCutiType)
<!-- KHUSUS CUTI / IPC: PENGISIAN SALDO DAN VERIFIKASI -->
<div class="card border-0 shadow-sm mb-4 bg-light">
    <div class="card-body">
        
        <h5 class="fw-bold mb-4 text-primary">
            Verifikasi Sisa Cuti (Khusus Cuti & IPC)
        </h5>

        <div class="row g-4">
            
            <!-- Perhitungan Sisa Cuti -->
            <div class="col-md-6 border-end">
                <div class="row mb-3 align-items-center">
                    <div class="col-6 text-muted small">Sisa Cuti Sebelumnya</div>
                    <div class="col-6">
                        <input type="number" class="form-control form-control-sm" name="sisa_cuti_sebelumnya" id="input_sisa_cuti_sebelumnya" placeholder="Misal: 2">
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-6 text-muted small">Tahun Cuti</div>
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm" name="tahun_cuti" value="{{ date('Y') }}">
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-6 text-muted small">Cuti Diambil</div>
                    <div class="col-6">
                        @php 
                            $dates = json_decode($leaveRequest->tanggal_cuti, true); 
                            $daysTaken = is_array($dates) ? count($dates) : 1;
                        @endphp
                        <input type="number" class="form-control form-control-sm bg-white" name="cuti_diambil" id="input_cuti_diambil" value="{{ $daysTaken }}" readonly>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-6 fw-bold">Sisa Cuti Saat Ini</div>
                    <div class="col-6">
                        <input type="number" class="form-control form-control-sm fw-bold bg-white" name="sisa_cuti" id="input_sisa_cuti" placeholder="Dihitung otomatis..." readonly>
                    </div>
                </div>
            </div>

            <!-- Bagian Pengecekan / TTD HRD & Payroll -->
            <div class="col-md-6">
                <p class="text-muted small mb-3">Kolom Verifikasi (Diisi oleh pihak terkait)</p>

                <div class="form-check mb-3">
                    <input class="form-check-input border-secondary" type="checkbox" id="cek_hrd" name="cek_hrd" value="1">
                    <label class="form-check-label fw-semibold" for="cek_hrd">
                        Dicek Oleh HRD
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input border-secondary" type="checkbox" id="cek_payroll" name="cek_payroll" value="1">
                    <label class="form-check-label fw-semibold" for="cek_payroll">
                        Dicek Oleh Payroll
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input border-secondary" type="checkbox" id="diterima_user" name="diterima_user" value="1">
                    <label class="form-check-label fw-semibold" for="diterima_user">
                        Diterima Oleh User / Pegawai
                    </label>
                </div>
                <!-- Catatan: Untuk real implementasi, bagian ini idealnya menggunakan sistem signature/login terpisah -->
            </div>

        </div>

    </div>
</div>
</div>
@endif

@php
    $isTimeBasedType = in_array('Ijin Masuk Terlambat', $catArray) || 
                       in_array('Ijin Pulang Awal', $catArray) || 
                       in_array('Dinas Luar (DL) / Tugas Luar (TL)', $catArray);
@endphp

@if($isTimeBasedType)
<!-- KHUSUS IJIN WAKTU & DINAS: JAM MASUK, JAM KELUAR, VERIFIKASI -->
<div class="card border-0 shadow-sm mb-4 bg-light">
    <div class="card-body">
        
        <h5 class="fw-bold mb-4 text-warning">
            Pengecekan Data Waktu (Khusus Izin Masuk/Pulang/Dinas)
        </h5>

        <div class="row g-4">
            
            <!-- Input Jam -->
            <div class="col-md-6 border-end">
                <div class="row mb-3 align-items-center">
                    <div class="col-4 text-muted small">Jam Masuk</div>
                    <div class="col-8">
                        <input type="time" class="form-control form-control-sm" name="jam_masuk">
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-4 text-muted small">Jam Keluar</div>
                    <div class="col-8">
                        <input type="time" class="form-control form-control-sm" name="jam_keluar">
                    </div>
                </div>
            </div>

            <!-- Bagian Pengecekan / TTD Security & Payroll -->
            <div class="col-md-6">
                <p class="text-muted small mb-3">Kolom Verifikasi</p>

                <div class="form-check mb-3">
                    <input class="form-check-input border-secondary" type="checkbox" id="cek_security_waktu" name="cek_security_waktu" value="1">
                    <label class="form-check-label fw-semibold" for="cek_security_waktu">
                        Dicek Oleh Security
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input border-secondary" type="checkbox" id="cek_payroll_waktu" name="cek_payroll_waktu" value="1">
                    <label class="form-check-label fw-semibold" for="cek_payroll_waktu">
                        Dicek Oleh Payroll
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input border-secondary" type="checkbox" id="diterima_user_waktu" name="diterima_user_waktu" value="1">
                    <label class="form-check-label fw-semibold" for="diterima_user_waktu">
                        Diterima Oleh User / Pegawai
                    </label>
                </div>
            </div>

        </div>

    </div>
</div>
@endif

<!-- FORM KEPUTUSAN -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        
        <h5 class="fw-bold mb-4">
            Keputusan HRD
        </h5>

        <form action="{{ route('hrd.update', $leaveRequest->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- STATUS -->
            <div class="mb-4">
                <label class="form-label fw-semibold mb-2">
                    Ubah Status Pengajuan
                </label>
                <div class="d-flex gap-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="pending" {{ $leaveRequest->status === 'pending' ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Pending
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="approved" {{ $leaveRequest->status === 'approved' ? 'checked' : '' }}>
                        <label class="form-check-label text-success fw-semibold">
                            Approve
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="rejected" {{ $leaveRequest->status === 'rejected' ? 'checked' : '' }}>
                        <label class="form-check-label text-danger fw-semibold">
                            Reject
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                <a href="{{ route('hrd.dashboard') }}" class="btn btn-outline-secondary">
                    ← Kembali
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    Simpan Keputusan @if($isCutiType || $isTimeBasedType) & Data Verifikasi @endif
                </button>
            </div>
        </form>

    </div>
</div>

<!-- DATA YANG DI-HIDE SEMENTARA (CATATAN HRD & SECURITY) -->
<!--
<div class="card border-0 shadow-sm">
<div class="card-body">

<h5 class="fw-bold mb-4">
Tindak Lanjut HRD / Security
</h5>

... (hidden temporarily by user request) ...

</div>
</div>
-->


</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@if($isCutiType)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputSebelumnya = document.getElementById('input_sisa_cuti_sebelumnya');
        const inputDiambil = document.getElementById('input_cuti_diambil');
        const inputSisa = document.getElementById('input_sisa_cuti');

        if(inputSebelumnya && inputDiambil && inputSisa) {
            inputSebelumnya.addEventListener('input', function() {
                const sisaSebelumnya = parseInt(this.value) || 0;
                const diambil = parseInt(inputDiambil.value) || 0;
                inputSisa.value = sisaSebelumnya - diambil;
            });
        }
    });
</script>
@endif
</x-app-layout>
```
