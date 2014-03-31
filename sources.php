<?php

function updateRates($options) {

    $ptsw_db = new PotcoinStatsWidgetDatabase();

    #pot/btc rate
    /* //Since cryptorush are having issues right now it is temporarily disabled
    $name = "cryptorush.in";
    $url = "https://cryptorush.in/api.php?get=market&m=pot&b=btc&key=".$options['api_key_cryptorush']."&id=".$options['user_id_cryptorush']."&json=true";
    $coins = array('from' => 'POT','to' => 'BTC');
    $jsonpath = array('POT/BTC', 'last_buy');
    $result = apiRequest($url, $jsonpath);
    if($result) {
        $rate = floatval($result);
        $ptsw_db->ptsw_add_rate($coins['from'],$coins['to'],$rate);
    }
    */

    $name = 'swisscex.com';
    $coins = array('from' => 'POT','to' => 'BTC');
    $url = "http://api.swisscex.com/quote/POT/BTC/?apiKey=".$options['api_key_swissecex'];
    $jsonpath = array('quote', 'lastPrice');
    $result = apiRequest($url, $jsonpath);
    if($result) {
        $rate = floatval($result);
        $ptsw_db->ptsw_add_rate($coins['from'],$coins['to'],$rate);
    }
    
    $name = 'mintpal.com';
    $coins = array('from' => 'POT','to' => 'BTC');
    $url = "https://api.mintpal.com/market/stats/POT/BTC";
    $jsonpath = array('last_price');
    $result = apiRequest($url, $jsonpath);
    if($result) {
        $rate = floatval($result);
        $ptsw_db->ptsw_add_rate($coins['from'],$coins['to'],$rate);
    }

    #btc/usd rate
    $name = 'bitcoinaverage.com';
    $url = 'https://api.bitcoinaverage.com/ticker/global/USD';
    $coins = array('from' => 'BTC','to' => 'USD');
    $jsonpath = 'last';
    $result = apiRequest($url, $jsonpath);

    if($result) {
        $rate = floatval($result);
        $ptsw_db->ptsw_add_rate($coins['from'],$coins['to'],$rate);
    }

    $name = 'blockchain.info';
    $url = 'https://blockchain.info/ticker';
    $coins = array('from' => 'BTC','to' => 'USD');
    $jsonpath = array('USD','last');
    $result = apiRequest($url, $jsonpath);

    if($result) {
        $rate = floatval($result);
        $ptsw_db->ptsw_add_rate($coins['from'],$coins['to'],$rate);
    }
}
