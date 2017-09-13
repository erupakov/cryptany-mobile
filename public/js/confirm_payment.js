function updateTransactionStatus() {
    console.log('Updating transaction status');
}

$(document).ready(function() {
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('9c9ae92cd015a8946533', {
        cluster: 'eu',
        encrypted: true
    });

    var channel = pusher.subscribe('transactions.' + walletId);
    channel.bind('App\\Events\\TransactionStatusEvent', updateTransactionStatus);
});