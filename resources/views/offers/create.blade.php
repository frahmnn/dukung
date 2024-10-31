<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Buat Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
</head>
<body>
    <x-style/>
    <x-header/>
    <div class="container my-4">
        <h2 class="mb-4">Buat Event</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('offer.insert') }}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Nama Event*</label>
                        <small class="form-text text-muted">Nama ini akan tampil sebagai judul postingan event anda</small>
                        <input name="name" type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Deskripsi Event*</label>
                        <textarea name="description" class="form-control" id="description" style="min-height: 200px;" required placeholder="Masukkan Tanggal dan Waktu, Lokasi, dan Deskripsi Singkat..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label fw-bold">Foto Promosional</label>
                        <small class="form-text text-muted">Gunakan foto 4:3 untuk hasil terbaik. Foto pada urutan pertama akan digunakan sebagai Thumbnail. Setiap Foto harus berukuran kurang dari 2MB.</small>
                        <input type="file" name="image[]" class="form-control" id="images" accept=".jpeg, .png, .jpg" multiple>
                        <input type="hidden" name="order">
                        <small id="hint" class="form-text text-muted mb-3" style="display:none;">
                            Geser gambar untuk mengurutkan
                            <i class="bi bi-grip-vertical ms-1"></i>
                        </small>
                        <div id="imagePreviews" class="d-flex flex-wrap justify-content-center mt-3 gap-2">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="proposal" class="form-label fw-bold">Proposal</label>
                        <small class="form-text text-muted">Dokumen harus kurang dari 50MB</small>
                        <input type="file" name="proposal" class="form-control" id="proposal" accept=".doc, .docx, .odt, .rtf, .pdf">
                        <div id="proposalName" class="mt-2"></div>
                    </div>
                    <div class="mb-3">
                        <label for="closed_date" class="form-label fw-bold">Menerima sponsor sampai*</label>
                        <input name="closed_date" type="date" class="form-control" id="closed_date" min="{{ date('Y-m-d') }}" required onfocus="this.showPicker()"/>
                        <small class="form-text text-muted">Anda tidak bisa mengubah event jika sudah ditutup</small>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tag</label>
                        <small class="form-text text-muted mb-3 d-block">Pilih tag yang paling sesuai dengan event anda.</small>
                        <div class="row">
                        <?php $i = 1;?>
                            @foreach(['Seminar/Webinar', 'Workshop', 'Kompetisi', 'Pameran', 'Bazaar', 'Networking', 'Teknologi', 'Finansial', 'Seni & Budaya', 'Olahraga & Kesehatan', 'Amal', 'Pendidikan', 'Kuliner', 'Bahasa', 'Keagamaan', 'Sosial', 'Lingkungan'] as $tag)
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="tag_{{ $i++ }}" value="{{ $tag }}" id="{{ \Illuminate\Support\Str::slug($tag) }}">
                                        <label class="form-check-label" for="{{ \Illuminate\Support\Str::slug($tag) }}">{{ $tag }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Posting Pencarian</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<x-commonwebsocket/>
<script>
    const imagePreviews = document.getElementById("imagePreviews");
    const order = document.querySelector("input[name='order']")
    const proposalName = document.getElementById("proposalName");
    const hint = document.getElementById("hint");
    function stateOrder(){
        var Order = 0;
        var ORDER = [];
        imagePreviews.querySelectorAll('img[name]').forEach(img => {
            ORDER[Order++]= img.getAttribute("name");});
        order.value = JSON.stringify(ORDER);}
    document.querySelector("input[name='image[]']").addEventListener("change", function() {
        imagePreviews.innerHTML = "";
        const files = Array.from(event.target.files);
        hint.style.display = files.length > 1 ? "block" : "none";
        let imagesLoaded = 0;
        files.forEach(file => {
            if(file && file.type.startsWith("image/")){
                const reader = new FileReader();
                reader.onload = function(){
                    imagePreviews.insertAdjacentHTML("beforeend", "<img src='" + event.target.result + "' name='" + file.name + "' class='img-thumbnail' style='max-width: 200px; width: 100%; height: auto; aspect-ratio: 4 / 3; object-fit: cover;'>");
                    if(++imagesLoaded == files.length){stateOrder();}};
                reader.readAsDataURL(file);
            }
        });});
    new Sortable(imagePreviews, {
        animation: 150,
        chosenClass: "chosen",
        dragClass: "dragging",
        onEnd: stateOrder});
    document.querySelector(`form[action="<?php echo route('offer.insert');?>"]`).addEventListener("submit", function(){
        event.preventDefault();
        stateOrder();
        this.submit();});
</script>