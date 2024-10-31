<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Kolaborasi Cerdas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
    <div class="container my-4">
        <div class="card border-0" style="background-color: #007bff; color: white; padding: 2rem; margin-bottom: 1.5rem; text-align: center;">
            <h2 class="card-title mb-3">Selamat datang di <em>Dukung</em>!</h2>
            <p class="card-text fs-5">Coba mulai pakai <strong>Dukung</strong>, platform yang siap jadi penghubung Anda dengan sponsor atau peluang kolaborasi, untuk mendukung ide dan kegiatan Anda!</p>
        </div>
        
        <form action="{{ route('search') }}" method="GET" autocomplete="off" class="my-4">
            <div class="input-group">
                <input type="text" name="query" class="form-control form-control-lg" id="search-input" aria-label="Cari Event">
                <button class="btn btn-primary btn-lg" type="submit">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>

        @if($offers->isEmpty())
            <div class="alert alert-info text-center d-flex flex-column align-items-center p-5">
                <div class="fs-4 mb-3">
                    <i class="bi bi-emoji-frown"></i> Belum ada event yang tersedia
                </div>
                <p class="lead">Mari buat satu dan mulai berkolaborasi!</p>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                @foreach($offers as $offer)
                    <?php
                        $thumbnail = glob(public_path("images/posts/" . $offer->id . "/0.*"));
                        $thumbnail = empty($thumbnail) ? "default.png" : $offer->id . "/" . basename($thumbnail[0]);
                    ?>
                    <div class="col d-flex">
                        <div class="card h-100 flex-fill">
                            <a href="{{ route('offer.offer', $offer->id) }}" class="text-decoration-none text-dark d-flex flex-column h-100">
                                <div class="ratio ratio-4x3" style="overflow: hidden;">
                                    <img src="{{ asset('images/posts/' . $thumbnail) }}" class="card-img-top" alt="{{ $offer->name }}" style="object-fit: cover;">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $offer->name }}</h5>
                                    <div>
                                        @if(isset(Auth::user()->id) && $offer->applicant == Auth::user()->id)
                                            <span class="badge bg-info text-dark">Event Anda</span>
                                        @endif
                                        @if(isset($interesteds[$offer->id]))
                                            <span class="badge bg-warning text-dark">Tertarik</span>
                                        @endif
                                        @if(isset($tags[$offer->id]))
                                            @php $tagCount = 0; @endphp
                                            @foreach($tags[$offer->id] as $tag)
                                                @if($tagCount < 2)
                                                    <span class="badge bg-secondary">{{ $tag['tag'] }}</span>
                                                @endif
                                                @php $tagCount++; @endphp
                                            @endforeach
                                            @if($tagCount > 2)
                                                <button type="button" class="btn btn-link" data-bs-toggle="popover" data-bs-html="true" data-bs-trigger="hover" data-bs-content="
                                                    @foreach($tags[$offer->id] as $tag)
                                                        <span class='badge bg-secondary'>{{ $tag['tag'] }}</span>
                                                    @endforeach
                                                ">+{{ $tagCount - 2 }}</button>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="mt-3 mt-auto">
                                        <small class="text-muted me-2">Diajukan pada: {{ $offer->created_at->format('d M Y') }}</small>
                                        <small class="text-muted">Menerima hingga: {{ \Carbon\Carbon::parse($offer->closed_date)->format('d M Y') }}</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function (){
        const popoverTriggerList = document.querySelectorAll("[data-bs-toggle='popover']");
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl, {
            trigger: "hover"
        }));
    });
    const placeholders = [
        "Seminar Lingkungan", 
        "Workshop Seni", 
        "Kompetisi Olahraga", 
        "Pameran Teknologi", 
        "Bazaar Amal", 
        "Networking Sosial"];
    document.getElementById("search-input").placeholder = placeholders[Math.floor(Math.random() * placeholders.length)];
</script>
<?php if(!Auth::guest()){?>
    <x-commonwebsocket/><?php
}?>