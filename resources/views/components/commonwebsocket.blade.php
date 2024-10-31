<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    const myevent = document.getElementById("myevent");
    const userId = "<?php echo Auth::user()->id;?>";
    const sfx = new Audio('/notification.mp3');
    var pusher = new Pusher('5403b5f852800005f4e2', {
        cluster: 'ap1'});
    var channel = pusher.subscribe(userId);
    channel.bind('event', function(data){
        sfx.play().catch(error => console.error(error));
        switch(data["about"]){
            case "interested":
                if(!notification){
                    myevent.insertAdjacentHTML("beforeend", "<span class='badge bg-warning'>!</span>");
                    notification=true;
                }
                alert(data["interesteename"] + " Tertarik dengan Event " + data["offername"] + "!");break;
            case "incomingmessage":
                if(!notification){
                    myevent.insertAdjacentHTML("beforeend", "<span class='badge bg-warning'>!</span>");
                    notification=true;
                }break;
            case "thanked":
                alert(data["from"] + " Memberi anda Terima Kasih!");break;
            case "grantproposal":
                if(!notification){
                    myevent.insertAdjacentHTML("beforeend", "<span class='badge bg-warning'>!</span>");
                    notification=true;
                }
                alert(data["fromname"] + " Memberi anda akses proposal " + data["offername"] + "!");
            break;
        }
    });
</script>