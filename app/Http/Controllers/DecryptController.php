<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;



class DecryptController extends Controller
{
    //
    public function Prueba(){
    	$string = 'd8578edf8458ce06fbc5bb76a58c5ca4';
		$encrypted = \Illuminate\Support\Facades\Crypt::encrypt($string);
		$decrypted_string = \Illuminate\Support\Facades\Crypt::decrypt($string);
    	return $decrypted_string;
    }

    public function Pass(){
    	return view('password');

    }


    public function DecryptPass(Request $request){

        $query=$request->input('query');

		$client = new Client();
		
		$url = 'https://hashes.org/api.php';
		$key = 'U9FpqwFkzdBczAUDOt17ZHlEanc748';

		$response = $client->request('GET','https://hashes.org/api.php',['query' => ['key' => 'U9FpqwFkzdBczAUDOt17ZHlEanc748', 'query' => $query], 'verify' => false]);
		$statusCode = $response->getStatusCode();
		$body = $response->getBody()->getContents();

		return $body;

    }


    public function SHA256Encrypt(Request $request){

        $query=$request->input('query');
        $SHA256='';
        $ArrayText=explode(',', $query);
        for ($i=0; $i < count($ArrayText)-1; $i++) {
        	if ($ArrayText[$i]=='') {
        		$SHA256=$SHA256.', ';
        	}
        	else{
		        $Salt=$ArrayText[$i].$i;
        		$SHA256=$SHA256.','.hash('sha256', $Salt.$ArrayText[$i]);
        	}
        }

        return $SHA256;
	}
}
