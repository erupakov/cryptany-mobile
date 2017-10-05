@extends('layouts.app')

@section('content')
<h3>Frequenty asked questions</h3>
<p class="lead">We know there will be a lot of questions regarding our service. We've prepared answers to some commonly asked questions for you</p>

<h4>1. How to check a transaction status?</h4>
<p class="lead">You will receive a confirmation email to the provided email address after you create a new transaction
in Cryptany mobile wallet. This email contains web link to check the status of your transaction.</p>

<h4>2. Can I transfer more than 1 USD?</h4>
<p class="lead">No, in this Alpha the maximum transaction amount is limited to 1 USD</p>

<h4>3. When I get fiat on my card?</h4>
<p class="lead">Because the traditional banking system limitations, 
the transfer time of fiat currency to your card may take up to 3 days. 
However, usually it happens within 2 hours. If you do not receive your fiat after 3 days, please contact us.</p>

<h4>4. Why I can send only Ethereum?</h4>
<p class="lead">Currently, the only cryptocurrency available for transfer is Ethereum. More cryptocurrencies will be available in the future version of Cryptany mobile wallet.</p>

<h4>5. Can I reverse a transaction from my Cryptany Wallet?</h4>
<p class="lead">
No, an Ethereum transaction which has already been broadcast to the network cannot be reversed. This is an important feature of the bitcoin protocol which prevents payment fraud.
</p>

<h4>6. Does Cryptany conduct KYC / AML checks?</h4>
<p class="lead">
Every transaction passes KYC / AML checks. You may be required to provide additiononal documents. If the transaction is blocked by KYC / AML check, you would be fully refunded.
</p>

<h4>7. What is the maximum transaction amount?</h4>
<p class="lead">
In alpha version of the app the transaction size is limited to equivalent of 1 USD. Larger transactions would be blocked by the system and you will be fully refunded. Please remember that in order to get a refund, you should not use accounts on exchanges.
</p>

@endsection
