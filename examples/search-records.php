<?php 

/**
 * Search records.
 */

require '../src/ConstructAPI.php';

// App, agency & environment settings.
$app_id = '635502785397498905';
$app_secret = 'f8529997f4b04d2e8f2bd082d944e31a'; 
$token;
$environment = 'TEST';
$agency = 'Islandton';

// Simple object that extends the ConstructAPI object.
class Records extends ConstructAPI {

	public function __construct($app_id, $app_secret, $token, $environment, $agency) {
		parent::__construct($app_id, $app_secret, $token, $environment, $agency);
	}
	public function searchRecords($path, $params, $body) {
		return parent::sendPost($path, AuthType::$NoAuth, $params, $body);
	}
	public function __destruct() {
		parent::__destruct();
	}
}

try {

	// Create new instance of custom object.
	$records = new Records($app_id, $app_secret, $access_token, $environment, $agency);
	// Set path to look up records.
	$path = '/v4/search/records/';
	// Params
	$params = array("limit" => 3, "expand" => "addresses");
	// Search criteria.
	$body = array("contacts" => array("lastName" => "Smith"));

	// Get the response from the Construct API. Print out ID for each record & status.
	$response =  $records->searchRecords($path, $params, $body);
	foreach($response->result as $record) {
		echo $record->id . "\n";
	}

}

// Catch ConstructAPI excpetions.
catch(ConstructException $ex) {
	$details = json_decode($ex->getMessage());
	echo "Code: " . $ex->getCode() . "\n";
	echo "Message: " . $details->message . "\n";
	echo "TraceID: " . $details->traceId . "\n\n";
}

// There's big trouble in River City.
catch(Exception $ex) {
	echo "Code: " . $ex->getCode() . "\n";
	echo $ex->getMessage() . "\n\n";
}