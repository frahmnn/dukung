<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Lengkapi Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <x-style/>
    <x-header/>
    <div class="container my-5">
        <div class="card p-4 shadow">
            <h2 class="card-title text-center mb-4">Lengkapi Profil Anda</h2>
            <form action="<?php echo route('user.postcompleteprofile'); ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <!-- Profile Photo Upload Section -->
                <div class="mb-3">
                    <label for="image" class="form-label">Foto Profil</label>
                    <input type="file" name="image" class="form-control" accept=".jpeg, .png, .jpg">
                    <small class="form-text text-muted">Gunakan foto 1:1 untuk hasil terbaik, maksimal 2 MB.</small>
                </div>
                <div id="imagePreview" class="d-flex flex-nowrap gap-2 overflow-auto mt-3"></div>

                <!-- Registration Type Section -->
                <div class="mt-4">
                    <p class="form-label fw-bold">Saya mendaftar sebagai:</p>
                    <div class="d-flex align-items-center gap-3">
                        <button type="submit" name="individual" class="btn btn-outline-primary">Individu</button>
                        <span>atau</span>
                        <div class="input-group">
                            <input type="text" name="organization" class="form-control" placeholder="Asal Organisasi">
                            <button type="submit" name="organization" class="btn btn-primary">Daftar Sebagai Organisasi</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<x-commonwebsocket/>
<script>
    const form = document.querySelector(`form[action="<?php echo route('user.postcompleteprofile'); ?>"]`);
    const inputOrganization = form.querySelector("input[name='organization']");
    const imagePreview = document.getElementById("imagePreview");

    form.querySelectorAll("button[type='submit']").forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault();
            inputOrganization.required = button.name == "organization";
            inputOrganization.disabled = button.name != "organization";
            if (form.checkValidity()) {
                form.submit();
            } else {
                alert("Masukan asal organisasi");
            }
        });
    });

    document.querySelector("input[type='file']").addEventListener("change", function(event) {
        const file = event.target.files[0];
        imagePreview.innerHTML = "";
        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function() {
                const img = new Image();
                img.src = reader.result;
                img.onload = function() {
                    const size = Math.min(img.width, img.height);
                    const canvas = document.createElement("canvas");
                    canvas.width = size;
                    canvas.height = size;
                    const ctx = canvas.getContext("2d");
                    ctx.drawImage(img, (img.width - size) / 2, (img.height - size) / 2, size, size, 0, 0, size, size);
                    imagePreview.insertAdjacentHTML("beforeend", "<img src='" + canvas.toDataURL() + "' class='rounded' style='max-width: 100px;'>");
                };
            };
            reader.readAsDataURL(file);
        }
    });
</script>