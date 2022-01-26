<?php
/**
 * @Author:		Elias Kautto
 * @Date:   		2022-01-26 15:31:41
 * @Last Modified by:   Elias Kautto
 * @Last Modified time: 2022-01-26 16:23:59
 *
 * @package air-setting-groups
 */

namespace Air_Setting_Groups;

add_action( 'admin_init', 'editor_support_for_setting_group_post', 99, 1 );
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
    add_post_type_support( 'settings', 'editor' );
  } else {
    remove_post_type_support( 'settings', 'editor' );
  }
} // end air_setting_groups_editor_support_for_setting_group_post

/**
 * Check whether to use classic or block editor
 * for a certain post type as defined in the settings
 *
 * @since 2.9.0
 */
add_filter( 'use_block_editor_for_post', __NAMESPACE__ . '\air_setting_groups_use_block_editor_in_custom_setting_group', 10, 2 );
function air_setting_groups_use_block_editor_in_custom_setting_group( $use_block_editor, $post ) {

  // Use block editor if settings page is a block editor type
  if ( get_prefix( true ) === $post->post_type ) {
    return use_block_editor_in_custom_setting_group( $post->ID );
  }

  return $use_block_editor;
} // end air_setting_groups_use_block_editor_in_custom_setting_group