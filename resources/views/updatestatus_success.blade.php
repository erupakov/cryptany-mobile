@extends('layouts.app')

@section('content')
<h3>Status processed successfully</h3>
<div class="alert alert-success" role="alert">
Status for transaction {{ $txid }} was changed to {{ $statusText }} [{{ $statusCode }}] successfully.
</div>

@endsection