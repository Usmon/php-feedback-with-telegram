<?php
/**
 * Author: Usmon
 * Date: 23.12.2018
 * Time: 19:55
 */

//Telegram API params
$telegram_bot_token = 'botHERE_TOKEN_KEY'; //Need token with word "bot"
$telegram_user_id = 'HERE_USER_ID'; //Get your user name and set here 
 
//Get IP address
function getIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

//If POST request
if(isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['message']))
{
    //Params
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);
    $ip = getIp();
    //Check and send message
    if(!empty($name) && !empty($phone) && !empty($message))
    {
        //Start
        $url = 'https://api.telegram.org/'.$telegram_bot_token.'/sendMessage?text=:text_content&chat_id='.$telegram_user_id;
        $content = "Name: " .$name . "\nPhone: ". $phone ."\nMessage: ". $message . "\nIP: ".$ip;
        $replaced_url = str_replace(':text_content', urlencode($content), $url);
        $requestToTelegram = file_get_contents($replaced_url, true);
        $result = json_decode($requestToTelegram, true);
        //Response
        if(isset($result['ok']))
            echo json_encode(['result'=>true]);
        else
            echo json_encode(['result'=>false]);
    }
}
else
    header('Location: index.php');
