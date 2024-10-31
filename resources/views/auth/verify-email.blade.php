<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Verifikasi Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <x-style/>
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="card shadow-lg" style="max-width: 400px; width: 100%;">
            <div class="card-body text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Dukung Logo" style="height: 60px; width: auto; margin-bottom: 20px;">
                <h3 class="mb-4">Verifikasi Email</h3>
                <p>Silakan cek email <span class="text-primary">{{ Auth::user()->email }}</span> dan ikuti petunjuk dari pesan yang masuk.</p>
                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success" role="alert">
                        Email verifikasi terkirim
                    </div>
                @endif
                <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                    @csrf
                    <x-primary-button class="btn btn-primary w-100">
                        Kirim ulang pesan
                    </x-primary-button>
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary w-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>