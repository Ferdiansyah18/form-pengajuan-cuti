<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Form Pengajuan Cuti / Izin') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="mx-auto" style="max-width:700px;">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-dark">

                        <form action="{{ route('employee.store') }}" method="POST" id="leave-form">
                            @csrf

                            <!-- Kategori Cuti / Izin -->
                            <div class="mb-4">
                                <span class="form-label fw-medium">Pilih Kategori:</span>

                                <div class="d-flex flex-wrap gap-3 mt-2">

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category[]" value="Cuti">
                                        <label class="form-check-label">Cuti</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category[]" value="Ijin Potong Cuti (IPC)">
                                        <label class="form-check-label">Ijin Potong Cuti (IPC)</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category[]" value="Ijin Pulang Awal">
                                        <label class="form-check-label">Ijin Pulang Awal</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category[]" value="Ijin Dinas Luar">
                                        <label class="form-check-label">Ijin Dinas Luar</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category[]" value="Ganti Hari">
                                        <label class="form-check-label">Ganti Hari</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category[]" value="Ijin Resmi">
                                        <label class="form-check-label">Ijin Resmi</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category[]" value="Ijin Potong Gaji (IPG)">
                                        <label class="form-check-label">Ijin Potong Gaji (IPG)</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category[]" value="Ijin Masuk Terlambat">
                                        <label class="form-check-label">Ijin Masuk Terlambat</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category[]" value="Ijin Pribadi">
                                        <label class="form-check-label">Ijin Pribadi</label>
                                    </div>

                                </div>

                                @error('category')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Tanggal Pengajuan -->
                            <div class="mb-4">
                                <label for="tanggal_pengajuan_cuti" class="form-label">
                                    Tanggal Pengajuan Cuti
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_pengajuan_cuti"
                                    id="tanggal_pengajuan_cuti"
                                    class="form-control"
                                    value="{{ old('tanggal_pengajuan_cuti') }}"
                                >

                                @error('tanggal_pengajuan_cuti')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Tanggal Cuti -->
                            <div class="mb-4">
                                <label for="tanggal_cuti" class="form-label">
                                    Tanggal (Pisahkan dengan koma jika lebih dari satu hari)
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_cuti"
                                    id="tanggal_cuti"
                                    class="form-control"
                                    value="{{ old('tanggal_cuti') }}"
                                >

                                @error('tanggal_cuti')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Alasan -->
                            <div class="mb-4">
                                <label for="reason" class="form-label">
                                    Alasan / Detail Keperluan
                                </label>

                                <textarea
                                    name="reason"
                                    id="reason"
                                    rows="4"
                                    class="form-control"
                                >{{ old('reason') }}</textarea>

                                @error('reason')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Signature -->
                            <div class="mb-4">

                                <label class="form-label">
                                    Tanda Tangan Pemohon
                                </label>

                                <div class="border border-2 border-secondary border-opacity-25 rounded p-2 bg-light mx-auto" style="max-width:400px;">
                                    <canvas id="signature-pad" class="w-100" style="height:180px; cursor:crosshair; background:white;"></canvas>
                                </div>

                                <div class="text-center mt-2">
                                    <button type="button" id="clear-signature" class="btn btn-sm btn-outline-danger">
                                        Bersihkan Tanda Tangan
                                    </button>
                                </div>

                                <input type="hidden" name="signature" id="signature">

                                @error('signature')
                                    <p class="text-danger small mt-1">
                                        Tanda tangan wajib diisi.
                                    </p>
                                @enderror

                            </div>


                            <!-- Submit -->
                            <div class="d-flex justify-content-end align-items-center gap-3 mt-4">

                                <a href="{{ route('employee.dashboard') }}" class="text-decoration-underline text-secondary">
                                    Batal
                                </a>

                                <button type="submit" id="submit-btn" class="btn btn-primary text-uppercase fw-semibold">
                                    Ajukan Permohonan
                                </button>

                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script for Signature Pad & SweetAlert Confirmation -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const canvas = document.getElementById('signature-pad');
            const signatureInput = document.getElementById('signature');
            const clearButton = document.getElementById('clear-signature');
            const form = document.getElementById('leave-form');
            const ctx = canvas.getContext('2d');

            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                ctx.scale(ratio, ratio);
                ctx.lineWidth = 2;
            }

            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();

            let drawing = false;
            let hasSignature = false;

            function getCoordinates(e) {
                const rect = canvas.getBoundingClientRect();
                const clientX = e.clientX || (e.touches && e.touches[0].clientX);
                const clientY = e.clientY || (e.touches && e.touches[0].clientY);
                return {
                    x: clientX - rect.left,
                    y: clientY - rect.top
                };
            }

            function startDrawing(e) {
                e.preventDefault();
                drawing = true;
                const pos = getCoordinates(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            }

            function draw(e) {
                if (!drawing) return;
                e.preventDefault();
                hasSignature = true;
                const pos = getCoordinates(e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
                ctx.strokeStyle = '#000000';
            }

            function stopDrawing() {
                drawing = false;
                ctx.closePath();
            }

            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mouseleave', stopDrawing);

            canvas.addEventListener('touchstart', startDrawing);
            canvas.addEventListener('touchmove', draw);
            canvas.addEventListener('touchend', stopDrawing);

            clearButton.addEventListener('click', function () {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                signatureInput.value = '';
                hasSignature = false;
            });

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                // Grap inputs for confirmation
                const checkboxes = document.querySelectorAll('input[name="category[]"]:checked');
                const categories = Array.from(checkboxes).map(cb => cb.value).join(', ');
                const tanggalPengajuan = document.getElementById('tanggal_pengajuan_cuti').value.trim();
                const tanggalCuti = document.getElementById('tanggal_cuti').value.trim();
                const reason = document.getElementById('reason').value.trim();

                let missingFields = [];

                if (categories.length === 0) {
                     missingFields.push('Kategori Izin/Cuti');
                }
                if (!tanggalPengajuan) {
                     missingFields.push('Tanggal Pengajuan');
                }
                if (!tanggalCuti) {
                     missingFields.push('Tanggal Cuti/Izin');
                }
                if (!reason) {
                     missingFields.push('Alasan / Detail Keperluan');
                }
                if (!hasSignature) {
                     missingFields.push('Tanda Tangan');
                }

                if (missingFields.length > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        html: 'Mohon lengkapi bagian berikut:<br><br><ul class="text-start mb-0"><li>' + missingFields.join('</li><li>') + '</li></ul>',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                // Show SweetAlert
                Swal.fire({
                    title: 'Konfirmasi Pengajuan',
                    html: `
                        <div class="text-start mt-3" style="font-size: 0.95rem;">
                            <p class="mb-2"><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                            <p class="mb-2"><strong>Jabatan:</strong> {{ Auth::user()->jabatan ?? '-' }}</p>
                            <p class="mb-2"><strong>Kategori:</strong> ${categories}</p>
                            <p class="mb-2"><strong>Tanggal Cuti/Izin:</strong> ${tanggalCuti}</p>
                            <p class="mb-2"><strong>Alasan:</strong><br><span class="text-muted">${reason}</span></p>
                            <br>
                            <p class="text-danger small mb-0">Apakah data di atas sudah benar?</p>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Ajukan Sekarang',
                    cancelButtonText: 'Batal, Periksa Lagi'
                }).then((result) => {
                    if (result.isConfirmed) {
                        signatureInput.value = canvas.toDataURL('image/png');
                        form.submit();
                    }
                });
            });
        });
    </script>

</x-app-layout>