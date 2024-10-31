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
                                <h3 class="card-title">Halaman Diskusi</h3>
                                <p>
                                    Pendukung dan penyelenggara event dapat berdiskusi tentang event di halaman diskusi. Fitur ini merupakan fitur chat yang memungkinkan Anda untuk berdiskusi, seperti berdiskusi tentang pengajuan sponsor pada umumnya, dengan tetap menjaga etika berdiskusi yang baik.
                                </p>

                                <div class="alert alert-info" role="alert">
                                    Dengan adanya fitur diskusi, Dukung juga mendorong semua pihak untuk saling bertukar kontak, membuat janji temu, dan melakukan berbagai hal lainnya yang dapat memperluas koneksi.
                                </div>

                                <h5>Info Rekan Diskusi</h5>
                                <p>
                                    Anda dapat melihat informasi umum dari rekan diskusi Anda, termasuk nama, asal organisasi, status <a href="{{ route('support', 'verifikasi') }}">verifikasi</a>, jumlah event, dan jumlah terima kasih yang diterima.
                                </p>

                                <h5>Akses Proposal</h5>
                                <p>
                                    Penyelenggara event dapat memberikan akses proposal kepada calon pendukung. Ketika akses proposal diberikan, akses tersebut tidak dapat ditutup kembali.
                                </p>

                                <h5>Terima Kasih</h5>
                                <p>
                                    Berikan apresiasi kepada pendukung dengan menambah reputasi pendukung melalui fitur Terima Kasih! Penyelenggara event hanya dapat menggunakan fitur terima kasih satu kali kepada setiap pendukung untuk setiap event.
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