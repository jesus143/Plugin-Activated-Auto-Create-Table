<?php

/*
Plugin Name: Activate me to create table
Plugin URI: https://www.automationlab.com.au
Description: When you activate this and should automatically create a table
Author: Michael Barbecho
Version: 0.1
Author URI: https://www.automationlab.com.au
Author Mail: michael@automationlab.com.au
Src: @https://codex.wordpress.org/Creating_Tables_with_Plugins
*/


register_activation_hook( __FILE__, 'wp_install' );
register_activation_hook( __FILE__, 'wp_install_data' );


global $jal_db_version;
$jal_db_version = '1.0';


function wp_install () {
    global $wpdb;
    $table_name = $wpdb->prefix . "liveshoutbox";


    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      name tinytext NOT NULL,
      text text NOT NULL,
      url varchar(55) DEFAULT '' NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );

}

function wp_install_data() {
    global $wpdb;

    $welcome_name = 'Mr. WordPress';
    $welcome_text = 'Congratulations, you just completed the installation!';

    $table_name = $wpdb->prefix . 'liveshoutbox';

    $wpdb->insert(
        $table_name,
        array(
            'time' => current_time( 'mysql' ),
            'name' => $welcome_name,
            'text' => $welcome_text,
        )
    );
}





