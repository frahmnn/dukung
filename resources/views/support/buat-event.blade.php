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
                                <h3 class="card-title">Buat Event</h3>
                                <p class="text-muted">
                                    <small>Anda hanya dapat mengunggah event setelah <a href="{{ route('support', 'login-daftar') }}">login</a>.</small>
                                </p>
                                <p>
                                    Demi menjaga kualitas layanan Dukung, dihimbau untuk membuat event dengan baik dan bertanggung jawab.
                                </p>
                                <ul class="list-unstyled mt-3">
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-pencil-square text-primary" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Nama Event (Wajib)</strong>
                                                <p class="mb-0 text-muted">Nama ini akan tampil sebagai judul postingan event Anda.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-calendar3 text-primary" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Deskripsi Event (Wajib)</strong>
                                                <p class="mb-0 text-muted">Masukkan tanggal dan waktu, lokasi, serta deskripsi singkat.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-image text-primary" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Foto Promosional</strong>
                                                <p class="mb-0 text-muted">Gunakan foto dengan rasio 4:3 untuk hasil terbaik. Anda dapat menggeser foto untuk mengubah urutan. Foto pada urutan pertama akan digunakan sebagai thumbnail. Setiap foto harus berukuran kurang dari 2MB.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-file-earmark-text text-primary" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Proposal</strong>
                                                <p class="mb-0 text-muted">Anda bisa memilih untuk menyertakan proposal pada event Anda untuk memudahkan diskusi dengan pendukung. Dokumen dapat berupa file word atau pdf, dan harus kurang dari 50MB.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-hourglass-split text-primary" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Tenggat Penerimaan Sponsor (Wajib)</strong>
                                                <p class="mb-0 text-muted">Event Anda akan tampil dan Anda masih bisa <a href="{{ route('support', 'dashboard-event') }}">mengedit event</a> sebelum melewati tenggat penerimaan sponsor.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-tags text-primary" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Tag</strong>
                                                <p class="mb-0 text-muted">Buat event Anda lebih mudah dicari orang dengan menyertakan tag yang sesuai.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
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