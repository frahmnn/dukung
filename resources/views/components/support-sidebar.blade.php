    <style>
        .list-group-item.active {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            border-color: #007bff;
        }
        .list-group-item.active a {
            color: #fff;
        }
        .list-group-item a:hover {
            text-decoration: underline;
        }
    </style>
@props(['page'])
<div class="col-md-3" style="top: 0; max-height: 100vh; overflow-y: auto;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">Bantuan</h5>
            <h6 class="text-uppercase text-secondary">Umum</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item {{ $page == 'welcome' ? 'active' : '' }}">
                    <a href="{{ route('support', 'welcome') }}" class="text-decoration-none d-block w-100">Mulai</a>
                </li>
                <li class="list-group-item {{ $page == 'login-daftar' ? 'active' : '' }}">
                    <a href="{{ route('support', 'login-daftar') }}" class="text-decoration-none d-block w-100">Login & Daftar</a>
                <li class="list-group-item {{ $page == 'event-saya' ? 'active' : '' }}">
                    <a href="{{ route('support', 'event-saya') }}" class="text-decoration-none d-block w-100">Event Saya</a>
                <li class="list-group-item {{ $page == 'informasi-akun' ? 'active' : '' }}">
                    <a href="{{ route('support', 'informasi-akun') }}" class="text-decoration-none d-block w-100">Informasi Akun</a>
                </li>
            </ul>

            <!-- Event Creation Section -->
            <h6 class="text-uppercase text-secondary">Membuat Event</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item {{ $page == 'buat-event' ? 'active' : '' }}">
                    <a href="{{ route('support', 'buat-event') }}" class="text-decoration-none d-block w-100">Buat Event</a>
                </li>
                <li class="list-group-item {{ $page == 'dashboard-event' ? 'active' : '' }}">
                    <a href="{{ route('support', 'dashboard-event') }}" class="text-decoration-none d-block w-100">Dashboard Event</a>
                </li>
            </ul>

            <!-- Event Search and Selection Section -->
            <h6 class="text-uppercase text-secondary">Mencari & Memilih Event</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item {{ $page == 'cari-event' ? 'active' : '' }}">
                    <a href="{{ route('support', 'cari-event') }}" class="text-decoration-none d-block w-100">Cari Event</a>
                </li>
                <li class="list-group-item {{ $page == 'halaman-event' ? 'active' : '' }}">
                    <a href="{{ route('support', 'halaman-event') }}" class="text-decoration-none d-block w-100">Halaman Event</a>
                </li>
            </ul>

            <!-- Features Section -->
            <h6 class="text-uppercase text-secondary">Fitur Fitur</h6>
            <ul class="list-group">
                <li class="list-group-item {{ $page == 'halaman-diskusi' ? 'active' : '' }}">
                    <a href="{{ route('support', 'halaman-diskusi') }}" class="text-decoration-none d-block w-100">Halaman Diskusi</a>
                </li>
                <li class="list-group-item {{ $page == 'verifikasi' ? 'active' : '' }}">
                    <a href="{{ route('support', 'verifikasi') }}" class="text-decoration-none d-block w-100">Verifikasi</a>
                </li>
            </ul>
        </div>
    </div>
</div>