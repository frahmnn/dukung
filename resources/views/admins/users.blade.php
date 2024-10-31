<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
</head>
<body>
    <x-header/>
    <x-style/>
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
        <h2 class="mb-4">Manajemen User</h2>
        <form method="POST" action="<?php echo route('admin.usersedit'); ?>" enctype="multipart/form-data" autocomplete="off">@csrf
            <a id="changes"></a>
            <button type="submit" disabled class="btn btn-primary mb-3">Simpan Perubahan</button>
        </form>
        <table class="table table-bordered table-hover table-striped rounded" id="usersTable">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Organisasi</th>
                    <th>Tandai untuk dihapus</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($users as $user) { ?>
                    <tr>
                        <td><?php echo $no++; ?>
                            <p style="display:none;"><?php
                                switch ($user->role){
                                    case "u":?>
                                        User<?php break;
                                    case "a":?>
                                        Admin<?php break;
                                    case "b":?>
                                        Banned<?php
                                    break;
                                }?>
                            </p>
                            <p style="display:none;"><?php echo $user->organization;?></p>
                        </td>
                        <td>
                            <a style="display:none;"><?php echo $user->name;?></a>
                            <input name="name" userid="<?php echo $user->id; ?>" type="text" 
                                class="form-control" 
                                onkeydown="return/[a-z' ]/i.test(event.key)" 
                                value="<?php echo $user->name; ?>" 
                                autocomplete="off" 
                                placeholder="Nama Pengguna">
                        </td>
                        <td>
                            <a style="display:none;"><?php echo $user->email;?></a>
                            <input name="email" userid="<?php echo $user->id; ?>" type="email" 
                                class="form-control" 
                                value="<?php echo $user->email; ?>" 
                                autocomplete="off" 
                                placeholder="Email Pengguna">
                        </td>
                        <td>
                            <?php if ($user->id != Auth::user()->id) { ?>
                                <select class="form-select" userid="<?php echo $user->id; ?>" name="role">
                                    <option value="u" <?php if ($user->role == "u") { ?>selected<?php } ?>>User</option>
                                    <option value="a" <?php if ($user->role == "a") { ?>selected<?php } ?>>Admin</option>
                                    <option value="b" <?php if ($user->role == "b") { ?>selected<?php } ?>>Banned</option>
                                </select>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($user->organization) { ?>
                                <span><?php echo $user->organization; ?></span>
                                <?php 
                                $verification_id = array_search($user->id, $verifications);
                                if ($verification_id) { ?>
                                    <button type="button" class="btn btn-link text-decoration-none" 
                                        onclick="viewverification('<?php echo $verification_id; ?>', '<?php echo $user->id; ?>')">
                                        Lihat Verifikasi
                                    </button>
                                    <form method="POST" action="<?php echo route('admin.deleteverification', $user->id); ?>" 
                                        enctype="multipart/form-data" autocomplete="off" style="display:inline;" onsubmit="return confirm('Hapus verifikasi?');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus Verifikasi</button>
                                    </form>
                                <?php } else { ?>
                                    <span class="text-muted">(Belum mendapat verifikasi)</span>
                                <?php } ?>
                            <?php } else { ?>
                                <span class="text-muted">(Individu)</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($user->id != Auth::user()->id) { ?>
                                <input name="delete" userid="<?php echo $user->id; ?>" type="checkbox" 
                                    class="form-check-input" 
                                    value="true" onchange="this.value = this.checked ? '' : true;">
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="verificationModal" tabindex="-1" aria-labelledby="verificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verificationModalLabel">Dokumen Verifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="documentList" class="list-group">
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
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
            },
            columnDefs: [
                {
                    targets: [3, 4, 5],
                    searchable: false
                }
            ]
        });
    });
    const users = <?php echo json_encode($users);?>;
    const changes = document.getElementById("changes");
    const saveChangeButton = document.querySelector(`form[action="<?php echo route('admin.usersedit');?>"] button[type="submit"]`);
    const filenames = <?php echo json_encode($filenames);?>;
    const documents = document.getElementById("documents");
    var onreview = "";
    function checkforchanges(){
        const oldinput = document.querySelector(`input[name="` + event.target.getAttribute('userid') + `_` + event.target.name + `"]`);
        if(oldinput){oldinput.remove();}
        const eventTargetValue = event.target.value.trim() == "" ? null : event.target.value;
        if(eventTargetValue != users[event.target.getAttribute("userid")][event.target.name] && event.target.value.trim() != ""){
            changes.insertAdjacentHTML("beforeend", `<input name="` + event.target.getAttribute('userid') + `_` + event.target.name + `" type="hidden" value="` + event.target.value + `">`);}
        saveChangeButton.disabled = (changes.innerHTML.trim() == "");}
    function viewverification(verification_id, user_id) {
        const documentList = document.getElementById("documentList");
        documentList.innerHTML = "";
        filenames[verification_id].forEach(filename => {
            const href = "<?php echo route('admin.verifications.accessfile', ['userid' => '__userid__', 'filename' => '__filename__']);?>"
                .replace("__userid__", user_id)
                .replace("__filename__", filename);
            const listItem = document.createElement("li");
            listItem.className = "list-group-item";
            listItem.innerHTML = `<a href='${href}' target='_blank'>${filename}</a>`;
            documentList.appendChild(listItem);
        });
        const verificationModal = new bootstrap.Modal(document.getElementById('verificationModal'));
        verificationModal.show();}
    document.querySelectorAll("td input").forEach(input => {
        input.addEventListener("input", checkforchanges);
        input.addEventListener("blur", function(event){
            if(event.target.value.trim() == ""){
                event.target.value = users[event.target.getAttribute("userid")][event.target.name];
            }
        });});
    document.querySelectorAll("td select").forEach(select => {
        select.addEventListener("change", checkforchanges);
    });
</script>