<?php

/*
Plugin Name: Potcoin Stats Widget
Plugin URI: https://github.com/dbsnurr/potcoinstatswidget
Description: Display the latest potcoin / usd exchange rate
Author: dbsnurr
Version: 1.1
Author URI: https://github.com/dbsnurr
*/

define('PTSW_DIR', dirname(__FILE__));
include(PTSW_DIR . '/options.php');

class PotcoinStatsWidget extends WP_Widget
{
  function PotcoinStatsWidget()
  {
    $widget_ops = array('classname' => 'PotcoinStatsWidget', 'description' => 'Displays the Potcoin / USD exchange rate' );
    $this->WP_Widget('PotcoinStatsWidget', 'Potcoin Exchange Rate', $widget_ops);
  }

  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }

  function widget($args, $instance)
  {
    wp_enqueue_style( 'potcoinstatswidget-style', plugins_url('style.css', __FILE__) );
    extract($args, EXTR_SKIP);

    $options = get_option('potsw_option_name');

    #pot/btc rate
    $url = "https://cryptorush.in/api.php?get=market&m=pot&b=btc&key=".$options['api_key']."&id=".$options['user_id']."&json=true";
    $json = file_get_contents($url);
    $result = json_decode($json, true);
    $market = $result['POT/BTC'];
    $ratepotbtc = $market['last_buy'];

    #btc/usd rate
    $url = "https://blockchain.info/ticker";
    $json = file_get_contents($url);
    $result = json_decode($json, true);
    $ratebtcusd = $result['USD'];
    $ratebtcusd = $ratebtcusd['last'];

    #pot/usd
    $ratepotusd = ($ratepotbtc * $ratebtcusd);

    echo $before_widget;
    $title = $instance['title'];

    if (!empty($title))
      echo $before_title . $title . $after_title;;

    $poturl = "https://cryptorush.in/index.php?p=trading&m=POT&b=BTC";
    $btcurl = "https://blockchain.info";
    $potusdstat = '<h4><a href="'. $poturl .'">POT/USD</a></h4>' . '$' . $ratepotusd;
    $potbtcstat = '<h4><a href="'. $btcurl .'">POT/BTC</a></h4>' . 'B⃦' . $ratepotbtc;
    $content = "$potusdstat $potbtcstat";

    // WIDGET CODE GOES HERE
    echo $content;
    echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("PotcoinStatsWidget");') );?>
