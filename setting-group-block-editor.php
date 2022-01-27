<?php
/**
 * @Author:		Elias Kautto
 * @Date:   		2022-01-26 15:31:41
 * @Last Modified by:   Elias Kautto
 * @Last Modified time: 2022-01-27 16:26:05
 *
 * @package air-setting-groups
 */

namespace Air_Setting_Groups;

function air_setting_groups_editor_support_for_setting_group_post() {

  // Try find out which post id we are loading in admin
  $post_id = false;
  if ( isset( $_GET['post'] ) ) { // phpcs:ignore
    $post_id = intval( $_GET['post'] ); // phpcs:ignore
  } elseif ( isset( $_POST['post_ID'] ) ) { // phpcs:ignore
    $post_id = intval( $_POST['post_ID'] ); // phpcs:ignore
  }

  if ( ! $post_id ) {
    return;
  }

  if ( use_block_editor_in_custom_setting_group( $post_id ) ) {
    // Post type support 'editor' is needed for block editor
    add_post_type_support( get_prefix( true ), 'editor' );
  } else {
    remove_post_type_support( get_prefix( true ), 'editor' );
  }
} // end air_setting_groups_editor_support_for_setting_group_post

/**
 * Check whether to use classic or block editor
 * for a certain post type as defined in the settings
 */
function air_setting_groups_use_block_editor_in_custom_setting_group( $use_block_editor, $post ) {
  // Return if post type doesnt match the setting groups post type
  if ( get_prefix( true ) !== $post->post_type ) {
    return $use_block_editor;
  }

  return use_block_editor_in_custom_setting_group( $post->ID );
} // end air_setting_groups_use_block_editor_in_custom_setting_group

/**
 * Check if post has block editor enabled, return true if enabled.
 */
function use_block_editor_in_custom_setting_group( $post_id ) {
  $setting_group_post_ids = get_custom_setting_config();

  foreach ( $setting_group_post_ids as $key => $data ) {
    if ( false === pll_get_post( $data['id'] ) || null === pll_get_post( $data['id'] ) ) {
      continue;
    }

    $setting_group_post_ids[ $key ]['id'] = pll_get_post( $data['id'] );
  }

  $found = false;
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