<?php
/**
 * @Author:		Elias Kautto
 * @Date:   		2022-01-27 15:12:31
 * @Last Modified by:   Timi Wahalahti
 * @Last Modified time: 2023-03-16 12:56:34
 *
 * @package air-setting-groups
 */

// Gets value of $key in custom setting group $group
function get_custom_setting( $key, $group ) {
  $post_ids = Air_Setting_Groups\get_all_custom_setting_pages_for_key( $group );
  if ( empty( $post_ids ) ) {
    return false;
  }

  if ( ! function_exists( 'get_field' ) ) {
    return false;
  }

  $first_key = array_key_first( $post_ids );
  $post_id = $post_ids[ $first_key ];

  if ( function_exists( 'pll_get_post' ) ) {
    $post_id = pll_get_post( $post_id );
  }
  $value = get_field( $key, $post_id );

  return $value;
} // end get_custom_setting
