<?php

class PotcoinStatsWidgetDatabase {

function ptsw_install() {
    global $wpdb;
    global $ptsw_db_version;
    $table_name = $wpdb->prefix . 'ptsw_data';

    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      timestamp datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      coin_from tinytext NOT NULL,
      coin_to tinytext NOT NULL,
      rate float NOT NULL,
      UNIQUE KEY id (id)
    );";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );
   add_option( "ptsw_db_version", $ptsw_db_version );
}

function ptsw_add_rate($coin_from,$coin_to,$rate) {
   global $wpdb;
   $table_name = $wpdb->prefix . 'ptsw_data';

   $mysqldate = date("Y-m-d H:i:s");
   $rows_affected = $wpdb->insert( $table_name, array( 'timestamp' => $mysqldate, 'coin_from' => $coin_from, 'coin_to' => $coin_to, 'rate' => $rate ) );
}

function ptsw_get_rate($coin_from,$coin_to) {
   global $wpdb;
   $table_name = $wpdb->prefix . 'ptsw_data';

   $date = date("Y-m-d H:i:s");
   $strtime = strtotime($date);
   $time = $strtime - 900; //15 min
   $date = date("Y-m-d H:i:s", $time);

   $result = $wpdb->get_results(
       "
       SELECT coin_from, coin_to, rate
       FROM $table_name
       WHERE coin_from = \"$coin_from\"
           AND coin_to = \"$coin_to\"
           AND timestamp > \"$date\"
       ;"
   );

   if (!($result)) {
      $result = 0;
   }

   return $result;
}

}
