<?php

require_once 'config.php';

$config = new \API\Configuration();
$params = $config->getApi();

$fb = new Facebook\Facebook([
    'app_id' => $params['app_id'],
    'app_secret' => $params['app_secret'],
    'default_graph_version' => 'v2.2',
]);

$pdo = getPDO();

$data = $_SESSION['user'];
$data['is_active'] = false;

$userDB = new \API\DB\UserDB($pdo);
$userDB->save($data);

$helper = $fb->getRedirectLoginHelper();
$url = $helper->getLogoutUrl($_SESSION['fb_access_token'], 'http://alr.sweetheart.test/facebook/');

session_destroy();
header('Location: ' . urldecode($url));