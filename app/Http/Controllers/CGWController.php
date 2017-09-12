<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CGWController extends Controller
{

    public function index()
    {
        return view('welcome', [ 'eth_rate' => 345.44 ]);
    }

    public function confirm()
    {
	    $request->validate([
    	    'email' => 'required|email',
            'plastic_card' => 'required',
            'validity_date' => array('required','regex:/[01]\d/[123]\d/u')
	    ]);

        return view('transaction');
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

/**
 * Configure the validator instance.
 *
 * @param  \Illuminate\Validation\Validator  $validator
 * @return void
 */
 public function withValidator($validator)
 {
     $validator->after(function ($validator) {
         if ($this->somethingElseIsInvalid()) {
             $validator->errors()->add('field', 'Something is wrong with this field!');
         }
     });
 }
}
