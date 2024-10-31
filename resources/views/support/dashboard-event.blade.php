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
                                <h3 class="card-title">Dashboard Event</h3>
                                <p>Halaman ini berisi informasi tentang event Anda yang dapat diedit, serta daftar pengguna yang tertarik dengan event ini.</p>

                                <h5>Informasi Event</h5>
                                <small class="text-muted">Informasi event dapat diubah sebelum tenggat penerimaan sponsor.</small>

                                <ul class="list-unstyled mt-3">
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Nama Event (Wajib)</strong>
                                                <p class="mb-0 text-muted">Nama ini akan tampil sebagai judul postingan event Anda.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Deskripsi Event (Wajib)</strong>
                                                <p class="mb-0 text-muted">Ubah tanggal dan waktu, lokasi, serta deskripsi singkat.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Foto Promosional</strong>
                                                <p class="mb-0 text-muted">Anda dapat menambahkan, menghapus, atau menggeser foto untuk mengubah urutan. Foto pada urutan pertama akan digunakan sebagai thumbnail. Gunakan foto dengan rasio 4:3 untuk hasil terbaik. Setiap foto harus berukuran kurang dari 2MB.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Proposal</strong>
                                                <p class="mb-0 text-muted">Anda bisa menambahkan, mengubah, atau menghapus proposal dari event Anda. Dokumen dapat berupa file word atau pdf, dan harus kurang dari 50MB.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Tenggat Penerimaan Sponsor (Wajib)</strong>
                                                <p class="mb-0 text-muted">Event Anda akan tampil dan Anda masih bisa mengedit event sebelum melewati tenggat penerimaan sponsor.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Tag</strong>
                                                <p class="mb-0 text-muted">Anda dapat menambahkan atau menghapus tag event Anda.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-4">
                                        <div class="d-flex align-items-start">
                                            <i class="bi" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <div>
                                                <strong>Hapus Sponsor</strong>
                                                <p class="mb-0 text-muted">Fitur ini memungkinkan Anda untuk menghapus sponsor dari event Anda jika diperlukan.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                                <h5>Pengguna yang Tertarik</h5>
                                <p>Daftar pengguna yang tertarik dengan event ini. Anda dapat mengakses <a href="{{ route('support', 'halaman-diskusi') }}">halaman diskusi</a> dari sini untuk berinteraksi lebih lanjut dengan mereka.</p>
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