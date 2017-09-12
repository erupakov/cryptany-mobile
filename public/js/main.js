function updateTransactionStatus() {
    console.log('Updating transaction status');
}

$(document).ready(function() {
    $('#plastic_card').mask('0000 0000 0000 0000');
    $('#validity_date').mask('00/00');
    $('#srcAmount').mask('0,000000');
    $('#dstAmount').mask('0,00');

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('9c9ae92cd015a8946533', {
        cluster: 'eu',
        encrypted: true
    });

    var channel = pusher.subscribe('transactions');
    channel.bind('App\\Events\\TransactionStatusEvent', updateTransactionStatus);
});