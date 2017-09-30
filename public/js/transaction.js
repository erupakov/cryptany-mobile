function updateTransactionUnconfirmedStatus(data) {
    console.log('Updating transaction status: Unconfirmed');
    location.reload(); // quick hack, will update without reloading later
}

function updateTransactionConfirmedStatus(data) {
    console.log('Updating transaction status: Confirmed');
    location.reload(); // quick hack, will update without reloading later
}

function updateTransactionFiatSentStatus(data) {
    console.log('Updating transaction status: Fiats sent');
    location.reload(); // quick hack, will update without reloading later
}

$(document).ready(function() {
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('9c9ae92cd015a8946533', {
        cluster: 'eu',
        encrypted: true
    });

    var channel = pusher.subscribe('transactions.' + walletId);
    channel.bind('App\\Events\\TransactionStatusUnconfirmedEvent', updateTransactionUnconfirmedStatus);
    channel.bind('App\\Events\\TransactionStatusConfirmedEvent', updateTransactionConfirmedStatus);
    channel.bind('App\\Events\\TransactionStatusFiatSentEvent', updateTransactionFiatSentStatus);
});