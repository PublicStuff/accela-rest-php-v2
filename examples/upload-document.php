<?php 

/**
 * A simple script to test the Accela PHP class library.
 */

include '../src/ConstructAPI.php';

// App, agency & environment settings.
$app_id = '';
$app_secret = ''; 
$token = '';
$environment = 'TEST';
$agency = 'Islandton';

// Simple object that extends the ConstructAPI object.
class Inspections extends ConstructAPI {
	public function __construct($app_id, $app_secret, $token, $environment, $agency) {
		parent::__construct($app_id, $app_secret, $token, $environment, $agency);
	}
	public function uploadInspectionDocuments($path, $auth_type, $params, $fileName, $fileType, $filePath, $description) {
		return parent::sendFormPost($path, $auth_type, $params, $fileName, $fileType, $filePath, $description);
	}
	public function __destruct() {
		parent::__destruct();
	}
}

try {

	// File to upload.
	$fileName = 'smile.png';
	$filePath = getcwd() . '/images/' . $fileName;
	$fileType = 'image/png';
	$fileDescription = 'A test document that will make you smile.';

	$inspectionID = ''; // Enter an inpsection ID to test.
	$params = array();
	$path = '/v4/inspections/' . $inspectionID . '/documents';

	// Create new Inspections object.
	$inspection = new Inspections($app_id, $app_secret, $token, $environment, $agency_name);
	
	// Upload new inspection doc
	$response = $inspection->uploadInspectionDocuments($path, AuthType::$AccessToken, $params, $fileName, $fileType, $filePath, $description);

	// Vie response
	var_dump($response);
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

