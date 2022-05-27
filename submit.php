<?php

// require __DIR__ . '/../vendor/autoload.php';

// use Sendpulse\RestApi\ApiClient;
// use Sendpulse\RestApi\Storage\FileStorage;

// // API credentials from https://login.sendpulse.com/settings/#api
// define('API_USER_ID', '07622b2939bd98a17aae1f777de53904');
// define('API_SECRET', '642ebc4f446a3377ca47150a12419a15');
// $SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());

// $post = (!empty($_POST) ? true : false);
// if ($post && $_POST['phone']) {

//     $name = $_POST['name'];
//     $phone = $_POST['phone'];
//     var_dump($SPApiClient->addPhones(522600, [$_POST['phone']]));

//     $data = [
//         $$phone => [
//             [
//                 [
//                     'name' => 'var_value',
//                     'type' => 'string',
//                     'value' => $name,
//                 ]
//             ]
//         ]
//     ];

//     var_dump($SPApiClient->addPhonesWithVariables(522600, $data));

//     date_default_timezone_set( 'Europe/Moscow' );

//     $params = [
//         'sender' => 'Mor Kvartal', // Отправитель
//         'body' => 'Презентация комплекса и другие материалы по ссылке https://nedvex.ru', // Текст сообщения
//     ];

//     $additionalParams = [
//         'transliterate' => 0 // 1 или 0 , транслитерация тела
//     ];

//     var_dump($SPApiClient->sendSmsByBook(522600, $params, $additionalParams));
// }


function sendLeadToCRM($arLeadFields)
{
    $queryUrl = 'https://bitned.ru/rest/1/8eqh8cuzmlkwj1ds/crm.lead.add.json';
    $queryData = http_build_query(array(
        'fields' => $arLeadFields,
        'params' => array("REGISTER_SONET_EVENT" => "Y")
    ));
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,

    ));

    $result = curl_exec($curl);
    $result = json_decode($result, 1);
    curl_close($curl);
    return ($result);
}

$arLeadFields = array(
    "TITLE" => 'Запрос с сайта Volna Residence ' . $_POST['name'] . $_POST['tel'],
    "NAME" => $_POST["name"],
    "LAST_NAME" => $_POST["last_name"],
    // "SECOND_NAME" => $_POST["second_name"],
    // "COMMENTS" => $_POST["message"],
    // "EMAIL" => [
    //     ["VALUE" => htmlspecialchars($_POST['email']), "VALUE_TYPE" => "WORK"]
    // ],
    "PHONE" => [
        ["VALUE" => htmlspecialchars($_POST['phone']), "VALUE_TYPE" => "WORK"]
    ],
    "SOURCE_ID" => 'WEB',
    "SOURCE_DESCRIPTION" => 'https://volnaresidencesochi.ru', // сюда домен сайта откуда запрос шлем
    'UTM_CAMPAIGN' => $_COOKIE['utm_compaign'], // эти все значения предварительно в куки нужно сохранить
    'UTM_CONTENT' => $_COOKIE['utm_content'],
    'UTM_MEDIUM' => $_COOKIE['utm_medium'],
    'UTM_SOURCE' => $_COOKIE['utm_source'],
    'UTM_TERM' => $_COOKIE['utm_term'],
);

sendLeadToCRM($arLeadFields);