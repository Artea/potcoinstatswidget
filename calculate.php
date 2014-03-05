<?php

  function apiRequest($url, $json) {
    $scheme = parse_url($url);
    $scheme = $scheme['scheme'];
    $delay = stream_context_create(array($scheme => array('timeout' => 5)));
    $response = file_get_contents($url);
    $result = $response;
    if($json) {
        if (is_array($json)) {
            $tmp = json_decode($response,true);
            for($i=0;$i<(count($json));$i++) {
                $tmp = $tmp[$json[$i]];
            }
            $result = $tmp;

            if($result) {
                return $result;
            }
            return false;
        }
        return json_decode($response[$json]);
     }
     return $return;
  }

  function getAveragePrice($array,$coin) {
    $return = 0;
    if(is_array($array)) {
        $i = 0;
        foreach($array as $row) {
            $i++;
            $arr = get_object_vars($row);
            if($arr['coin_from'] == $coin) {
                $return += $arr['rate'];
            }
        }
    }
    $return = number_format(($return / $i),8,'.',''); //return 8 decimals
    return $return;
  }
