<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapBox\Formatter\Formatter;
use App\SecretTable;

class SecretController extends Controller
{
	public function ProcessData(Request $request)
	{
		//Validate form inputs
		$secretValidation = $request->validate([
			'secret' => 'required',
			'expireAfter' => 'required',
			'expireAfterViews' => 'required|numeric|min:1',
		]);

		//Create a new model
		$secretData = new SecretTable;

		//Fill up with data
		$secretData->hash = hash("sha256", round(microtime(true) * 1000));

		//Encrypt secret message to make more of a secret
		$encrypted_secret = openssl_encrypt($request->input("secret"), "AES-128-ECB", env("API_KEY", "SOMEKEY"));
		$secretData->secretText = $encrypted_secret;

		$secretData->createdAt = date('Y-m-d\TH:i:s');
		$secretData->expiresAt = date('Y-m-d\TH:i:s', time() + (intval($request->input("expireAfter")) * 60));
		$secretData->remainingViews = $request->input("expireAfterViews");
		$secretData->expireAfterViews = $request->input("expireAfterViews");

		//Save it to the database
		$secretData->save();

		//Format array to specified type
		$formatter = Formatter::make($secretData->toArray(), Formatter::ARR);

		//Get which parser should be used
		$formatType = env("API_PARSER", "JSON");

		if($formatType === "JSON")
			//Return the secret message as JSON format
			return $formatter->toJson();
		else
			//Return the secret message as XML format
			return $formatter->toXml();
	}

	public function ServeData($hash)
	{
		//Get Secret message where hash equals to given parameter
		$secretMessage = SecretTable::where('hash', '=', $hash)->first();

		//If secret message does not exist
		if(!$secretMessage)
			return "Secret not found";

		//Convert string dates to numeric seconds
		$expiresAt = strtotime($secretMessage->expiresAt);
		$createdAt = strtotime($secretMessage->createdAt);

		//Decrease available views by one
		$secretMessage->remainingViews--;

		//If the remaining views lower than zero or the given date expires, delete the secret message
		if(
			($secretMessage->remainingViews < 0) ||
			((($expiresAt < time()) && ($createdAt != $expiresAt)))
		)
		{
			//Delete secret message and return error message
			$secretMessage->delete();
			return "Secret not found";
		}

		//If the given statements are not true save the new available views
		$secretMessage->save();

		//Decrypt secret message
		$secretMessage->secretText = openssl_decrypt($secretMessage->secretText, "AES-128-ECB", env("API_KEY", "SOMEKEY"));

		//Format array to specified type
		$formatter = Formatter::make($secretMessage->toArray(), Formatter::ARR);

		//Get which parser should be used
		$formatType = env("API_PARSER", "JSON");

		if($formatType === "JSON")
			//Return the secret message as JSON format
			return $formatter->toJson();
		else
			//Return the secret message as XML format
			return $formatter->toXml();
	}
}
