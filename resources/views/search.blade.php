<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Cari Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
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
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-4" style="top: 0; max-height: 100vh;">
                <div style="height: 20px;"></div> <!-- Spacer for vertical distance -->
                <div class="card">
                    <div class="card-body">
                        <!-- Search Form -->
                        <form action="{{ route('search') }}" method="GET" autocomplete="off">
                            <div class="input-group mb-3">
                                <input type="text" name="query" class="form-control form-control-lg" id="search-input" aria-label="Cari Event" value="{{ $query }}" placeholder="Cari event...">
                                <button class="btn btn-primary btn-lg" type="submit">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                            <!-- Filter Section -->
                            <h5 class="mb-3">Filter berdasarkan tag</h5>
                            <div class="row">
                                <div class="col-6">
                                    @foreach (['Seminar/Webinar', 'Workshop', 'Kompetisi', 'Pameran', 'Bazaar', 'Networking', 'Teknologi', 'Finansial'] as $index => $tag)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tag_{{ $index + 1 }}" id="tag_{{ $index + 1 }}" 
                                                value="{{ $tag }}" {{ isset($filter[$tag]) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tag_{{ $index + 1 }}">{{ $tag }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-6">
                                    @foreach (['Seni & Budaya', 'Olahraga & Kesehatan', 'Amal', 'Kuliner', 'Bahasa', 'Pendidikan', 'Keagamaan', 'Sosial', 'Lingkungan'] as $index => $tag)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tag_{{ $index + 9 }}" id="tag_{{ $index + 9 }}" 
                                                value="{{ $tag }}" {{ isset($filter[$tag]) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tag_{{ $index + 9 }}">{{ $tag }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Sort Section -->
                            <h5 class="mb-3">Urutkan berdasarkan</h5>
                            @foreach (['created_at_desc' => 'Waktu dibuat: Terbaru', 'created_at_asc' => 'Waktu dibuat: Tertua', 'closed_date_asc' => 'Waktu penerimaan: Terdekat', 'closed_date_desc' => 'Waktu penerimaan: Terlama'] as $value => $label)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sort" value="{{ $value }}" id="{{ $value }}" {{ $sort == $value ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $value }}">{{ $label }}</label>
                                </div>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-8">
                <div class="canvas" style="overflow-y: auto; height: calc(100vh - 100px);"> <!-- Adjust height based on header -->
                    <div class="container my-4">
                        @if ($query != "" || !empty($filter))
                            @if ($offers->count() > 1)
                                <div class="alert alert-info" role="alert">
                                    {{ $offers->count() }} hasil ditemukan
                                </div>
                            @elseif ($offers->count() === 1)
                                <div class="alert alert-secondary" role="alert">
                                    1 hasil ditemukan
                                </div>
                            @else
                                <div class="alert alert-warning" role="alert">
                                    Tidak ada hasil ditemukan
                                </div>
                            @endif
                        @endif

                        <!-- Offers Section -->
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
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
                    </div>
                </div>
            </div>
        </div>
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