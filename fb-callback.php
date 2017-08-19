<?php

require_once 'config.php';

$config = new \API\Configuration();
$params = $config->getApi();

$fb = new Facebook\Facebook([
    'app_id' => $params['app_id'],
    'app_secret' => $params['app_secret'],
    'default_graph_version' => 'v2.2',
]);

$helper = $fb->getRedirectLoginHelper();

$_SESSION['FBRLH_state'] = $_GET['state'];
try {
    $accessToken = $helper->getAccessToken();

    $response = $fb->get('/me?fields=id,name,email,picture', $accessToken);
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (!isset($accessToken)) {
    if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
    }
    exit;
}

$oAuth2Client = $fb->getOAuth2Client();
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
$tokenMetadata->validateAppId($params['app_id']);
$tokenMetadata->validateExpiration();

if (!$accessToken->isLongLived()) {
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
        exit;
    }
}

$_SESSION['fb_access_token'] = (string) $accessToken;

$user = $response->getGraphUser();

$data = [
    'facebook_id' => $user->getId(),
    'name' => $user->getName(),
    'email' => $user->getEmail(),
    'image' => $user->getPicture()->getUrl(),
    'is_active' => true,
];

$pdo = getPDO();
$userDb = new \API\DB\UserDB($pdo);
$accessTokenDB = new \API\DB\AccessTokenDB($pdo);

try {
    $entity = $userDb->find($user->getId());
    $data['id'] = $entity->getId();
    $userDb->save($data);
} catch (\Exception $ex) {
    $entity = $userDb->save($data);
    $data['id'] = $entity->getId();
} finally {
    $accessTokenDB->save(['user_id' => $entity->getId(), 'token' => $_SESSION['fb_access_token']]);
    $_SESSION['user'] = $data;
    header('Location: https://alr.sweetheart.test/facebook/profile.php');
}