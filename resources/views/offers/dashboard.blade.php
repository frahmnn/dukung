<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Detail ({{ $offer->name }})</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
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
        <div class="row"><?php
            $defaultorder = "";
            if (date('Y-m-d', strtotime($offer->closed_date)) < date('Y-m-d')) {?>
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="card-title fw-bold mb-4">{{ $offer->name }}</h5>
                            <div id="imagePreviews" class="d-grid gap-3" style="grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); overflow-auto;">
                                @foreach($images as $image)
                                    <div class="position-relative">
                                        <img src="{{ asset('images/posts/' . $offer->id . '/' . $image) }}" class="img-thumbnail" style="width: 100%; height: auto; aspect-ratio: 4 / 3; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            <h5 class="card-title fw-bold mt-3">Deskripsi</h5>
                            <p class="card-text">{{ $offer->description }}</p>
                            <h5 class="card-title fw-bold mt-3">Menerima Sponsor Sampai</h5>
                            <p class="card-text">{{ \Carbon\Carbon::parse($offer->closed_date)->format('d M Y') }}</p>
                            <h5 class="card-title fw-bold mt-3">Tag</h5>
                            <div>
                                @foreach(['Amal', 'Olahraga & Kesehatan', 'Workshop', 'Teknologi', 'Kuliner', 'Sosial', 'Lingkungan', 'Bahasa', 'Seni & Budaya', 'Pameran', 'Finansial', 'Pendidikan', 'Kompetisi', 'Bazaar', 'Keagamaan', 'Networking', 'Seminar/Webinar'] as $tag)
                                    <span class="badge bg-light text-dark border mb-1">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Proposal</h5>
                            @if($proposal)
                                <p class="card-text">Proposal sekarang: <a href="{{ route('offer.previewproposal', $offer->id) }}">{{ $proposal }}</a></p>
                            @else
                                <p class="card-text">Tidak ada proposal</p>
                            @endif
                            <form method="POST" action="{{ route('offer.delete', $offer->id) }}" class="mt-3" onsubmit="return confirm('Hapus Event?');">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">Hapus Event</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php }
            else{?>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
                <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form method="POST" action="{{ route('offer.edit', $offer->id) }}" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label mb-1 fw-bold">Nama Event*</label>
                                    <p class="small text-muted mb-1">Nama ini akan tampil sebagai judul postingan event anda</p>
                                    <input name="name" flag="text" class="form-control" type="text" required value="{{ $offer->name }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Deskripsi Event*</label>
                                    <textarea name="description" class="form-control" required style="width: 100%; min-height: 200px; resize: vertical;">{{ $offer->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label mb-1 fw-bold">Tambahan Foto Promosional</label>
                                    <p class="small text-muted mb-1">Gunakan foto 4:3 untuk hasil terbaik. Foto pada urutan pertama akan digunakan sebagai Thumbnail. Setiap Foto harus berukuran kurang dari 2MB. Klik dua kali untuk menghapus Foto</p>
                                    <input type="file" flag="text" name="image[]" class="form-control" accept=".jpeg, .png, .jpg" multiple>
                                    <div id="imagePreviews" class="d-grid mt-3 gap-3" style="grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); overflow-auto;">
                                        @foreach($images as $image)
                                            <div class="position-relative">
                                                <img src="{{ asset('images/posts/' . $offer->id . '/' . $image) }}" class="img-thumbnail" style="width: 100%; height: auto; aspect-ratio: 4 / 3; object-fit: cover;" oldorder="{{ $image }}">
                                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" ondblclick="deleteOldImage()" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                            <?php $defaultorder.='{"status":"old","name":"' . $image . '"},'; ?>
                                        @endforeach
                                    </div>
                                    <?php $defaultorder = '[' . rtrim($defaultorder, ",") . ']';?>
                                    <input type="hidden" class="text" name="order" value='<?php echo $defaultorder;?>'>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Menerima sponsor sampai*</label>
                                    <input name="closed_date" flag="text" class="form-control" type="date" value="{{ $offer->closed_date }}" min="{{ date('Y-m-d') }}" required>
                                    <small class="form-text">Anda dapat mengedit iklan sampai waktu penerimaan sponsor selesai.</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tag</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach(['Seminar/Webinar', 'Workshop', 'Kompetisi', 'Pameran', 'Bazaar', 'Networking', 'Teknologi', 'Finansial', 'Seni & Budaya', 'Olahraga & Kesehatan', 'Amal', 'Pendidikan', 'Kuliner', 'Bahasa', 'Keagamaan', 'Sosial', 'Lingkungan'] as $index => $tag)
                                            <div class="form-check">
                                                <input type="checkbox" name="tag_{{ $index + 1 }}" class="form-check-input" value="{{ $tag }}" {{ isset($tags[$tag]) ? 'checked' : '' }} id="tag_{{ $index + 1 }}">
                                                <label class="form-check-label badge rounded-pill bg-light text-dark border" for="tag_{{ $index + 1 }}">{{ $tag }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Ubah</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form method="POST" action="{{ route('offer.editproposal', $offer->id) }}" enctype="multipart/form-data" autocomplete="off" onsubmit="return confirm('Lakukan perubahan pada proposal?');">
                                @csrf
                                <h5>Proposal</h5>
                                @if($proposal)
                                    <p>Proposal sekarang: <a href="{{ route('offer.previewproposal', $offer->id) }}">{{ $proposal }}</a></p>
                                    <button type="submit" name="remove" class="btn btn-danger">Hapus proposal lama</button>
                                    <div class="mt-2">
                                        <label class="form-label">Ganti dengan:</label>
                                        <input type="file" name="proposal" class="form-control" accept=".doc, .docx, .odt, .rtf, .pdf">
                                    </div>
                                    <button type="submit" name="change" class="btn btn-warning mt-2" disabled>Ganti proposal</button>
                                @else
                                    <p>Tidak ada proposal</p>
                                    <input type="file" name="proposal" class="form-control" accept=".doc, .docx, .odt, .rtf, .pdf" required>
                                    <button type="submit" class="btn btn-success mt-2">Tambah proposal</button>
                                @endif
                            </form>
                            <form method="POST" action="{{ route('offer.delete', $offer->id) }}" class="mt-3" onsubmit="return confirm('Hapus foto profil?');">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">Hapus penawaran</button>
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    const order = document.querySelector("input[name='order']");
                    const defaultOrder = '<?php echo addslashes($defaultorder);?>';
                    const form = document.querySelector(`form[action="<?php echo route('offer.edit', $offer->id);?>"]`);
                    const submitButton = form.querySelector("button[type='submit']");
                    const removeButton = document.querySelector("button[name='remove']");
                    const changeButton = document.querySelector("button[name='change']");
                    function stateOrder(){
                        var Order = -1;
                        var ORDER = [];
                        imagePreviews.querySelectorAll("img[name], img[oldorder]").forEach(img => {
                            ORDER[++Order]={};
                            if(img.hasAttribute("oldorder")){
                                ORDER[Order]["status"] = "old";
                                ORDER[Order]["name"] = img.getAttribute("oldorder");}
                            else{
                                ORDER[Order]["status"] = "new";
                                ORDER[Order]["name"] = img.getAttribute("name");
                            }});
                        order.value = JSON.stringify(ORDER);}
                    function deleteOldImage(){
                        event.target.closest("div").remove();
                        stateOrder();}
                    new Sortable(imagePreviews, {
                        animation: 150,
                        chosenClass: "chosen",
                        dragClass: "dragging",
                        onEnd: stateOrder});
                    document.querySelector("input[name='image[]']").addEventListener("change", function(){
                        imagePreviews.querySelectorAll("img[name]").forEach(img => {
                            img.remove();});
                        const files = Array.from(event.target.files);
                        let imagesLoaded = 0;
                        files.forEach(file => {
                            if(file && file.type.startsWith("image/")){
                                const reader = new FileReader();
                                reader.onload = function(){
                                    imagePreviews.insertAdjacentHTML("beforeend", "<img src='" + event.target.result + "' name='" + file.name + "' class='img-thumbnail' style='width: 100%; height: auto; aspect-ratio: 4 / 3; object-fit: cover;'>");
                                    if(++imagesLoaded == files.length){
                                        stateOrder();}};
                                reader.readAsDataURL(file);
                            }
                        });});
                    form.addEventListener("submit", function(){
                        event.preventDefault();
                        stateOrder();
                        this.submit();});
                    document.querySelector("input[name='proposal']").addEventListener("change", function(){
                        if(event.target.files.length > 0){
                            removeButton.disabled = true;
                            changeButton.disabled = false;
                            console.log("File selected");}
                        else{
                            removeButton.disabled = false;
                            changeButton.disabled = true;
                            console.log("No file selected");
                        }
                    });
                </script><?php
            }?>
        </div>
        <h3 class="text-center mb-4 mt-4">Pengguna yang Tertarik</h3>
        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped rounded" id="interesteesTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Organisasi</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($chatrooms as $chatroom) { ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                    <a href="<?php echo route('offer.chat', ['offer' => $offer, 'chatroom' => $chatroom->id]); ?>">
                                        <?php echo $interestees[$chatroom->interestee]->name;
                                        if(isset($notifications[$chatroom->id])){?>
                                            <span class="badge bg-warning ms-2">!</span>
                                        <?php } ?>
                                    </a>
                                </td>
                                <td>
                                    <?php
                                    echo $interestees[$chatroom->interestee]->organization ?? 'Individu';
                                    if (isset($verifications[$chatroom->interestee])) {
                                        echo ' <span class="badge bg-success">v</span>';
                                    } ?>
                                </td>
                                <td><?php echo date('d M Y', strtotime($chatroom->created_at)); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    const myevent = document.getElementById("myevent");
    const myevent = document.getElementById("myevent");
    const userId = "<?php echo Auth::user()->id;?>";
    const sfx = new Audio('/notification.mp3');
    $(document).ready(function() {
        $('table').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            language: {
                lengthMenu: "Tampilkan _MENU_ entri",
                zeroRecords: "Tidak ada data yang ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada entri tersedia",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });

    var pusher = new Pusher('5403b5f852800005f4e2', {
        cluster: 'ap1'});
    var channel = pusher.subscribe(userId);
    channel.bind('event', function(data){
        sfx.play().catch(error => console.error(error));
        switch(data["about"]){
            case "interested":
                alert(data["interesteename"] + " Tertarik dengan Event " + data["offername"] + "! Halaman ini akan dimuat ulang.");
                window.location.reload();break;
            case "incomingmessage":
                if(!notification){
                    myevent.insertAdjacentHTML("beforeend", "<span class='badge bg-warning'>!</span>");
                    notification=true;}
                alert(data["fromname"] + " Mengirim pesan baru!");break;
            case "thanked":
                alert(data["from"] + " Memberi anda Terima Kasih!");break;
            case "grantproposal":
                if(!notification){
                    myevent.insertAdjacentHTML("beforeend", "<span class='badge bg-warning'>!</span>");
                    notification=true;}
                alert(data["fromname"] + " Memberi anda akses proposal " + data["offername"] + "!");
            break;
        }
    });
</script>