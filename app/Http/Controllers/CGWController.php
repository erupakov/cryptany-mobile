<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CGWController extends Controller
{
    const AUTH_TOKEN = "android:n45qDLLOi8";

    public function index()
    {
        $contents = file_get_contents("https://api.coinmarketcap.com/v1/ticker/ethereum/?convert=USD");
        $eth_data = json_decode($contents, TRUE);
            
        return view('welcome', [ 'eth_rate' => $eth_data[0]['price_usd'] ]);
    }

    public function confirm(Request $request)
    {
	    $request->validate([
    	    'user_email' => 'required|email',
            'plastic_card' => 'required',
            'validity_date' => array('required','regex:/[01]\d\/[23]\d/u')
	    ]);

		Log::debug('Input data validated, going to create wallet');

        // create new wallet
        $addressArr = $this->_call_cryptany_service('data/addr', ['email'=>$request->input('user_email')] );

        if ($addressArr===false) {
            Log::error('Error calling cgw service');
            return view('error');
        }

        return view(
            'confirm', 
            [
                'address'=>$addressArr['address'],
                'srcAmount'=>$request->input('srcAmount'),
                'dstAmount'=>$request->input('dstAmount'),
                'card_number'=>'*'.substr($request->input('plastic_card'),-4,4)
            ]
        );
    }

    public function transaction()
    {
        return view('transaction');
    }

    public function faq()
    {
        return view('faq');
    }

/* Luhn algorithm number checker - (c) 2005-2008 shaman - www.planzero.org *
 * This code has been released into the public domain, however please      *
 * give credit to the original author where possible.                      */

	private function _luhn_check($number) {

  // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
  $number=preg_replace('/\D/', '', $number);

  // Set the string length and parity
  $number_length=strlen($number);
  $parity=$number_length % 2;

  // Loop through each digit and do the maths
  $total=0;
  for ($i=0; $i<$number_length; $i++) {
    $digit=$number[$i];
    // Multiply alternate digits by two
    if ($i % 2 == $parity) {
      $digit*=2;
      // If the sum is two digits, add them together (in effect)
      if ($digit > 9) {
        $digit-=9;
      }
    }
    // Total up the digits
    $total+=$digit;
  }

  // If the total mod 10 equals 0, the number is valid
  return ($total % 10 == 0) ? TRUE : FALSE;
}

    private function _call_cryptany_service( $url, $data=null )
    {
        $authCode = base64_encode( self::AUTH_TOKEN );
		Log::debug('Start service request, authCode:'.$authCode);

		$client = new \GuzzleHttp\Client(
			[
				'base_uri' => 'https://cgw.cryptany.io/', 
				'headers' => [
					'Authentication' => 'Basic '.$authCode
				],
				'verify' => false
			]
		);
		$res = $client->request('POST', $url, [
		    		'form_params' => $data ]
				);

		Log::debug('Called service, got:'.$res->getStatusCode().':'.$res->getBody());

        if ($res->getStatusCode()==200) { // request succeeded
            return json_decode($res->getBody(), true);
        } else {
            return false;
        }
    }
}
