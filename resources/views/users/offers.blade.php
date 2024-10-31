<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Event Anda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
</head>
<body>
    <x-style/>
    <x-header/>
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container my-4">
        <h2 class="mb-4">Event Anda</h2>
        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped rounded" id="offersTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal Ditutup</th>
                            <th>Pengguna Tertarik</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($myoffers as $offer) { ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                    <a href="<?php echo route('offer.offer', $offer->id); ?>">
                                        <?php echo $offer->name; ?>
                                    </a>
                                    
                                </td>
                                <td>{{ \Carbon\Carbon::parse($offer->closed_date)->translatedFormat('j F Y') }}</td>
                                <td><?php echo $interestees[$offer->id] ?? "0"; ?></td>
                                <td>
                                    <a href="<?php echo route('offer.dashboard', $offer->id); ?>">
                                        Lihat Detail
                                        <?php if(isset($notifications[$offer->id])){?>
                                            <span class="badge bg-warning ms-2">!</span>
                                        <?php } ?>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <h2 class="mb-4">Event Yang Anda Ikuti</h2>

        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped rounded" id="interestedTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal Ditutup</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($interesteds as $interested) { ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                    <a href="<?php echo route('offer.chat', $interested->offer); ?>">
                                        <?php echo $interested_offers[$interested->offer]->name;
                                        if(isset($notifications[$interested->offer])){?>
                                            <span class="badge bg-warning ms-2">!</span>
                                        <?php } ?>
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($interested_offers[$interested->offer]->closed_date)->translatedFormat('j F Y') }}</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<x-commonwebsocket/>
<script>
    $(document).ready(function() {
        $('#offersTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            language: {
                lengthMenu: "Tampilkan _MENU_ entri",
                zeroRecords: "Tidak ada data yang ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada entri tersedia",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            }
        });

        $('#interestedTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            language: {
                lengthMenu: "Tampilkan _MENU_ entri",
                zeroRecords: "Tidak ada data yang ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada entri tersedia",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });
</script>