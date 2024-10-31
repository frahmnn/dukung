<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>
<body>
    <x-header/>
    <x-style/>
    <div class="container my-4">
        <div class="list-group">
            <a href="<?php echo route('admin.users');?>" class="list-group-item list-group-item-action">
                <i class="bi bi-person-circle me-2"></i> Manajemen User
            </a>
            <a href="<?php echo route('admin.verifications');?>" class="list-group-item list-group-item-action">
                <i class="bi bi-check-circle me-2"></i> Permintaan Verifikasi
            </a>
        </div>
    </div>
</body>
</html>