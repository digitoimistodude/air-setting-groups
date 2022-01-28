<?php
/**
 * @Author:		Elias Kautto
 * @Date:   		2022-01-26 15:31:41
 * @Last Modified by:   Elias Kautto
 * @Last Modified time: 2022-01-28 12:13:14
 *
 * @package air-setting-groups
 */

namespace Air_Setting_Groups;

/**
 * Remove editor from post type supports if its not enabled
 */
function air_setting_groups_editor_support_for_setting_group_post() {
  // Try find out which post id we are loading in admin
  $post_id = false;
  if ( isset( $_GET['post'] ) ) { // phpcs:ignore
    $post_id = intval( $_GET['post'] ); // phpcs:ignore
  } elseif ( isset( $_POST['post_ID'] ) ) { // phpcs:ignore
    $post_id = intval( $_POST['post_ID'] ); // phpcs:ignore
  } elseif ( isset( $_POST['post_id'] ) ) { // phpcs:ignore
    $post_id = intval( $_POST['post_id'] ); // phpcs:ignore
  }

  if ( ! $post_id ) {
    return;
  }

  if ( ! use_block_editor_in_custom_setting_group( $post_id ) ) {
    remove_post_type_support( get_prefix( true ), 'editor' );
  }
} // end air_setting_groups_editor_support_for_setting_group_post

/**
 * Check if post has block editor enabled, return true if enabled.
 */
function use_block_editor_in_custom_setting_group( $post_id ) {
  if ( get_prefix( true ) !== get_post_type( $post_id ) ) {
    return false;
  }

  $setting_group_post_ids = get_custom_setting_config();
  $found = false;

  foreach ( $setting_group_post_ids as $key => $data ) {
    if ( false === pll_get_post( $data['id'] ) || null === pll_get_post( $data['id'] ) ) {
      continue;
    }

    $setting_group_post_ids[ $key ]['id'] = pll_get_post( $data['id'] );
  }

  foreach ( $setting_group_post_ids as $data ) {
    if ( $data['id'] !== $post_id ) {
      continue;
    }

    $found = true;
  }

  if ( false === $found ) {
    return false;
  }

  foreach ( $setting_group_post_ids as $key => $data ) {
    if ( ! array_key_exists( 'block_editor', $data ) ) {
      unset( $setting_group_post_ids[ $key ] );
    }
  }

  foreach ( $setting_group_post_ids as $key => $data ) {
    if ( $post_id === $data['id'] && true === $data['block_editor'] ) {
      return true;
    }
  }

  return false;
} // end use_block_editor_in_custom_setting_group