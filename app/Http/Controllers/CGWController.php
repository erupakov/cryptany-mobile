<?php
/**
 * Welcome page actions controller
 * PHP Version 7
 *
 * @category Controller
 * @package  App\Http\Controllers
 * @author   Eugene Rupakov <eugene.rupakov@gmail.com>
 * @license  Apache Common License 2.0
 * @link     http://moblie.cryptany.io
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Welcome page actions controller
 *
 * @category Controller
 * @package  App\Http\Controllers
 * @author   Eugene Rupakov <eugene.rupakov@gmail.com>
 * @license  Apache Common License 2.0
 * @link     http://cgw.cryptany.io
 */
class CGWController extends Controller
{
    const AUTH_TOKEN = "android:n45qDLLOi8";

    /**
     * Method for rendering initial screen
     *
     * @method index
     *
     * @return View main view
     */
    public function index()
    {
        $contents = file_get_contents(
            "https://api.coinmarketcap.com/v1/ticker/ethereum/?convert=USD"
        );
        $eth_data = json_decode($contents, true);
            
        return view('welcome', [ 'eth_rate' => $eth_data[0]['price_usd'] ]);
    }

    /**
     * Method for handling user input from initial screen
     *
     * @param \Illuminate\Http\Request $request Request to process
     *
     * @method confirm
     *
     * @return View processing screen view
     */
    public function confirm(Request $request)
    {
        $request->validate(
            [
            'user_email' => 'required|email',
            'plastic_card' => 'required',
            'validity_date' => array('required','regex:/[01]\d\/[123]\d/u'),
            ]
        );

        Log::debug('Input data validated, going to create wallet');

        // create new wallet
        $addressArr = $this->_call_cryptany_service(
            'data/addr', [
                'email'=>$request->input('user_email'),
                'srcAmount'=>$request->input('srcAmount'),
                'dstAmount'=>$request->input('dstAmount'),
                'plastic_card'=>$request->input('plastic_card')
            ]
        );

        if ($addressArr===false) {
            Log::error('Error calling cgw service');
            return view('error');
        }

        return redirect()->route(
            'showTransaction', 
            [
                'id'=>$addressArr['walletHash']
            ]
        );
    }

    /**
     * Method for handling transaction page
     *
     * @param Illuminate\Http\Request $request request to process
     * @param string                  $id      Id of transaction to show
     *
     * @method showTransaction
     * @return View transaction view
     */
    public function showTransaction(Request $request, $id)
    {
        $txStatus = $this->_call_cryptany_service(
            'txs/checkAddress', [
                'wallet'=>$id
            ]
        );

        if ($txStatus===false) {
            Log::error('Wrong wallet Id passed or error calling CGW service');
            return view('error');
        }

        if ($txStatus['status']>=2) { // if transaction is registered in blockchain
            return view(
                'transaction',
                [
                    'address'=>$txStatus['address'],
                    'walletHash'=>$txStatus['walletHash'],
                    'srcAmount'=>$txStatus['srcAmount'],
                    'dstAmount'=>$txStatus['dstAmount'],
                    'status'=>$txStatus['status'],
                    'statusDate'=>$txStatus['statusDate'],
                    'card_number'=>'*'.substr($txStatus['card'], -4, 4)
                ]
            );
        }

        return view(
            'confirm', 
            [
                    'address'=>$txStatus['address'],
                    'walletHash'=>$txStatus['walletHash'],
                    'srcAmount'=>$txStatus['srcAmount'],
                    'dstAmount'=>$txStatus['dstAmount'],
                    'card_number'=>'*'.substr($txStatus['card'], -4, 4)
            ]
        );
    }

    /**
     * Method for handling FAQ page
     *
     * @method faq
     *
     * @return View faq page view
     */
    public function faq()
    {
        return view('faq');
    }

    /* Luhn algorithm number checker - (c) 2005-2008 shaman - www.planzero.org *
     * This code has been released into the public domain, however please      *
     * give credit to the original author where possible.                      */

    private function _luhn_check($number) 
    {

        // Strip any non-digits (useful for credit card numbers with spaces and 
        // hyphens)
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
        return ($total % 10 == 0) ? true : false;
    }

    /**
     * Method for handling FAQ page
     *
     * @param string $url  URI part of the REST method to call
     * @param Array  $data data to pass to REST method
     *
     * @method _call_cryptany_service
     *
     * @return View faq page view
     */    
    private function _call_cryptany_service( $url, $data=null )
    {
        $authCode = base64_encode(self::AUTH_TOKEN);
        Log::debug('Start service request, authCode:'.$authCode);

        $client = new \GuzzleHttp\Client(
            [
                'base_uri' => 'https://cgw.cryptany.io/', 
                    'headers' => [
                        'Authorization' => 'Basic '.$authCode
                    ],
                'verify' => false
            ]
        );
        $res = $client->request(
            'POST', $url, 
            [
                'form_params' => $data 
            ]
        );

        Log::debug('Called service, got:'.$res->getStatusCode().':'.$res->getBody());

        if ($res->getStatusCode()==200) { // request succeeded
            return json_decode($res->getBody(), true);
        } else {
            return false;
        }
    }
}
