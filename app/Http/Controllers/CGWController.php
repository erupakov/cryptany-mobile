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
use Carbon\Carbon;

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

    const TX_STATUS = [
    1 => 'Transaction is created and waiting for payment',
    2 => 'Transaction is registered in blockchain and waiting for confirmation',
    3 => 'Transaction is confirmed in blockchain',
    4 => "We're processing transaction in our service center",
    5 => "We've processed transaction successfully and preparing card payment request",
    6 => "We've sent funds to your card",
    7 => "Transaction completed successfully and is currently marked as closed on our side",
    1000 => 'There was an error during transaction processing, reverting charges'
    ];

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
            "https://cgw.cryptany.io/data/rate"
        );
        $eth_data = json_decode($contents, true);
            
        return view('welcome', [ 'eth_rate' => $eth_data['rate'] ]);
    }

    /**
     * Method for rendering initial screen
     *
     * @method index
     *
     * @return View main view
     */
    public function indexLegacy()
    {
        $contents = file_get_contents(
            "https://cgw.cryptany.io/data/rate"
        );
        $eth_data = json_decode($contents, true);

        return view('legacy', [ 'eth_rate' => $eth_data['rate'] ]);
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
                'plastic_card'=>$request->input('plastic_card'),
                'validity_date'=>$request->input('validity_date')
            ]
        );

        if ($addressArr===false) {
            Log::error('Error calling cgw service');
            return view('error');
        }

        return redirect()->route(
            'showTransaction', 
            [
                'id'=>$addressArr['walletHash'],
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
            return view('notfound');
        }

        if ($txStatus['status']>=2) { // if transaction is registered in blockchain
			$transactionDate = new Carbon($txStatus['statusDate']);
			
            return view(
                'transaction',
                [
                    'address'=>$txStatus['address'],
                    'walletHash'=>$txStatus['walletHash'],
                    'srcAmount'=>$txStatus['srcAmount'],
                    'dstAmount'=>$txStatus['dstAmount'],
                    'statusCode'=>$txStatus['status'],
                    'statusText'=>$this::TX_STATUS[$txStatus['status']],
                    'statusDate'=>$transactionDate->toDateTimeString(),
                    'card_number'=>'*'.substr($txStatus['card'], -4, 4)
                ]
            );
        }

        return view( // return confirmation page (if transaction state is just Created)
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

    /**
     * Method for handling FAQ page
     * 
     * @param Request $request Request to process
     *
     * @method showUpdateStatusPage
     *
     * @return View faq page view
     */
    public function showUpdateStatusPage(Request $request)
    {
        $request->validate(
            [
            'txid' => 'required|max:8'
            ]
        );

        Log::debug('Input data validated, going to show update status page');

        $transaction = $this->_call_cryptany_service(
            'txs/one', [
                'walletHash'=>$request->input('txid')
            ]
        );

        if ($transaction===false) {
            Log::error('Wrong wallet Id passed or error calling CGW service');
            return view('notfound');
        }

        return view('updatestatus')->with('txid',$request->input('txid'))
			->with('statusCode',$transaction['status'])
			->with('statusText',$this::TX_STATUS[$transaction['status']])
			->with('card',$transaction['card'])
			->with('updated_at',$transaction['updated_at']);
    }

    /**
     * Method for processing status 
     * 
     * @param Request $request Request to process
     *
     * @method processUpdateStatus
     *
     * @return View faq page view
     */
    public function processUpdateStatus(Request $request)
    {
        $request->validate(
            [
            'txid' => 'required|max:8',
			'newStatus' => 'required'
            ]
        );

        Log::debug('Input data validated, going to process update status');

        $transaction = $this->_call_cryptany_service(
            'txs/status', [
                'walletHash'=>$request->input('txid'),
				'status'=>$request->input('newStatus')
            ]
        );

        if ($transaction===false) {
            Log::error('Wrong wallet Id passed or error calling CGW service');
            return view('notfound');
        }

        return view('updatestatus_success')->with('txid',$request->input('txid'))
			->with('statusCode',$request->input('newStatus'))
			->with('statusText',$this::TX_STATUS[$request->input('newStatus')]);
    }


    /**
     * Method for handling FAQ page
     * Luhn algorithm number checker - (c) 2005-2008 shaman - www.planzero.org
     * This code has been released into the public domain, however please
     * give credit to the original author where possible.
     *
     * @param string $number The card number to check
     *
     * @method _luhn_check
     *
     * @return boolean
     */
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
     * Method for calling cryptogateway service
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

		try 
		{
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
		} catch (\GuzzleHttp\Exception\ClientException $ex) {
			Log::error('Error calling CGW service not found error: '.$ex->getResponse()->getStatusCode());
			return false;
		} catch (\GuzzleHttp\Exception\TransferException $ex) {
			Log::error('Other error occured calling CGW service: ['.$ex->getResponse()->getStatusCode().']: '.$ex->getResponse()->getBody());
			return false;
		}
    }
}
