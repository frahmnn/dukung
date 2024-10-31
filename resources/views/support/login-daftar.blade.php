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
                                <h3 class="card-title">Login dan Daftar</h3>
                                
                                <h5 style="margin-top: 1.5rem;">Login</h5>
                                <p>Login dengan akun yang telah terdaftar.</p>

                                <h5>Daftar Akun</h5>
                                <p>Anda dapat mendaftar akun dengan satu email aktif.</p>

                                <h5>Verifikasi Email</h5>
                                <p>Saat pertama kali login, Anda akan diminta untuk melakukan verifikasi email yang digunakan untuk mendaftar.</p>
                                <small class="text-muted" style="margin-top: -15px; margin-bottom: 15px; display: block;">Pesan mungkin diterima sebagai spam.</small>

                                <h5>Lengkapi Profil</h5>
                                <p>Setelah verifikasi email, Anda akan diminta untuk melengkapi profil Anda.</p>
                                
                                <ul class="list-unstyled mt-3">
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Foto Profil</strong>
                                                <p class="mb-0 text-muted">Gunakan foto dengan rasio 1:1 untuk hasil terbaik, maksimal 2 MB.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Tipe Pendaftar</strong>
                                                <p class="mb-0 text-muted">Anda dapat memilih bergabung sebagai Individual atau dari organisasi. Pendaftar dari organisasi dapat melakukan <a href="{{ route('support', 'verifikasi') }}">verifikasi</a> opsional.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                                <h5>Lupa Password</h5>
                                <p>Jika Anda lupa password akun Anda, Anda dapat meminta penggantian password melalui email akun terdaftar Anda.</p>
                                <small class="text-muted" style="margin-top: -15px; margin-bottom: 15px; display: block;">Pesan mungkin diterima sebagai spam.</small>
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