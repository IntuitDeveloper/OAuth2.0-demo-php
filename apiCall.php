<?php

require_once(__DIR__ . '/vendor/autoload.php');

use QuickBooksOnline\API\DataService\DataService;


function __autoload($className) {
    $file = PATH_TO_FOLDER_WITH_ALL_CLASS_FILES."/".$className.'.php';
    if(file_exists($file)) {
        require_once $file;
    }
}
session_start();


function makeAPICall()
{

    // Create SDK instance
    $config = include('config.php');
    $dataService = DataService::Configure(array(
        'auth_mode' => 'oauth2',
        'ClientID' => $config['client_id'],
        'ClientSecret' =>  $config['client_secret'],
        'RedirectURI' => $config['oauth_redirect_uri'],
        'scope' => $config['oauth_scope'],
        'baseUrl' => "development"
    ));

    $accessToken = $_SESSION['sessionAccessToken'];
    $dataService->updateOAuth2Token($accessToken);
    $companyInfo = $dataService->getCompanyInfo();

    print_r($companyInfo);
    return $companyInfo;
}

$result = makeAPICall();

?>