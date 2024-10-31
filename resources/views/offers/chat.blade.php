<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung - Diskusi (<?php echo $offer_name;?>)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Chat Anda dengan <strong><?php echo $to->name; ?></strong>
                            <?php if ($verified) { ?>
                                <i class="fas fa-check-circle text-success ms-1" title="Verified"></i>
                            <?php } ?>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <?php echo $to->organization ? $to->organization : 'Individu'; ?>
                        </h6>
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('images/profiles/' . $to_profilepicture) }}" alt="Profile Picture" class="img-fluid rounded-circle border" style="width: 60px; height: 60px; border: 2px solid rgba(0, 0, 0, 0.3);">
                            <div class="ms-3">
                                <p class="mb-0">Total Event: <strong><?php echo $to_offers; ?></strong></p>
                                <p class="mb-0">Event Aktif: <strong><?php echo $to_activeoffers; ?></strong></p>
                                <p class="mb-0">Terima Kasih: <strong><?php echo $to_thanks; ?></strong></p>
                                <p class="mb-0">Event: <a href="<?php echo route('offer.offer', $offer); ?>"><?php echo $offer_name; ?></a></p>

                            </div>
                        </div>

                        <?php if ($withproposal) : ?>
                            <?php if ($chatroom != null) : ?>
                                <?php if ($grantproposal == 0) : ?>
                                    <form method="POST" action="<?php echo route('offer.grantproposal', ['offer' => $offer, 'chatroom' => $chatroom]); ?>" autocomplete="off" onsubmit="return confirm('Berikan akses ke proposal? Setelah dibuka, akses proposal tidak bisa ditutup lagi.');">@csrf
                                        <button type="submit" class="btn btn-primary btn-sm mb-2">Buka Akses Proposal</button>
                                    </form>
                                <?php else : ?>
                                    <p class="text-success">Akses proposal tersedia</p>
                                <?php endif; ?>

                                <?php if (!$thanked) : ?>
                                    <form method="POST" action="<?php echo route('offer.thank', ['offer' => $offer, 'chatroom' => $chatroom]); ?>" autocomplete="off">@csrf
                                        <button type="submit" class="btn btn-success btn-sm mb-2">Beri Terima Kasih</button>
                                    </form>
                                <?php endif; ?>
                            <?php else : ?>
                                <?php if ($grantproposal != 0) : ?>
                                    <a href="<?php echo route('offer.proposal', $offer); ?>" class="btn btn-info btn-sm mb-2">Lihat Proposal</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Column: Chat Section -->
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div id="chat" class="chat-box d-flex flex-column">
                            <?php foreach ($messages as $message) : ?>
                                <div class="chat-message <?php echo ($message->from == Auth::user()->id) ? 'from-me' : 'from-them'; ?>">
                                    <?php echo $message->message; ?>
                                    <div class="timestamp mt-1 text-muted small">
                                        <?php echo date('d M Y, H:i', strtotime($message->created_at)); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Message Input -->
                <form id="chatform" class="d-flex" autocomplete="off">@csrf
                    <textarea name="message" class="form-control me-2" required placeholder="Tulis pesan Anda..."></textarea>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<style>
    .chat-box {
        height: 400px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 1rem;
        background-color: #f9f9f9;
    }

    .chat-message {
        padding: 0.5rem;
        border-radius: 10px;
        margin-bottom: 0.5rem;
        max-width: 75%;
    }

    .from-me {
        align-self: flex-end;
        background-color: #007bff;
        color: white;
    }

    .from-them {
        align-self: flex-start;
        background-color: #e9ecef;
        color: black;
    }

    .timestamp {
        font-size: 0.75rem;
        text-align: right;
    }
</style>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    const chat = document.getElementById("chat");
    const route = "<?php echo route('offer.sendchat', ['offer' => $offer, 'chatroom' => $chatroom]);?>";
    const messageInput = document.querySelector("textarea[name='message']");
    const to = "<?php echo $to->name;?>";
    const chatForm = document.getElementById("chatform");
    const submitButton = chatForm.querySelector('button[type="submit"]');
    const textarea = chatForm.querySelector('textarea');
    const myevent = document.getElementById("myevent");
    const userId = "<?php echo Auth::user()->id;?>";
    const sfx = new Audio('/notification.mp3');
    function formatTimestamp(timestamp) {
        const date = new Date(timestamp);
        
        const optionsDate = { year: 'numeric', month: 'short', day: 'numeric' };
        const optionsTime = { hour: '2-digit', minute: '2-digit', hour12: false };

        const formattedDate = date.toLocaleDateString('en-GB', optionsDate).replace(' ', ' ');
        const formattedTime = date.toLocaleTimeString('en-GB', optionsTime).replace(':', ':');

        return `${formattedDate}, ${formattedTime}`;}
    chatForm.addEventListener("submit", async function(){
        event.preventDefault();
        submitButton.disabled = true;
        textarea.readonly = true;
        try{
            const response = await fetch(route, {
                method: "POST",
                headers:{
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value},
                body: new FormData(this)});
                const result = await response.json()
                if (response.ok) {
                    messageInput.value = "";
                    chat.insertAdjacentHTML("beforeend", `
                        <div class="chat-message from-me">
                            ${result.message}
                            <div class="timestamp mt-1 text-muted small">
                                ${formatTimestamp(result.timestamp)}
                            </div>
                        </div>
                    `);
                    chat.scrollTop = chat.scrollHeight; // Scroll to bottom
                    console.log("Pesan Terkirim");
                }
                else{
                alert("Pesan gagal dikirim; silakan muat ulang halaman");
            }}
        catch(error){
            console.log(error);
            alert("Pesan gagal dikirim; silakan muat ulang halaman");}
        submitButton.disabled = false;
        textarea.readonly = false;
    });

    var pusher = new Pusher('5403b5f852800005f4e2', {
        cluster: 'ap1'});
    var channel = pusher.subscribe(userId);
    channel.bind('event', function(data){
        sfx.play().catch(error => console.error(error));
        switch(data["about"]){
            case "interested":
                if(!notification){
                    myevent.insertAdjacentHTML("beforeend", "<span class='badge bg-warning'>!</span>");
                    notification=true;}
                alert(data["interesteename"] + " Tertarik dengan Event " + data["offername"] + "!");break;
            case "incomingmessage":
                chat.insertAdjacentHTML("beforeend", `
                    <div class="chat-message from-them">
                        ${data['message']}
                        <div class="timestamp mt-1 text-muted small">
                            ${formatTimestamp(data['timestamp'])}
                        </div>
                    </div>
                `);
                chat.scrollTop = chat.scrollHeight; // Scroll to bottom
                break;
            case "thanked":
                alert(data["from"] + " Memberi anda Terima Kasih!");break;
            case "grantproposal":
                alert(data["fromname"] + " Memberi anda akses proposal " + data["offername"] + "! Halaman akan dimuat ulang.");
                window.location.reload();
            break;
        }
    });
</script>