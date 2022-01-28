<?php
/**
 * @Author:		Elias Kautto
 * @Date:   		2022-01-26 13:11:12
 * @Last Modified by:   Elias Kautto
 * @Last Modified time: 2022-01-28 12:15:23
 *
 * @package air-setting-groups
 */

namespace Air_Setting_Groups;

function init_settings_page_acf_location_rule() {
  $group_post_ids = get_custom_setting_config();

  if ( ! function_exists( 'acf_register_location_type' ) || empty( $group_post_ids ) ) {
    return;
  }

  acf_register_location_type( __NAMESPACE__ . '\ACF_Location_Custom_Settings' );
} // end init_settings_page_acf_location_rule

class ACF_Location_Custom_Settings extends \ACF_Location {
  public function initialize() {
    $this->name = get_prefix();
    $this->label = __( 'Asetusryhmä', get_prefix() ); // phpcs:ignore
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
  } // end match

  public static function get_operators( $rule ) {
    return array(
      '==' => __( 'is equal to', 'acf' ), // phpcs:ignore
    );
  } // end get_operators

  /**
   * Get the titles of custom settings for ACF field groups.
   */
  public function get_values( $rule ) {
    $settings = get_custom_setting_config();
    $choices = [];

    foreach ( $settings as $key => $data ) {
      $choices[ $key ] = $data['title'];
    }

    return $choices;
  } // end get_values
}

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