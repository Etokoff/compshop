<?php

$res = file_get_contents('https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11');

    $res2 = json_decode($res, true);
    print_r($res2);
    $kurs = $res2[0]['sale'];
    echo $kurs;
