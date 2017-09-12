<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Новый перевод</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #572A8D;
                color: white;
                font-family: 'Roboto', sans-serif;
                font-weight: 100;
            }
            .form-pane {
                background-color: white;
                border: 1px solid white;
                border-radius: 8px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-11 col-sm-10 col-md-8 col-lg-6 form-pane p-3 mx-auto mt-3 ">
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
          <div role="separator" class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">WVS</a>
        </div>
      </div>
    </div>
    <div class="input-group">
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
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Submit</button>
                    </form>
                </div>
            </div>       
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    </body>
</html>
