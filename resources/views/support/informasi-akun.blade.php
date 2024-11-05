<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Bantuan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <x-style/>
    <x-header/>
    <div class="container-fluid">
        <div class="row">
            <x-support-sidebar :page="$page" />
            <div class="col-md-9">
                <div class="canvas" style="overflow-y: auto; height: calc(100vh - 100px);">
                    <div class="container my-4">
                        <div class="card shadow-sm p-4">
                            <div class="card-body">
                                <h3 class="card-title">Informasi Akun</h3>
                                <p>Halaman ini memuat informasi akun Anda yang dapat diedit: nama, foto profil, email, dan password. Anda harus terlebih dahulu memverifikasi email baru sebelum menyelesaikan penggantian email.</p>
                                <small class="text-muted" style="margin-top: -15px; margin-bottom: 15px; display: block;">Pesan mungkin diterima sebagai spam.</small>

                                <h5>Statistik</h5>
                                <p>Statistik ini juga dapat dilihat oleh rekan diskusi Anda di <a href="{{ route('support', 'halaman-diskusi') }}">halaman diskusi</a>.</p>

                                <ul class="list-unstyled mt-3">
                                    <li class="mb-1">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-person-circle text-primary" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                Total Event yang Anda Buat
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-1">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-calendar3 text-primary" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                Total Event Aktif
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-1">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-heart text-primary" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                Total Terima Kasih dari Penyelenggara Event
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                                <h5>Tipe Pendaftar dan Verifikasi</h5>
                                <p>Anda dapat mengubah tipe akun menjadi Individu atau Organisasi, serta mengajukan <a href="{{ route('support', 'verifikasi') }}">verifikasi</a> untuk akun organisasi. Perubahan tipe pendaftar akan menghapus verifikasi yang ada, namun Anda dapat mengajukan verifikasi ulang setelahnya.</p>

                                <h5>Logout</h5>
                                <p>Gunakan tombol logout untuk keluar dari akun Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php if(!Auth::guest()){?>
    <x-commonwebsocket/><?php
}?>