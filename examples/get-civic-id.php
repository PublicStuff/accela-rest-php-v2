<?php

/**
 * Simple example showing how to use password credentials to obtain an auth token.
 */

// Include required files.
require '../src/CivicID.php';

$app_id = '';
$app_secret = '';
$environment = '';
$agency_name = '';
$userid = '';
$password = '';

// Create a new CivicID object.
$auth = new CivicID($app_id, $app_secret, $environment, $agency_name, 'records');

// Request a token with user id and password.
$response = $auth->getTokenWithPassword($userid, $password);

// Write out the new token.
echo $response->access_token;
