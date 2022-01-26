<?php
/**
 * @Author:		Elias Kautto
 * @Date:   		2022-01-26 13:11:12
 * @Last Modified by:   Elias Kautto
 * @Last Modified time: 2022-01-26 16:24:11
 *
 * @package air-setting-groups
 */

namespace Air_Setting_Groups;

function init_settings_page_acf_location_rule() {
  $group_post_ids = custom_settings_post_ids();

  if ( ! function_exists( 'acf_register_location_type' ) || empty( $group_post_ids ) ) {
    return;
  }
  acf_register_location_type( __NAMESPACE__ . '\ACF_Location_Custom_Settings' );
}

class ACF_Location_Custom_Settings extends \ACF_Location {
  public function initialize() {
      $this->name = get_prefix();
      $this->label = __( 'Custom Settings Page', 'air-setting-groups' ); // phpcs:ignore
      $this->category = 'page';
  }

  /**
   * Check if current post key exists in custom setting group lists.
   */
  public function match( $rule, $screen, $field_group ) {
    $post_id = isset( $screen['post_id'] ) ? intval( $screen['post_id'] ) : null;

    if ( ! $post_id || get_prefix( true ) !== get_post_type( $post_id ) ) {
      return false;
    }
    $setting_pages = get_all_custom_setting_pages_for_key( $rule['value'] );
    // Compare setting group key to the original setting group post
    if ( in_array( $post_id, $setting_pages ) ) { // phpcs:ignore
      return true;
    }

    return false;
  }

  public static function get_operators( $rule ) {
    return array(
      '==' => __( 'is equal to', 'air-setting-groups' ), // phpcs:ignore
    );
  }

  /**
   * Get the titles of custom settings for ACF field groups.
   */
  public function get_values( $rule ) {

    // TODO
    $settings = custom_settings_post_ids();

    $choices = [];

    foreach ( $settings as $key => $data ) {
      $choices[ $key ] = $data['title'];
    }

    return $choices;
  }
}

function get_custom_setting_original_post_id( $post_id ) {
  if ( ! function_exists( 'pll_get_post_translations' ) ) {
    return $post_id;
  }

  $translations = pll_get_post_translations( $post_id );
  $group_post_ids = custom_settings_post_ids();

  $original_post_id = null;

  foreach ( $translations as $translation ) {
    if ( in_array( $translation, $group_post_ids ) ) { // phpcs:ignore
      $original_post_id = $translation;
    }
  }

  return $original_post_id;
}

/**
 * Check if post key exists in setting groups, if not then return translated setting groups
 */
function get_all_custom_setting_pages_for_key( $key ) {
  $setting_group_posts = custom_settings_post_ids();

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

  $translations = pll_get_post_translations( $original_setting_post );

  return $translations;
  // return array_map( function( $item ) {
  //   return $item;
  // }, $translations );
}

function custom_settings_post_ids( $post_ids = [] ) {
  if ( ! isset( THEME_SETTINGS['custom_settings_post_ids'] ) ) {
    return $post_ids;
  }

  return wp_parse_args( THEME_SETTINGS['custom_settings_post_ids'], $post_ids );
} // end custom_settings_post_ids