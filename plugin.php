<?php

/*
Plugin Name: Potcoin Stats Widget
Plugin URI: https://github.com/dbsnurr/potcoinstatswidget
Description: Display the latest potcoin / usd exchange rate
Author: dbsnurr
Version: 1.2
Author URI: https://github.com/dbsnurr
*/

define('PTSW_DIR', dirname(__FILE__));
include(PTSW_DIR . '/options.php');
include(PTSW_DIR . '/calculate.php');
include(PTSW_DIR . '/database.php');
include(PTSW_DIR . '/sources.php');

register_activation_hook(__FILE__, array('PotcoinStatsWidgetDatabase','ptsw_install') );

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
    $ptsw_db= new PotcoinStatsWidgetDatabase();

    echo $before_widget;
    $title = $instance['title'];

    if (!empty($title)) {
        echo $before_title . $title . $after_title;
    } else {
        echo $before_title . "Potcoin Exchange Rate" . $after_title;
    }

    $potRates = $ptsw_db->ptsw_get_rate('POT','BTC');
    $btcRates = $ptsw_db->ptsw_get_rate('BTC','USD');

    if(!($potRates) OR (!($btcRates))) {
        updateRates($options);
        $potRates = $ptsw_db->ptsw_get_rate('POT','BTC');
        $btcRates = $ptsw_db->ptsw_get_rate('BTC','USD');
    }

    $ratePotBtc = 0;
    $rateBtcUsd = 0;
    $ratePotUsd = 0;

    $ratePotBtc = getAveragePrice($potRates, 'POT');
    $rateBtcUsd = getAveragePrice($btcRates, 'BTC');
    $ratePotUsd = number_format(($ratePotBtc * $rateBtcUsd),8,'.','');

    $potUsd = '<h4>POT/USD</h4>' . '$' . $ratePotUsd;
    $potBtc = '<h4>POT/BTC</h4>' . '฿' . $ratePotBtc;
    $content = "$potUsd $potBtc";

    // WIDGET CODE GOES HERE
    echo $content;
    echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("PotcoinStatsWidget");') );?>
