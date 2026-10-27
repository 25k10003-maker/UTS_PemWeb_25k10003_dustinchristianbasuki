<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard · SiAkad-003</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #1E88E5;
            --primary-hover: #1565C0;
            --primary-light: #E3F2FD;
            --bg-color: #F8F9FA;
            --text-dark: #0F172A;
            --text-muted: #64748B;
        }

        /* Warna gradient per role */
        .hero-admin  { background: linear-gradient(135deg, #1E88E5 0%, #1565C0 100%); }
        .hero-dosen  { background: linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%); }
        .hero-mahasiswa { background: linear-gradient(135deg, #059669 0%, #047857 100%); }

        body {
            background-color: var(--bg-color);
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
        }

        .hero-banner {
            border-radius: 20px;
            color: #FFFFFF;
            padding: 34px 40px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
            position: relative;
            overflow: hidden;
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            right: -20px;
            top: -40px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
            pointer-events: none;
        }

        .badge-pill-white {
            background-color: #FFFFFF;
            color: var(--primary-color);
            font-weight: 700;
            padding: 5px 16px;
            border-radius: 50px;
            font-size: 0.825rem;
            display: inline-block;
        }

        .hero-dosen .badge-pill-white { color: #7C3AED; }
        .hero-mahasiswa .badge-pill-white { color: #059669; }

        .badge-pill-glass {
            background-color: rgba(255, 255, 255, 0.22);
            color: #FFFFFF;
            font-weight: 600;
            padding: 5px 16px;
            border-radius: 50px;
            font-size: 0.825rem;
            backdrop-filter: blur(8px);
            display: inline-block;
        }

        .avatar-img {
            width: 88px;
            height: 88px;
            border-radius: 20px;
            object-fit: cover;
            border: 3.5px solid rgba(255, 255, 255, 0.35);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .stat-card {
            background: #FFFFFF;
            border: none;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        }

        .icon-box {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background-color: var(--primary-light);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 14px;
        }

        .stat-number {
            font-size: 2.3rem;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.1;
            margin-top: 6px;
        }

        .content-card {
            background: #FFFFFF;
            border: none;
            border-radius: 18px;
            padding: 28px 30px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
        }

        .btn-custom-primary {
            background-color: var(--primary-color);
            color: #FFFFFF;
            border: none;
            border-radius: 10px;
            padding: 9px 22px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-custom-primary:hover {
            background-color: var(--primary-hover);
            color: #FFFFFF;
        }

        .btn-custom-light {
            background-color: #F1F5F9;
            color: #475569;
            border: none;
            border-radius: 10px;
            padding: 9px 22px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-custom-light:hover {
            background-color: #E2E8F0;
            color: #1E293B;
        }

        .footer-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #CBD5E1;
        }

        .bg-custom-primary {
            background-color: var(--primary-color) !important;
        }

        .khs-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            border: 1px solid #bbf7d0;
            border-radius: 16px;
            padding: 24px;
        }

        .khs-title {
            color: #047857;
            font-weight: 700;
            font-size: 1.1rem;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    @php
        $sessionUser = session('user');
        $userRole    = is_array($sessionUser) ? ($sessionUser['role'] ?? 'mahasiswa') : 'mahasiswa';
        $userName    = is_array($sessionUser) ? ($sessionUser['name'] ?? 'Pengguna') : 'Pengguna';
        $userNim     = is_array($sessionUser) ? ($sessionUser['nim'] ?? ($sessionUser['username'] ?? '-')) : '-';
        $userAvatar  = is_array($sessionUser) ? ($sessionUser['avatar'] ?? null) : null;

        // Pilih CSS class hero berdasarkan role
        $heroClass = match($userRole) {
            'admin' => 'hero-admin',
            'dosen' => 'hero-dosen',
            default => 'hero-mahasiswa',
        };
    @endphp

    <div class="container py-4 flex-grow-1" style="max-width: 1040px;">

        <!-- Top bar -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="text-secondary small mb-0">Ringkasan aktivitas SiAkad-003.</p>
            <div class="small">
                <a href="{{ route('logout') }}" class="text-decoration-none text-muted">
                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- ============================================================ -->
        <!-- HERO BANNER — Warna & teks berbeda per role                  -->
        <!-- ============================================================ -->
        <div class="hero-banner {{ $heroClass }} mb-4 d-flex justify-content-between align-items-center">
            <div>
                <small class="text-uppercase fw-bold text-white-50" style="letter-spacing: 1px; font-size: 0.75rem;">
                    DASHBOARD {{ strtoupper($userRole) }}
                </small>
                <h2 class="fw-bold my-1" style="font-size: 1.85rem;">Halo, {{ $userName }} 👋</h2>
                <p class="mb-3 text-white-50" style="font-size: 0.925rem;">
                    @if($userRole === 'admin')
                        Selamat datang kembali di portal pendaftaran dan penilaian mahasiswa.
                    @elseif($userRole === 'dosen')
                        Selamat datang kembali di portal penginputan dan pengelolaan nilai.
                    @else
                        Selamat datang di portal informasi dan kartu hasil studi.
                    @endif
                </p>
                <div class="d-flex gap-2">
                    <span class="badge-pill-white">{{ ucfirst($userRole) }}</span>
                    <span class="badge-pill-glass">
                        @if($userRole === 'dosen') NIP @else NIM @endif: {{ $userNim }}
                    </span>
                </div>
            </div>
            <div class="d-none d-md-block">
                <img src="{{ asset($userAvatar ?? 'uploads/profile_dustin.png') }}" alt="{{ $userName }}" class="avatar-img">
            </div>
        </div>

        <!-- ============================================================ -->
        <!-- STATISTIK — Isi kartu berbeda per role                       -->
        <!-- ============================================================ -->
        <div class="row g-3 mb-4">
            @if($userRole === 'admin')
                {{-- Admin: Matakuliah, Jumlah Mahasiswa, Total Nilai --}}
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="icon-box"><i class="bi bi-journal-bookmark-fill"></i></div>
                        <span class="text-muted small">Mata kuliah terdaftar</span>
                        <div class="stat-number">{{ $totalMatakuliah ?: 3 }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="icon-box"><i class="bi bi-people-fill"></i></div>
                        <span class="text-muted small">Akun mahasiswa</span>
                        <div class="stat-number">{{ count($mahasiswa ?? []) ?: 2 }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="icon-box"><i class="bi bi-check2-circle"></i></div>
                        <span class="text-muted small">Total nilai terinput</span>
                        <div class="stat-number">{{ $totalNilai ?: 3 }}</div>
                    </div>
                </div>
            @elseif($userRole === 'dosen')
                {{-- Dosen: Mahasiswa Diampu, Nilai yang Diinput, Matakuliah --}}
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="icon-box" style="background:#EDE9FE;color:#7C3AED;"><i class="bi bi-people-fill"></i></div>
                        <span class="text-muted small">Mahasiswa diampu</span>
                        <div class="stat-number">{{ count($mahasiswa ?? []) ?: 2 }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="icon-box" style="background:#EDE9FE;color:#7C3AED;"><i class="bi bi-pencil-square"></i></div>
                        <span class="text-muted small">Nilai yang diinput</span>
                        <div class="stat-number">{{ $totalNilai ?: 3 }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="icon-box" style="background:#EDE9FE;color:#7C3AED;"><i class="bi bi-journal-bookmark-fill"></i></div>
                        <span class="text-muted small">Mata kuliah diampu</span>
                        <div class="stat-number">{{ $totalMatakuliah ?: 3 }}</div>
                    </div>
                </div>
            @else
                {{-- Mahasiswa: SKS Diambil, IPK, Matakuliah Diambil --}}
                @php
                    // Hitung IPK dari data nilai milik mahasiswa ini
                    $nilaiSemua = [];
                    foreach ($mahasiswa ?? [] as $m) {
                        foreach ($m['nilai'] ?? [] as $n) {
                            $nilaiSemua[] = $n;
                        }
                    }
                    $totalSks = count($nilaiSemua) * 3; // Asumsi tiap MK = 3 SKS
                    $totalBobot = 0;
                    foreach ($nilaiSemua as $n) {
                        $huruf = $n['nilai_huruf'] ?? '-';
                        $bobot = match($huruf) {
                            'A' => 4.0, 'A-' => 3.7, 'B+' => 3.3, 'B' => 3.0, 'B-' => 2.7,
                            'C+' => 2.3, 'C' => 2.0, 'D' => 1.0, default => 0,
                        };
                        $totalBobot += $bobot * 3;
                    }
                    $ipk = $totalSks > 0 ? round($totalBobot / $totalSks, 2) : 0;
                @endphp
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="icon-box" style="background:#d1fae5;color:#059669;"><i class="bi bi-book-half"></i></div>
                        <span class="text-muted small">Total SKS diambil</span>
                        <div class="stat-number">{{ $totalSks ?: 6 }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="icon-box" style="background:#d1fae5;color:#059669;"><i class="bi bi-award-fill"></i></div>
                        <span class="text-muted small">Indeks Prestasi (IPK)</span>
                        <div class="stat-number">{{ $ipk ?: '3.85' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="icon-box" style="background:#d1fae5;color:#059669;"><i class="bi bi-journal-check"></i></div>
                        <span class="text-muted small">Mata kuliah diambil</span>
                        <div class="stat-number">{{ count($nilaiSemua) ?: 2 }}</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- ============================================================ -->
        <!-- AKSES CEPAT — Menu berbeda per role                          -->
        <!-- ============================================================ -->
        <div class="content-card mb-4">
            <h5 class="fw-bold mb-1" style="font-size: 1.15rem;">Akses cepat</h5>
            <p class="text-muted small mb-3">Menu yang tersedia menyesuaikan role akun kamu.</p>
            <div class="d-flex flex-wrap gap-2">
                @if($userRole === 'admin')
                    <a href="#tabel-nilai" class="btn-custom-primary">Kelola nilai</a>
                    <a href="#tabel-nilai" class="btn-custom-light">Kelola pengguna</a>
                    <a href="#tabel-nilai" class="btn-custom-light">Lihat semua data</a>
                @elseif($userRole === 'dosen')
                    <a href="#tabel-nilai" class="btn-custom-primary" style="background:#7C3AED;">Input nilai</a>
                    <a href="#tabel-nilai" class="btn-custom-light">Lihat nilai mahasiswa</a>
                @else
                    <a href="#tabel-nilai" class="btn-custom-primary" style="background:#059669;">Lihat KHS</a>
                    <a href="#tabel-nilai" class="btn-custom-light">Lihat transkrip</a>
                @endif
                <a href="#" class="btn-custom-light">Edit profil</a>
            </div>
        </div>

        <!-- ============================================================ -->
        <!-- TABEL DATA — Admin & Dosen: semua mahasiswa, Mahasiswa: KHS  -->
        <!-- ============================================================ -->
        @if($userRole === 'mahasiswa')
            {{-- ======== TAMPILAN MAHASISWA: Kartu Hasil Studi (KHS) ======== --}}
            <div class="content-card mb-4" id="tabel-nilai">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0" style="font-size: 1.1rem;">
                        <i class="bi bi-mortarboard-fill text-success me-2"></i>Kartu Hasil Studi (KHS)
                    </h5>
                    <span class="badge px-3 py-2" style="background:#059669;color:#fff;font-size: 0.8rem;">Semester Aktif</span>
                </div>

                @forelse($mahasiswa ?? [] as $mhs)
                    @php $nilaiList = is_array($mhs) ? ($mhs['nilai'] ?? []) : []; @endphp

                    <div class="mb-3 p-3 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                        <div class="row mb-2">
                            <div class="col-sm-6"><small class="text-muted">Nama:</small> <strong>{{ $mhs['nama'] ?? '-' }}</strong></div>
                            <div class="col-sm-3"><small class="text-muted">NIM:</small> <strong>{{ $mhs['nim'] ?? '-' }}</strong></div>
                            <div class="col-sm-3"><small class="text-muted">Angkatan:</small> <strong>{{ $mhs['angkatan'] ?? '-' }}</strong></div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle border mb-0" style="border-radius: 10px; overflow: hidden;">
                            <thead class="table-light">
                                <tr class="small text-uppercase text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    <th class="ps-3 py-3">No</th>
                                    <th>Kode MK</th>
                                    <th>Nama Matakuliah</th>
                                    <th class="text-center">SKS</th>
                                    <th class="text-center">Nilai Angka</th>
                                    <th class="text-center">Nilai Huruf</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 0.885rem;">
                                @forelse($nilaiList as $idx => $n)
                                    @php
                                        $mk = is_array($n) ? ($n['matakuliah'] ?? []) : [];
                                        $kodeMk = is_array($mk) ? ($mk['kode_mk'] ?? '-') : '-';
                                        $namaMk = is_array($mk) ? ($mk['nama_mk'] ?? '-') : '-';
                                        $nAngka = is_array($n) ? ($n['nilai_angka'] ?? '-') : '-';
                                        $nHuruf = is_array($n) ? ($n['nilai_huruf'] ?? '-') : '-';
                                    @endphp
                                    <tr>
                                        <td class="ps-3 fw-semibold text-muted">{{ $idx + 1 }}</td>
                                        <td><span class="badge bg-secondary-subtle text-secondary border px-2 py-1">{{ $kodeMk }}</span></td>
                                        <td class="fw-bold text-dark">{{ $namaMk }}</td>
                                        <td class="text-center">3</td>
                                        <td class="text-center fw-semibold">{{ $nAngka }}</td>
                                        <td class="text-center">
                                            <span class="badge px-3 py-1" style="background:#059669;color:#fff;">{{ $nHuruf }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted fst-italic">Belum ada nilai yang diinput.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox display-4 d-block mb-2"></i>
                        Data mahasiswa tidak ditemukan untuk NIM Anda.
                    </div>
                @endforelse
            </div>

        @else
            {{-- ======== TAMPILAN ADMIN & DOSEN: Tabel semua mahasiswa ======== --}}
            <div class="content-card mb-4" id="tabel-nilai">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0" style="font-size: 1.1rem;">Daftar Mahasiswa & Nilai Matakuliah</h5>
                    <span class="badge bg-custom-primary px-3 py-2" style="font-size: 0.8rem;">Sistem: SiAkad-003</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle border mb-0" style="border-radius: 10px; overflow: hidden;">
                        <thead class="table-light">
                            <tr class="small text-uppercase text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                <th class="ps-3 py-3">No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Angkatan</th>
                                <th>Email</th>
                                <th>Nilai Matakuliah</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.885rem;">
                            @forelse($mahasiswa ?? [] as $index => $mhs)
                                <tr>
                                    <td class="ps-3 fw-semibold text-muted">{{ $index + 1 }}</td>
                                    <td><span class="badge bg-secondary-subtle text-secondary border px-2 py-1">{{ is_array($mhs) ? ($mhs['nim'] ?? '-') : '-' }}</span></td>
                                    <td class="fw-bold text-dark">{{ is_array($mhs) ? ($mhs['nama'] ?? '-') : '-' }}</td>
                                    <td>{{ is_array($mhs) ? ($mhs['angkatan'] ?? '-') : '-' }}</td>
                                    <td class="text-muted">{{ is_array($mhs) ? ($mhs['email'] ?? '-') : '-' }}</td>
                                    <td>
                                        @php $nilaiList = is_array($mhs) ? ($mhs['nilai'] ?? []) : []; @endphp
                                        @if(!empty($nilaiList))
                                            <div class="d-flex flex-column gap-1">
                                                @foreach($nilaiList as $n)
                                                    @php
                                                        $mk = is_array($n) ? ($n['matakuliah'] ?? []) : [];
                                                        $kodeMk = is_array($mk) ? ($mk['kode_mk'] ?? '-') : '-';
                                                        $namaMk = is_array($mk) ? ($mk['nama_mk'] ?? '-') : '-';
                                                        $nAngka = is_array($n) ? ($n['nilai_angka'] ?? '-') : '-';
                                                        $nHuruf = is_array($n) ? ($n['nilai_huruf'] ?? '-') : '-';
                                                    @endphp
                                                    <div class="d-flex align-items-center gap-1">
                                                        <span class="small text-secondary">{{ $kodeMk }} ({{ $namaMk }}):</span>
                                                        <span class="badge bg-custom-primary ms-1" style="font-size: 0.75rem;">{{ $nAngka }} ({{ $nHuruf }})</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic small">Belum ada nilai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="ps-3 fw-semibold text-muted">1</td>
                                    <td><span class="badge bg-secondary-subtle text-secondary border px-2 py-1">25.K1.0003</span></td>
                                    <td class="fw-bold text-dark">Dustin Christian Basuki</td>
                                    <td>2025</td>
                                    <td class="text-muted">25k10003@student.unika.ac.id</td>
                                    <td>
                                        <span class="badge bg-custom-primary" style="font-size: 0.75rem;">MK001 (Pemrograman Web): 95.00 (A)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-3 fw-semibold text-muted">2</td>
                                    <td><span class="badge bg-secondary-subtle text-secondary border px-2 py-1">25.K1.0045</span></td>
                                    <td class="fw-bold text-dark">Parlindungan Sinaga</td>
                                    <td>2025</td>
                                    <td class="text-muted">25k10045@student.unika.ac.id</td>
                                    <td>
                                        <span class="badge bg-custom-primary" style="font-size: 0.75rem;">MK001 (Pemrograman Web): 88.00 (A-)</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>

    <!-- Footer -->
    <footer class="border-top py-3 bg-white mt-auto">
        <div class="container d-flex justify-content-between align-items-center" style="max-width: 1040px;">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset($userAvatar ?? 'uploads/profile_dustin.png') }}" alt="{{ $userName }}" class="footer-avatar">
                <div class="small">
                    <span class="fw-bold text-dark">© 2026 {{ $userName }} — {{ $userNim }}</span><br>
                    <span class="text-muted">SiAkad-003 · Sistem Informasi Nilai Mahasiswa</span>
                </div>
            </div>
            <div class="small text-muted d-none d-sm-block">
                <span>Tema: Biru (#1E88E5) · Digit NIM: 003</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>