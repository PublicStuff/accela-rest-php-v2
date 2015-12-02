<?php

/**
 * Simple example showing how to use Accela CivicID for OAuth.
 */

// Include required files.
require '../src/CivicID.php';

// Settings for OAuth.
$redirect_uri = '';
$app_id = '';
$app_secret = '';
$environment = '';
$agency_name = '';

// Create a new CivicID object.
$auth = new CivicID($app_id, $app_secret, $environment, $agency_name, Scopes::$civicid, $redirect_uri);

// If first visit, redirect to CivicID login.
if(!$_GET) {
	echo '<a href="' . $auth->getAuthorizationURL() . '">Log in with Accela CivicID.';
} 

// After CivicID login, user is redirected back to this page.
else {

	// When Authorization Code is received, use it to request Access Token.
	$code = $_GET['code'];
	$response = $auth->getAccessToken($code);
	$auth_object = json_decode($response);
	$token = $auth_object->access_token;

	echo $token;

}