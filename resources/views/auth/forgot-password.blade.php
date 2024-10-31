<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Lupa Password</title>
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
                    <h3>Lupa Password</h3>
                </div>
                <p class="text-center text-muted">Silakan masukkan email yang terdaftar di akun Dukung Anda. Pesan mungkin diterima sebagai Spam.</p>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('password.email') }}" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Kirim Permintaan Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
