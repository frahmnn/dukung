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
                            <h3 class="card-title">Verifikasi</h3>
                            <p>
                                Verifikasi adalah inisiatif dari Dukung untuk menjaga kualitas layanan dan memberikan kepercayaan kepada pengguna lain. Pengguna yang terverifikasi telah melalui proses pengecekan untuk memastikan keaslian identitas organisasi mereka. Verifikasi membantu meningkatkan reputasi baik penyelenggara event maupun pendukung.
                            </p>
                            
                            <p>
                                Pengguna yang telah terverifikasi akan memiliki <i class="fas fa-check-circle text-success ms-1" title="Verified"></i> pada profil mereka.
                            </p>
                            
                            <p>
                                Hanya akun yang didaftarkan sebagai organisasi yang dapat mengajukan verifikasi. Proses verifikasi dapat dilakukan melalui halaman <a href="{{ route('support', 'informasi-akun') }}">Informasi Akun</a>.
                            </p>

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