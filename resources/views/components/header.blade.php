<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<?php use App\Models\Verification;
use App\Models\Notification;?>
<div class="container-fluid sticky-top bg-primary py-2 shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand text-white d-flex align-items-center" href="{{ route('index') }}" style="padding: 0;">
                <img src="{{ asset('images/logowhite.png') }}" alt="Dukung Logo" style="height: 40px; width: auto; padding: 0; margin: 0;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                        </li>
                    @else
                        <?php
                            $verified = Verification::where("applicant", Auth::user()->id)->where("status", "a")->exists();
                            $profilepicture = glob(public_path("images/profiles") . "/" . Auth::user()->id . ".*");
                            $profilepicture = empty($profilepicture) ? "default.png" : htmlspecialchars(basename($profilepicture[0]));
                        ?>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center text-white" href="{{ route('user.index') }}">
                                <img src="{{ asset('images/profiles/' . $profilepicture) }}" alt="Profile Picture" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                <span class="align-middle">{{ Auth::user()->name }}</span>
                                @if($verified)
                                    <i class="fas fa-check-circle text-success ms-1" title="Verified"></i>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="myevent" href="{{ route('user.offers') }}">
                                Event Saya
                                <?php
                                    if(Notification::where("user", Auth::user()->id)->exists()){?>
                                        <span class="badge bg-warning">!</span>
                                        <script>var notification = true;</script>
                                    <?php }else{?>
                                        <script>var notification = false;</script><?php
                                    }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('offer.create') }}">Buat Event</a>
                        </li>
                        @if(Auth::user()->role == "a")
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('admin.index') }}">Menu Admin</a>
                            </li>
                        @endif
                        <script>
                            const profilepicture = <?php echo json_encode($profilepicture); ?>;
                        </script>
                    @endguest
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('support', 'welcome') }}">Bantuan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>