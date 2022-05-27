<?php

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
    "PHONE" => [
        ["VALUE" => htmlspecialchars($_POST['tel']), "VALUE_TYPE" => "WORK"]
    ],
    "SOURCE_ID" => 'WEB',
    "SOURCE_DESCRIPTION" => 'https://nedvex.ru/morskojkvartal/', // сюда домен сайта откуда запрос шлем
    'UTM_CAMPAIGN' => $_COOKIE['utm_compaign'], // эти все значения предварительно в куки нужно сохранить
    'UTM_CONTENT' => $_COOKIE['utm_content'],
    'UTM_MEDIUM' => $_COOKIE['utm_medium'],
    'UTM_SOURCE' => $_COOKIE['utm_source'],
    'UTM_TERM' => $_COOKIE['utm_term'],
);

sendLeadToCRM($arLeadFields);