<?php

include '../src/ConstructAPI.php';

// App, agency & environment settings.
$app_id = '';
$app_secret = ''; 
$token = '';
$environment = 'TEST';
$agency = 'Islandton';

class Record extends ConstructAPI {

	public function __construct($app_id, $app_secret, $token, $environment, $agency) {
		parent::__construct($app_id, $app_secret, $token, $environment, $agency);
	}

	public function getDocument($path, $auth_type, $params) {
		return parent::sendGet($path, $auth_type, $params);
	}

	public function __destruct() {
		parent::__destruct();
	}

}

// Create a new instance of the Record object.
$rec = new Record($app_id, $app_secret, $token, $environment, $agency);

$documentID = 3303405;
$path = '/v4/documents/' . $documentID;
$params = array();
$fileName = 'smile.png';
$filePath = getcwd() . '/images/' . $fileName;
$fileType = 'image/png';
$fileDescription = 'A test document that will make you smile.';

try {
	// Upload document.
	//$result = $rec->uploadDocument($path, AuthType::$AccessToken, $params, $fileName, $fileType, $filePath, $description);
	
	// Get document details.
	$result = $rec->getDocument($path, AuthType::$AccessToken, $params);

	var_dump($result);
}

catch(ConstructException $ex) {
	$details = json_decode($ex->getMessage());
	echo "Code: " . $ex->getCode() . "\n";
	echo "Message: " . $details->message . "\n";
	echo "TraceID: " . $details->traceId . "\n\n";
}

catch(Exception $ex) {
	echo "Code: " . $ex->getCode() . "\n";
	echo $ex->getMessage() . "\n\n";
}

