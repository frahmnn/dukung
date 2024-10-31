<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Bantuan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
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
</head>
<body>
    <x-style/>
    <x-header/>
    <div class="container-fluid">
        <div class="row">
            <x-support-sidebar :page="$page" />
            <div class="col-md-9">
                <div class="canvas" style="overflow-y: auto; height: calc(100vh - 100px);"> <!-- Adjust height based on header -->
                    <div class="container my-4">
                        <div class="card shadow-sm p-4">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('images/logo.png') }}" alt="Dukung Logo" class="mb-3" style="height: 60px; width: auto;">
                                    <h3 class="card-title">Selamat Datang!</h3>
                                    <p class="card-text">
                                        Dukung adalah platform online yang menjembatani para penyelenggara acara/event dengan Kolaborator/Pemberi sponsor. Di Dukung, kamu bisa mengunggah dan membagikan eventmu untuk menarik dukungan atau mencari event-event menarik sesuai dengan ketertarikanmu.
                                    </p>
                                    <p class="card-text">
                                        Secara umum, interaksi di Dukung melibatkan Pihak Penyelenggara Event dan Pemberi Sponsor, baik individu maupun perwakilan dari organisasi.
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-primary text-center h-100 shadow-sm" style="background-color: #f8f9fa; border-radius: 12px;">
                                            <div class="card-body d-flex flex-column">
                                                <div class="mb-3 flex-grow-1">
                                                    <div class="d-flex justify-content-center align-items-center mb-3">
                                                        <i class="bi bi-megaphone text-primary" style="font-size: 1.8rem;"></i>
                                                        <h5 class="card-title ms-3 mb-0" style="font-weight: bold;">Saya Hendak Membagikan Event Saya</h5>
                                                    </div>
                                                    <p class="card-text">Ingin menarik dukungan untuk event Anda? Bagikan event Anda dengan mudah dan jangkau kolaborator yang tepat!</p>
                                                </div>
                                                <a href="{{ route('support', 'buat-event') }}" class="btn btn-primary px-4 py-2" style="border-radius: 25px; transition: background-color 0.3s;">
                                                    Unggah Event Saya
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-success text-center h-100 shadow-sm" style="background-color: #f8f9fa; border-radius: 12px;">
                                            <div class="card-body d-flex flex-column">
                                                <div class="mb-3 flex-grow-1">
                                                    <div class="d-flex justify-content-center align-items-center mb-3">
                                                        <i class="bi bi-search text-success" style="font-size: 1.8rem;"></i>
                                                        <h5 class="card-title ms-3 mb-0" style="font-weight: bold;">Saya Hendak Mencari Event untuk Didukung</h5>
                                                    </div>
                                                    <p class="card-text">Cari dan dukung event yang sesuai dengan minat Anda! Temukan peluang untuk berkolaborasi.</p>
                                                </div>
                                                <a href="{{ route('support', 'cari-event') }}" class="btn btn-success px-4 py-2" style="border-radius: 25px; transition: background-color 0.3s;">
                                                    Cari Event
                                                </a>
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
    </div>
</body>
</html>
<?php if(!Auth::guest()){?>
    <x-commonwebsocket/><?php
}?>