<?php
// Uncomment the three lines below to see errors

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require 'vendor/autoload.php';

 // Required data for VATSIM Connect

 $clientID                   = '';          // VATSIM Connect Client ID
 $clientSecret               = '';          // VATSIM Connect Client Secret
 $scopes                     = '';          // VATSIM Connect Scopes
 $redirectURL                = '';          // VATSIM Connect Redirect URL
 $loginDeniedURL             = '';          // LOCAL Redirect URL Login Denied
 $logoutURL                  = '';          // LOCAL Redirect URL Logout Message

 $urlAuthorize               = 'https://auth.vatsim.net/oauth/authorize';        // VATSIM Authorize URL
 $urlAccessToken             = 'https://auth.vatsim.net/oauth/token';            // VATSIM Token URL
 $urlResourceOwnerDetails    = 'https://auth.vatsim.net/api/user';               // VATSIM User Details URL

$provider = new \League\OAuth2\Client\Provider\GenericProvider([
    'clientId'                => $clientID,
    'clientSecret'            => $clientSecret,
    'redirectUri'             => $redirectURL,
    'urlAuthorize'            => $urlAuthorize,
    'urlAccessToken'          => $urlAccessToken,
    'urlResourceOwnerDetails' => $urlResourceOwnerDetails,
    'scopes'                  => $scopes
]);

// If we don't have an authorization code then get one
if (!isset($_GET['code'])) {

    // Fetch the authorization URL from the provider; this returns the
    // urlAuthorize option and generates and applies any necessary parameters
    // (e.g. state).
    $authorizationUrl = $provider->getAuthorizationUrl();

    // Get the state generated for you and store it to the session.
    $_SESSION['oauth2state'] = $provider->getState();

    // Optional, only required when PKCE is enabled.
    // Get the PKCE code generated for you and store it to the session.
    //$_SESSION['oauth2pkceCode'] = $provider->getPkceCode();

    // Redirect the user to the authorization URL.
    header('Location: ' . $authorizationUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {

    if (isset($_SESSION['oauth2state'])) {
        unset($_SESSION['oauth2state']);
    }

    exit('Invalid state');

} else {

    try {
    
        // Optional, only required when PKCE is enabled.
        // Restore the PKCE code stored in the session.
        //$provider->setPkceCode($_SESSION['oauth2pkceCode']);

        // Try to get an access token using the authorization code grant.
        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        // We have an access token, which we may use in authenticated
        // requests against the service provider's API.

        // echo 'Access Token: ' . $accessToken->getToken() . "<br>";
        // echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
        // echo 'Expired in: ' . $accessToken->getExpires() . "<br>";
        // echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";

        // Using the access token, we may look up details about the
        // resource owner.
        $resourceOwner = $provider->getResourceOwner($accessToken);

         // Fetch VATSIM data from resource owner
         $userData               = $resourceOwner->toArray();
         $vatsimEmail            = $userData['data']['personal']['email'];               // VATSIM Registered Email
         $vatsimCID              = $userData['data']['cid'];                             // VATSIM CID
         $vatsimNameFirst        = $userData['data']['personal']['name_first'];          // VATSIM Registered First Name
         $vatsimNameLast         = $userData['data']['personal']['name_last'];           // VATSIM Registered Last Name
         $vatsimCountryCode      = $userData['data']['personal']['country']['id'];       // VATSIM Registered Country Code
         $vatsimCountryName      = $userData['data']['personal']['country']['name'];     // VATSIM Registered Country Name
         $vatsimRatingID         = $userData['data']['vatsim']['rating']['id'];          // VATSIM ATC Rating ID
         $vatsimRatingShort      = $userData['data']['vatsim']['rating']['short'];       // VATSIM ATC Rating Short
         $vatsimRatingLong       = $userData['data']['vatsim']['rating']['long'];        // VATSIM ATC Rating Long
         $vatsimRegionName       = $userData['data']['vatsim']['region']['name'];        // VATSIM Region Name
         $vatsimRegionID         = $userData['data']['vatsim']['region']['id'];          // VATSIM Region ID
         $vatsimDivisionName     = $userData['data']['vatsim']['division']['name'];      // VATSIM Division Name
         $vatsimDivisionID       = $userData['data']['vatsim']['division']['id'];        // VATSIM Division ID
         $vatsimSubDivisionName  = $userData['data']['vatsim']['subdivision']['name'];   // VATSIM SubDivision Name
         $vatsimSubDivisionID    = $userData['data']['vatsim']['subdivision']['id'];     // VATSIM SubDivision ID
         $vatsimToken            = $userData['data']['oauth']['token_valid'];            // VATSIM Oauth Token Valid Boolean

        // var_export($resourceOwner->toArray());
         
        // Place your code here to start your session and use VATSIM data from above


         // 


    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

        // Failed to get the access token or user details.
        exit($e->getMessage());

    }

}


?>
