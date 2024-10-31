<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <x-style/>
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="card shadow-lg" style="max-width: 400px; width: 100%;">
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Dukung Logo" style="height: 60px; width: auto; margin-bottom: 20px;">
                    <h3>Daftar Akun</h3>
                </div>
                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <x-text-input id="password" class="form-control" type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" />
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" />
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none">Sudah punya akun?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>