<?php

include dirname(__FILE__) . "/../vendor/autoload.php";
require_once dirname(__FILE__) . "/../config/config.php";
require_once dirname(__FILE__) . "/../php/OpenIdConnectClient.php";

?>
<!DOCTYPE html>
<html>

<head>
    <title>Redirecting</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="utf8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<?php require("menu.php") ?>

<header id='head' class='secondary'>
    <div class='container'>
        <div class='row'>
            <h1>Redirecting ...</h1>
        </div>
    </div>
</header>
<?php

//$oidc = new OpenIDConnectClient(
//    'https://api.learning-layers.eu/o/oauth2',
//    $oidcClientId,
//    $oidcClientSecret);
//
//// FIXME: Avoid error with SSL certificate in dev environment (use SSL in production!!)
//$oidc->setVerifyHost(false);
//$oidc->setVerifyPeer(false);
//
//
//$name = $oidc->requestUserInfo('given_name');
//echo "<br>oidc name: " . $name;
//
//if($oidc) {
//    print_r($oidc);
//} else {
//    echo "Could not establish OIDC connection";
//}

//$oidc->providerConfigParam(array(
//    'token_endpoint' => 'https://api.learning-layers.eu/o/oauth2/connect/token')
//);

//$oidcInfo = $oidc->getAccessToken();
//$accessToken = $oidcInfo["access_token"];
//$userEmail = $oidcInfo["email"];
//$userGivenName = $oidcInfo["given_name"];
//$userFamilyName = $oidcInfo["family_name"];
//
//echo "<br>access token: " . $accessToken;
//echo "<br>email: " . $userEmail;
//echo "<br>family name: " . $userFamilyName;
//echo "<br>given name: " . $userGivenName;

?>

<?php include("footer.php"); ?>

</body>
</html>


