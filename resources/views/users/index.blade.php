<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Profil Anda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container my-4">
        <h2 class="mb-4">Akun Anda</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nama</h5>
                <form method="POST" action="{{ route('user.changename') }}" autocomplete="off">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" flag="text" class="form-control" name="name" onkeydown="return /[a-z' ]/i.test(event.key)" value="{{ Auth::user()->name }}" required>
                        <button type="submit" class="btn btn-primary">Ubah Nama</button>
                    </div>
                </form>
                <hr>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold">Statistik</h5>
                        <hr>
                        <p><strong>Total Event:</strong> {{ $offers }}</p>
                        <p><strong>Event Aktif:</strong> {{ $activeoffers }}</p>
                        <p><strong>Terima Kasih:</strong> {{ $thanks }}</p>
                    </div>
                </div>
                <hr>
                <h5 class="card-title">Foto Profil</h5>
                <small class="text-muted">Gunakan foto 1:1 untuk hasil terbaik, maksimal 2 MB</small>
                <form action="{{ route('user.changeprofilepicture') }}" method="POST" enctype="multipart/form-data" autocomplete="off" class="mt-2">
                    @csrf
                    <input type="file" class="form-control mb-2" name="image" accept=".jpeg, .png, .jpg" required>
                    <div id="imagePreview" class="mt-3"></div>
                    <button type="submit" class="btn btn-primary mt-3">Perbarui Foto Profil</button>
                </form>
                <form action="{{ route('user.deleteprofilepicture') }}" method="POST" class="mt-2" onsubmit="return confirm('Hapus foto profil?');">
                    @csrf
                    <button type="submit" class="btn btn-danger">Hapus Foto Profil</button>
                </form>
                <hr>
                <h5 class="card-title mt-4">Email</h5>
                <form method="POST" action="{{ route('user.newemail') }}" autocomplete="off">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
                        <button type="submit" class="btn btn-primary">Ubah Email</button>
                    </div>
                </form>
                <hr>
                <div class="mt-4">
                    <u id="togglePasswordForm" class="text-primary">Ubah Password</u>
                    <div id="passwordForm" style="display: {{ $errors->updatePassword->isNotEmpty() ? 'block' : 'none' }};">
                        @if ($errors->updatePassword->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->updatePassword->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('password.update') }}" autocomplete="off">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label>Password Lama</label>
                                <input type="password" class="form-control" name="current_password">
                            </div>
                            <div class="mb-3">
                                <label>Password Baru</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="mb-3">
                                <label>Ulangi Password Baru</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                            <button type="submit" class="btn btn-primary">Ubah Password</button>
                        </form>
                    </div>
                </div>
                <hr>
                <h5 class="card-title mt-4">Tipe Pendaftar</h5>
                <form method="POST" action="{{ route('user.changetype') }}" autocomplete="off" onsubmit="return confirm('Ubah tipe pendaftar? Verifikasi tersimpan anda akan dihapus.');">
                    @csrf
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="type" value="individual" {{ Auth::user()->organization == null ? 'checked' : '' }}>
                        <label class="form-check-label">Individu</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="type" value="organization" {{ Auth::user()->organization != null ? 'checked' : '' }}>
                        <label class="form-check-label">Organisasi</label>
                    </div>
                    <input type="text" class="form-control mt-2" name="organization" value="{{ Auth::user()->organization }}" required {{ Auth::user()->organization == null ? 'disabled' : '' }}>
                    <button type="submit" class="btn btn-primary mt-2">Ubah Tipe Pendaftar</button>
                </form>
                <div class="mt-4">
                    @if (Auth::user()->organization)
                        <hr>
                        <p>Verifikasi: 
                        @switch($verification)
                            @case('w')
                                <span class="text-warning fw-bold">Menunggu</span>
                                <form method="POST" action="{{ route('user.cancelverification') }}" autocomplete="off" onsubmit="return confirm('Batalkan permintaan verifikasi?');">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Batalkan Verifikasi</button>
                                </form>
                                @break
                            @case('a')
                                <span class="text-success fw-bold">Terverifikasi</span>
                                @break
                            @case('d')
                                <span class="text-danger fw-bold">Ditolak</span>
                                <div>
                                    <p>Upload Minimal 1 dokumen yang bisa digunakan untuk Verifikasi Organisasi</p>
                                    <p class="text-muted">Setiap dokumen harus berkukuran kurang dari 2MB.</p>
                                    <form method="POST" action="{{ route('user.applyverification') }}" enctype="multipart/form-data" autocomplete="off">
                                        @csrf
                                        <input type="file" name="document[]" class="form-control mb-2" accept=".jpeg, .png, .jpg, .doc, .docx, .odt, .rtf, .pdf" multiple required>
                                        <div class="mt-3">
                                            <ul class="list-group">
                                            </ul>
                                        </div>
                                        <div class="mt-4"> <!-- Added margin-top here -->
                                            <button type="submit" class="btn btn-primary">Ajukan Verifikasi</button>
                                        </div>
                                    </form>
                                    @foreach ($errors->all() as $error)
                                        <li class="text-danger">{{ $error }}</li>
                                    @endforeach
                                </div>
                                @break
                            @default
                                <span class="text-secondary fw-bold">Belum</span>
                                <div>
                                    <p>Upload Minimal 1 dokumen yang bisa digunakan untuk Verifikasi Organisasi</p>
                                    <p class="text-muted">Setiap dokumen harus berkukuran kurang dari 2MB.</p>
                                    <form method="POST" action="{{ route('user.applyverification') }}" enctype="multipart/form-data" autocomplete="off">
                                        @csrf
                                        <input type="file" name="document[]" class="form-control mb-2" accept=".jpeg, .png, .jpg, .doc, .docx, .odt, .rtf, .pdf" multiple required>
                                        <div class="mt-3">
                                            <ul class="list-group">
                                            </ul>
                                        </div>
                                        <div class="mt-4"> <!-- Added margin-top here -->
                                            <button type="submit" class="btn btn-primary">Ajukan Verifikasi</button>
                                        </div>
                                    </form>
                                    @foreach ($errors->all() as $error)
                                        <li class="text-danger">{{ $error }}</li>
                                    @endforeach
                                </div>
                        @endswitch
                    @endif
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-danger btn-block">Logout</button>
        </form>
    </div>
