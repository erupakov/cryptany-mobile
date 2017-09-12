@extends('layouts.app')

@section('content')
                    <form>
    <div class="input-group" style="margin-bottom: 1em;">
      <input type="number" name="srcAmount" class="form-control" aria-label="Transfer this amount of ETH" value="0.00254" min="0" max="1" required="required">
      <div class="input-group-btn">
        <button type="button" name="switchSrc" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          ETN
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#">BTC</a>
          <a class="dropdown-item" href="#">LTC</a>
          <a class="dropdown-item" href="#">ETN</a>
          <a class="dropdown-item" href="#">WVS</a>
        </div>
      </div>
    </div>
    <div class="input-group" style="margin-bottom: 1em;">
      <input type="number" name="dstAmount" class="form-control" aria-label="Get this amount of $" placeholder="$ to get" value="1" min="0" max="1" required="required">
      <div class="input-group-btn">     
        <button type="button" name="switchDst" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          USD
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#">USD</a>
          <a class="dropdown-item" href="#">EUR</a>
          <a class="dropdown-item" href="#">GBP</a>
        </div>
      </div>
    </div>

                        <div class="form-group">
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Submit</button>
                    </form>
@endsection