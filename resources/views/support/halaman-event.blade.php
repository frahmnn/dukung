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
                                <h3 class="card-title">Halaman Event</h3>
                                <p>
                                    Anda dapat melihat foto-foto promosi, tag terkait, dan deskripsi yang diberikan oleh penyelenggara event, serta nama dan asal organisasi dari penyelenggara. Jika Anda tertarik dan hendak mendukung sebuah event, Anda dapat menekan tombol <strong>Saya Tertarik</strong>. Selanjutnya, Anda akan bisa mengakses <a href="{{ route('support', 'halaman-diskusi') }}">halaman diskusi</a> dengan penyelenggara event. 
                                </p>
                                <p>
                                    Jika Anda adalah penyelenggara event ini, Anda bisa menuju <a href="{{ route('support', 'dashboard-event') }}">dashboard event</a> melalui halaman ini.
                                </p>
                                <p class="text-muted">
                                    <small>Anda hanya bisa berinteraksi dengan event setelah <a href="{{ route('support', 'login-daftar') }}">login</a>.</small>
                                </p>
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