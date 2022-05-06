<?php
/**
 * @Author:		Elias Kautto
 * @Date:   		2022-01-26 11:19:51
 * @Last Modified by:   Elias Kautto
 * @Last Modified time: 2022-03-02 11:22:21
 *
 * @package air-setting-groups
 */

namespace Air_Setting_Groups;

function register_cpt() {
  $generated_labels = [
    'menu_name'          => __( 'Setting groups', 'air_setting_groups' ),
    'name'               => _x( 'Setting groups', 'post type general name', 'air_setting_groups' ),
    'singular_name'      => _x( 'Setting group', 'post type singular name', 'air_setting_groups' ),
    'name_admin_bar'     => _x( 'Setting groups', 'add new on admin bar', 'air_setting_groups' ),
    'add_new'            => _x( 'Add new', 'thing', 'air_setting_groups' ),
    'add_new_item'       => __( 'Add new setting group', 'air_setting_groups' ),
    'new_item'           => __( 'New setting group', 'air_setting_groups' ),
    'edit_item'          => __( 'Edit a setting group', 'air_setting_groups' ),
    'view_item'          => __( 'Show setting group', 'air_setting_groups' ),
    'all_items'          => __( 'Show all setting groups', 'air_setting_groups' ),
    'search_items'       => __( 'Search for setting groups', 'air_setting_groups' ),
    'parent_item_colon'  => __( 'Setting group parents', 'air_setting_groups' ),
    'not_found'          => __( 'Setting groups not found', 'air_setting_groups' ),
    'not_found_in_trash' => __( 'Setting groups not found in the trash', 'air_setting_groups' ),
  ];

  $args = [
    'labels'              => $generated_labels,
    'description'         => '',
    'menu_position'       => 55,
    'menu_icon'           => 'dashicons-forms',
    'public'              => false,
    'has_archive'         => false,
    'exclude_from_search' => false,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_rest'        => true,
    'rewrite'             => false,
    'supports'            => [ 'title', 'revisions', 'editor' ],
    'taxonomies'          => [],
  ];

  register_post_type( get_prefix( true ), $args );
}