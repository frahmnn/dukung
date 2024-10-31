<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
</head>
<body>
    <x-header/>
    <x-style/>
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container mt-4">
        <h2 class="mb-4">Permohonan Verifikasi</h2>
        <table id="verificationsTable" class="table table-striped table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Pemohon</th>
                    <th>Organisasi</th>
                    <th>Tanggal Diajukan</th>
                    <th>Dokumen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($verifications as $verification) { ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td>
                            <span class="text-decoration-none">
                                <?php echo $users[$verification->applicant]->name; ?>
                                (<?php echo $users[$verification->applicant]->email; ?>)
                            </span>
                        </td>
                        <td><?php echo $users[$verification->applicant]->organization; ?></td>
                        <td><?php echo $verification->created_at->format('d/m/Y'); ?></td>
                        <td>
                            <?php foreach($filenames[$verification->id] as $filename) { ?>
                                <a href="<?php echo route('admin.verifications.accessfile', ['userid' => $verification->applicant, 'filename' => $filename]); ?>" class="text-decoration-none"><?php echo $filename; ?></a><br>
                            <?php } ?>
                        </td>
                        <td>
                            <form method="POST" action="<?php echo route('admin.verifyverification', ['verification' => $verification->id, 'action' => 'a']); ?>" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Terima</button>
                            </form>
                            <form method="POST" action="<?php echo route('admin.verifyverification', ['verification' => $verification->id, 'action' => 'd']); ?>" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<script>
    $(document).ready(function() {
        $('#verificationsTable').DataTable({
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
            },
            columnDefs: [
                {
                    targets: [4, 5], // Adjust based on your needs
                    searchable: false
                }
            ]
        });
    });
</script>
