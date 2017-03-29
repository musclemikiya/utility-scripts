<?php
require "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
$consumerKey = '';
$consumerSecret = '';
$accessToken = '';
$accessTokenSecret = '';
$twObj = new TwitterOAuth($consumerKey,$consumerSecret,$accessToken,$accessTokenSecret);

$id_list_file = fopen('id_list.txt', 'r');
$follower_result_file = fopen('result.txt', 'w');

while ($screen_name = fgets($id_list_file)) {
    $res = $twObj->get('users/show', compact('screen_name'));
    if (isset($res->followers_count)) {
        $message = $res->followers_count;
    } else if (isset($res->errors[0]->message)) {
        echo $res->errors[0]->message;
        $message = $res->errors[0]->message;
    } else {
        echo 'Unknown Error';
        $message = 'Unknown Error';
    }
    fwrite($follower_result_file, $message . "\t" . $screen_name);
}

fclose($id_list_file);
fclose($follower_result_file);
