function updateTransactionUnconfirmedStatus(data) {
    console.log('Updating transaction status: Unconfirmed');
    $("#tx_status").text('Transaction found registered').fadeIn();
    $('#loader_icon').hide(fast);
}

function updateTransactionConfirmedStatus(data) {
    console.log('Updating transaction status: Confirmed');
    $("#tx_status").fadeOut(fast, function() {
        $this.text('Transaction confirmed');
        $this.fadeIn(fast);
    });
}

$(document).ready(function() {
    // setup copy to clipboard
    new Clipboard('button#btnCopyAddress');
    // create QR code
    $('#qrcode').qrcode({ text: walletAddress, width: 200, height: 200 });

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('9c9ae92cd015a8946533', {
        cluster: 'eu',
        encrypted: true
    });

    var channel = pusher.subscribe('transactions.' + walletId);
    channel.bind('App\\Events\\TransactionStatusUnconfirmedEvent', updateTransactionUnconfirmedStatus);
    channel.bind('App\\Events\\TransactionStatusConfirmedEvent', updateTransactionConfirmedStatus);
});