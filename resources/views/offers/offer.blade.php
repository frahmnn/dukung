<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - <?php echo $offer->name;?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            border: 2px solid black;
        }
    </style>
</head>
<body>
    <x-style/>
    <x-header/>
    <div class="container my-4">
        <div class="row">
            <!-- Left Side -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <div id="imageCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @if(empty($images))
                                    <div class="carousel-item active">
                                        <img src="{{ asset('images/posts/default.png') }}" class="d-block w-100" alt="Default Image" style="object-fit: cover; aspect-ratio: 4 / 3;">
                                    </div>
                                @else
                                    @foreach($images as $index => $image)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('images/posts/' . $offer->id . '/' . basename($image)) }}" class="d-block w-100" alt="Offer Image {{ $index + 1 }}" style="object-fit: cover; aspect-ratio: 4 / 3;">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                        <h3>{{ $offer->name }}</h3>
                        <div class="tags mb-3">
                            @foreach ($tags as $tag)
                                <span class="badge bg-secondary">{{ $tag->tag }}</span>
                            @endforeach
                        </div>
                        <h6>
                            <img src="{{ asset('images/profiles/' . $to_profilepicture) }}" alt="Profile Picture" class="rounded-circle me-1 border border-dark" style="width: 40px; height: 40px;">
                            Oleh: {{ $applicant->name }} 
                            @if($verified)
                                <i class="fas fa-check-circle text-success ms-1" title="Verified"></i>
                            @endif
                        </h6>

                        <small class="text-muted">{{ $applicant->organization == null ? 'Individu' : $applicant->organization }}</small>
                        <h6 class="mt-2">Menerima sponsor sampai: {{ \Carbon\Carbon::parse($offer->closed_date)->translatedFormat('j F Y') }}</h6>
                    </div>
                </div>
            </div>

            <!-- Right Side -->
            <div class="col-md-6 d-flex flex-column">
                <div class="card flex-fill mb-4">
                    <div class="card-body">
                        <div class="overflow-auto" style="max-height: calc(100vh - 150px); flex: 1; background-color: #f8f9fa; border-radius: 0.5rem; padding: 1rem;">
                            <h5 class="mt-4">Deskripsi</h5>
                            <p>{!! nl2br(e($offer->description)) !!}</p>
                        </div>
                    </div>

                    <div class="card-footer">
                        @if(Auth::guest())
                            <p>Silakan <a href="{{ route('login') }}">login</a> dahulu</p>
                        @else
                            @if(Auth::user()->id == $offer->applicant)
                                <a href="{{ route('offer.dashboard', $offer->id) }}" class="btn btn-primary">Lompat ke Dashboard</a>
                            @else
                                @if($interested)
                                    <a href="{{ route('offer.chat', $offer->id) }}" class="btn btn-success">Lanjutkan Diskusi</a>
                                @else
                                    <form method="POST" action="{{ route('offer.interested', $offer->id) }}" enctype="multipart/form-data" autocomplete="off">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Saya Tertarik</button>
                                    </form>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php if(!Auth::guest()){?>
    <x-commonwebsocket/><?php
}?>