</body>
</html>
<x-commonwebsocket/>
<script>
    const passwordForm = document.getElementById('passwordForm');
    const documentList = document.getElementsByClassName("list-group")[0];
    const imagePreview = document.getElementById("imagePreview");
    const deleteProfilePictureButton = document.querySelector(`form[action="<?php echo route('user.deleteprofilepicture');?>"] button[type="submit"]`);

    function toggleOrganizationInput() {
        const individualRadio = document.querySelector("input[type='radio'][value='individual']");
        const organizationInput = document.querySelector("input[type='text'][name='organization']");
        
        organizationInput.disabled = individualRadio.checked;
    }

    // Event listeners to run the toggle function on radio button change
    document.querySelector("input[type='radio'][value='individual']").addEventListener('change', toggleOrganizationInput);
    document.querySelector("input[type='radio'][value='organization']").addEventListener('change', toggleOrganizationInput);
    document.addEventListener("DOMContentLoaded", function(){
        if(profilepicture == "default.png"){
            deleteProfilePictureButton.disabled = true;}
        else{
            imagePreview.insertAdjacentHTML("beforeend", `<img src="<?php echo asset('images/profiles');?>/` + profilepicture + `" class="img-thumbnail mb-3" alt="Profile Picture" style="width: 150px; height: 150px;">`);
        }
        });

    document.getElementById("togglePasswordForm").addEventListener("click", function(){
        if(passwordForm.style.display == "none"){
            passwordForm.style.display = "block";}
        else{
            passwordForm.style.display = "none";
        }});

    const documentInput = document.querySelector("input[name='document[]']");
        if (documentInput) {
            documentInput.addEventListener("change", function(event) {
                documentList.innerHTML = "";
                Array.from(event.target.files).forEach(file => {
                    documentList.insertAdjacentHTML("beforeend", "<li class='list-group-item'>" + file.name + "</li>");
                });
            });
        }

    document.querySelector("input[name='image']").addEventListener("change", function(event){
        const file = event.target.files[0];
        imagePreview.innerHTML = "";
        if(file && file.type.startsWith("image/")){
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
                    imagePreview.insertAdjacentHTML("beforeend", "<img src='" + canvas.toDataURL() + "' class='img-thumbnail mb-3' alt='Profile Picture' style='width: 150px; height: 150px;'>");
                };};
            reader.readAsDataURL(file);
        }
    });

</script>