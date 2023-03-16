<?php
/**
 * Plugin Name: Air setting groups
 * Description: Provides a way to store custom settings in CPT and receive those with field id and setting group key.
 * Plugin URI: https://dude.fi
 * Author: Digitoimisto Dude Oy
 * Author URI: https://dude.fi
 * Version: 1.0.1
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Network: false
 * Text Domain: air_setting_groups
 *
 * @package air-setting-groups
 */

namespace Air_Setting_Groups;

defined( 'ABSPATH' ) || exit;

function get_plugin_version() {
  return 101;
} //end get_plugin_version

function get_prefix( $hyphens = false ) {
  $prefix = 'air_setting_groups';
  $prefix = apply_filters( 'air_setting_groups_prefix', $prefix );

  if ( $hyphens ) {
    $prefix = str_replace( '_', '-', $prefix );
  }

  return $prefix;
} //end get_prefix

/**
 * Gets custom settings array from theme settings.
 */
function get_custom_setting_config( $post_ids = [] ) {
  if ( ! defined( 'THEME_SETTINGS' ) ) {
    return $post_ids;
  }
  
  if ( ! isset( THEME_SETTINGS['custom_settings'] ) ) {
    return $post_ids;
  }

  return wp_parse_args( THEME_SETTINGS['custom_settings'], $post_ids );
} // end get_custom_setting_config

/**
 * Get custom setting pages for a specific post id.
 */
function get_all_custom_setting_pages_for_key( $key ) {
  $setting_group_posts = get_custom_setting_config();
  $original_setting_post = null;

  foreach ( $setting_group_posts as $group => $data ) {
    if ( $key === $group ) {
      $original_setting_post = $data['id'];
    }
  };

  if ( ! function_exists( 'pll_get_post_translations' ) ) {
    return [
      $original_setting_post,
    ];
  }

  if ( pll_is_translated_post_type( get_prefix( true ) ) ) {
    $translations = pll_get_post_translations( $original_setting_post );
    return $translations;
  }

  return [ $original_setting_post ];
} // end get_all_custom_setting_pages_for_key

/**
 * Add setting group CPT to polylang allow multilingual settings.
 */
add_filter( 'pll_get_post_types', function( $post_types, $is_settings ) {
  $post_types[ get_prefix( true ) ] = get_prefix( true );
  return $post_types;
}, 10, 2 );

/**
 * Register CPT.
 */
include plugin_dir_path( __FILE__ ) . '/cpt-settings.php';
add_action( 'init', __NAMESPACE__ . '\register_cpt' );

/**
 * ACF - Adds custom location rule to ACF
 * Running in plugins_loaded action to make sure that ACF is activated.
 */
add_action( 'plugins_loaded', function() {
  if ( ! class_exists( 'ACF_Location' ) ) {
    return;
  }

  include plugin_dir_path( __FILE__ ) . '/acf-location-rule.php';
  add_action( 'acf/init', __NAMESPACE__ . '\init_settings_page_acf_location_rule' );
} );

/**
 * Block editor
 */
include plugin_dir_path( __FILE__ ) . '/setting-group-block-editor.php';
add_action( 'admin_init', __NAMESPACE__ . '\air_setting_groups_editor_support_for_setting_group_post', 99, 1 );

/**
 * Get custom setting function
 */
include plugin_dir_path( __FILE__ ) . '/get-setting.php';

/**
 * Load translations
 */
add_action( 'plugins_loaded', function() {
  $plugin_path = '/air-setting-groups/languages/';
  load_plugin_textdomain( get_prefix(), false, $plugin_path );
} );
