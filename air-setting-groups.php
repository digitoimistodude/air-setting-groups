<?php
/**
 * @Author:		Elias Kautto
 * @Date:   		2022-01-26 10:56:18
 * @Last Modified by:   Elias Kautto
 * @Last Modified time: 2022-01-26 14:00:43
 * 
 * Plugin Name: Air setting groups
 * Description:
 * Plugin URI: https://dude.fi
 * Author: Digitoimisto Dude Oy
 * Author URI: https://dude.fi
 * Version: 0.1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Network: false
 *
 * @package air-setting-groups
 */

namespace Air_Setting_Groups;

defined( 'ABSPATH' ) || exit;

function get_plugin_version() {
  return 010;
} //end get_plugin_version

function get_prefix( $hyphens = false ) {
  $prefix = 'air_setting_groups';

  if ( $hyphens ) {
    $prefix = str_replace( '_', '-', $prefix );
  }
  
  return $prefix;
} //end get_prefix



/**
 * Setting cpt registering
 */
include plugin_dir_path( __FILE__ ) . '/cpt-settings.php';
add_action( 'init', __NAMESPACE__ . '\register_cpt' );

/**
 * ACF
 * Running in plugins_loaded action to make sure that ACF is activated
 */
add_action( 'plugins_loaded', function() {
  if ( ! class_exists( 'ACF_Location' ) ) {
    return;
  }

  include plugin_dir_path( __FILE__ ) . '/acf-location-rule.php';
  add_action( 'acf/init', __NAMESPACE__ . '\init_settings_page_acf_location_rule' );
} );