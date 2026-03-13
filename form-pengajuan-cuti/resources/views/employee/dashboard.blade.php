<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="fw-bold fs-3 text-dark">
                {{ __('Dashboard Pegawai') }}
            </h2>

            <a href="{{ route('employee.apply') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="text-uppercase small fw-semibold">
                    Ajukan Cuti
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="container">

            <div class="row g-4 mb-4">
                
                <!-- Kiri: Card Profile -->
                <div class="col-md-4">
                    <div class="card text-white shadow-lg border-0 h-100" style="background: linear-gradient(135deg,#2563eb,#1d4ed8); border-radius:20px;">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <p class="small mb-1 text-light">Selamat Datang,</p>
                                <h3 class="fw-bold mb-1">{{ Auth::user()->name }}</h3>
                                <div class="small text-light opacity-75">
                                    {{ Auth::user()->nik ?? '-' }} &bull; {{ Auth::user()->jabatan ?? '-' }}
                                    <br>
                                    {{ Auth::user()->bagian ?? '-' }}
                                </div>
                            </div>

                            <p class="small mt-3 text-light">
                                Pantau sisa kuota cuti dan status pengajuan Anda secara real-time.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tengah: 2 Card Saldo Cuti (Atas Bawah) -->
                <div class="col-md-4 d-flex flex-column gap-3">
                    <div class="card shadow-sm border-0 flex-fill" style="border-radius:20px;">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="p-3 rounded bg-primary bg-opacity-10 text-primary">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-muted small mb-1">Cuti Tahun {{ $balance->year }}</p>
                                <h4 class="fw-bold">
                                    {{ $balance->current_leave_balance }} <span class="small text-muted">Hari</span>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 flex-fill" style="border-radius:20px;">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="p-3 rounded bg-warning bg-opacity-10 text-warning">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-muted small mb-1">Sisa Tahun Lalu</p>
                                <h4 class="fw-bold">
                                    {{ $balance->previous_leave_balance }} <span class="small text-muted">Hari</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Informasi & Kebijakan -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100" style="border-radius:20px;">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3 border-bottom pb-2">Informasi & Kebijakan</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex mb-2">
                                    <span class="badge bg-primary rounded-circle me-2 align-self-start mt-1">1</span>
                                    <p class="small text-muted mb-0">Pengajuan cuti maksimal <strong>H-7</strong>.</p>
                                </li>
                                <li class="d-flex mb-2">
                                    <span class="badge bg-primary rounded-circle me-2 align-self-start mt-1">2</span>
                                    <p class="small text-muted mb-0">Wajib bukti jika sakit >1 hari.</p>
                                </li>
                                <li class="d-flex">
                                    <span class="badge bg-primary rounded-circle me-2 align-self-start mt-1">3</span>
                                    <p class="small text-muted mb-0">Sisa tahun lalu hangus setelah <strong>Maret</strong>.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bawah: Riwayat Pengajuan (Full Width) -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="fw-bold">Riwayat Pengajuan</h4>
                    </div>

                    <div class="card shadow-sm border-0" style="border-radius:20px;">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center small text-uppercase">Tanggal Pengajuan</th>
                                        <th class="text-center small text-uppercase">Kategori</th>
                                        <th class="text-center small text-uppercase">Tanggal Cuti</th>
                                        <th class="text-center small text-uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($requests as $req)
                                <tr>
                                    <td class="text-center text-muted">
                                        {{ $req->tanggal_pengajuan->format('d M Y') }}
                                    </td>
                                    <td class="text-center fw-semibold">
                                        @php $categories = json_decode($req->category, true); @endphp
                                        {{ is_array($categories) ? implode(', ', $categories) : $req->category }}
                                    </td>
                                    <td class="text-center">
                                        @php $dates = json_decode($req->tanggal_cuti, true); @endphp
                                        <span class="badge bg-light text-dark border">
                                            {{ is_array($dates) ? implode(', ', $dates) : $req->tanggal_cuti }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($req->status === 'pending')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Menunggu</span>
                                        @elseif($req->status === 'approved')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger px-3 py-2 rounded-pill">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        Belum ada riwayat pengajuan.
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
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</x-app-layout>