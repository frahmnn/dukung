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
                                <h3 class="card-title">Cari Event</h3>
                                <p class="card-text">
                                    <a href="{{ route('index') }}">Halaman utama Dukung</a> menampilkan semua event yang sedang dibuka untuk sponsor atau dukungan, diurutkan dari yang terbaru hingga yang sudah lama diposting. Anda hanya dapat menemukan Event yang sedang aktif.
                                </p>
                                <p class="card-text">
                                    Gunakan fitur <a href="{{ route('search') }}">pencarian</a> untuk memudahkan pencarian event yang sesuai dengan minatmu.
                                </p>

                                <!-- Vertical Oriented Descriptions -->
                                <div class="d-flex flex-column mb-3">
                                    <div class="d-flex align-items-start mb-3">
                                        <i class="bi bi-type text-primary" style="font-size: 2rem; margin-right: 15px;"></i>
                                        <div>
                                            <h5 class="card-title" style="font-weight: bold;">Pencarian Berdasarkan Judul</h5>
                                            <p class="card-text">Masukkan kata kunci tertentu untuk mencari event sesuai nama atau topik event yang kamu cari.</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start mb-3">
                                        <i class="bi bi-tags text-secondary" style="font-size: 2rem; margin-right: 15px;"></i>
                                        <div>
                                            <h5 class="card-title" style="font-weight: bold;">Filter Berdasarkan Tag</h5>
                                            <p class="card-text">Gunakan tag untuk menyeleksi event berdasarkan kategori spesifik seperti pendidikan, olahraga, seni, dan lainnya.</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-clock-history text-info" style="font-size: 2rem; margin-right: 15px;"></i>
                                        <div>
                                            <h5 class="card-title" style="font-weight: bold;">Sortir Berdasarkan Waktu</h5>
                                            <p class="card-text">Atur urutan event berdasarkan waktu posting atau waktu event berlangsung.</p>
                                        </div>
                                    </div>
                                </div>
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