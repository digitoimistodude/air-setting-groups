<?php
/**
 * @Author:		Elias Kautto
 * @Date:   		2022-01-27 15:12:31
 * @Last Modified by:   Elias Kautto
 * @Last Modified time: 2022-01-27 16:06:38
 *
 * @package air-setting-groups
 */

// Gets value of $key in custom setting group $group
function get_custom_setting( $key, $group ) {
  $post_ids = Air_Setting_Groups\get_all_custom_setting_pages_for_key( $group );
  if ( empty( $post_ids ) ) {
    return false;
  }

  $first_key = array_key_first( $post_ids );
  $post_id = pll_get_post( $post_ids[ $first_key ] );

  $value = get_field( $key, $post_id );

  return $value;
} // end get_custom_setting