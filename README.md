# PHP Library for the Accela Construct API

## Usage

Clone this repo or download and extract the ```/src``` folder to a directory of your choosing.

Extend the base ```ConstructAPI``` class based on how you want to use the Construct API.

For example, to [search for specific records](https://developer.accela.com/docs/api_reference/v4.post.search.records.html) create a new class that leverages the ```sendPost``` method of the base class (see below).

The constructor and destructor methods for any custom classes you need to create will always be the same - use these methods on your custom class to pass the required parameters to the base class constructor.

You can create methods for this custom class that perform the operations you wish to execute against the Construct API. For example, the [search recods method](https://developer.accela.com/docs/api_reference/v4.post.search.records.html) of the Construct API performs an HTTP POST, so you'll want to leverage the ```sendPost``` method of the base class.

The method you implement for this in your custom class can have a signature that differs from the ```sendPost``` method of the base class, so long as when this base method is called all required arguements are passed. 

```php
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
```

We can now leverage this class to make calls to the Construct API.

```php
	// Create new instance of custom object.
	$records = new Records($app_id, $app_secret, $access_token, $environment, $agency);
	
	// Set path to look up records (see Construct API docs for details).
	$path = '/v4/search/records/';
	
	// Params to use in search (see Construct API docs for details).
	$params = array("limit" => 3, "expand" => "addresses");
	
	// Search criteria (see Construct API docs for details).
	$body = array("contacts" => array("lastName" => "Smith"));

	// Get the response from the Construct API. Print out ID for each record & status.
	$response =  $records->searchRecords($path, $params, $body);
	foreach($response->result as $record) {
		echo $record->id . "\n";
	}
```

Result:

```
ISLANDTON-15CAP-00000-002UK
ISLANDTON-15CAP-00000-002UL
ISLANDTON-15CAP-00000-002UJ
```

## Provisioning an API test token:

If you need a test token for developing against the Construct API, you can generate one with a utility included in the Accela developer portal.

1. Go to the API v3 [reference page](https://developer.accela.com/Resource/Index).
2. On the lower left, click on [Get an API Test Token](https://developer.accela.com/TestToken/Index).
3. Enter the agency name (Islandton for testing).
4. Enter the scope for the test token - this is a space delimited list of scope identifiers from the [API reference page](https://developer.accela.com/docs/).

## Getting a token programmatically

You can also use the ```getTokenWithPassword``` method of the CivicID class to programmatically obtain a token.

```php
// Create a new CivicID object.
$auth = new CivicID($app_id, $app_secret, $environment, $agency_name, 'records');

// Request a token with user id and password.
$response = $auth->getTokenWithPassword($userid, $password);

// Use the new token.
$new_token = $response->access_token;
```