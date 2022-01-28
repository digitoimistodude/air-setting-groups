<?php
/**
 * @Author:		Elias Kautto
 * @Date:   		2022-01-26 11:19:51
 * @Last Modified by:   Elias Kautto
 * @Last Modified time: 2022-01-28 11:23:37
 *
 * @package air-setting-groups
 */

namespace Air_Setting_Groups;

function register_cpt() {
  $generated_labels = [
    'menu_name'          => __( 'Asetusryhmät', get_prefix() ),
    'name'               => _x( 'Asetusryhmät', 'post type general name', get_prefix() ),
    'singular_name'      => _x( 'Asetusryhmä', 'post type singular name', get_prefix() ),
    'name_admin_bar'     => _x( 'Asetusryhmät', 'add new on admin bar', get_prefix() ),
    'add_new'            => _x( 'Lisää uusi', 'thing', get_prefix() ),
    'add_new_item'       => __( 'Lisää uusi asetusryhmä', get_prefix() ),
    'new_item'           => __( 'Uusi asetusryhmä', get_prefix() ),
    'edit_item'          => __( 'Muokkaa asetusryhmää', get_prefix() ),
    'view_item'          => __( 'Näytä asetusryhmä', get_prefix() ),
    'all_items'          => __( 'Näytä kaikki asetusryhmät', get_prefix() ),
    'search_items'       => __( 'Hae asetusryhmiä', get_prefix() ),
    'parent_item_colon'  => __( 'Asetusryhmän vanhemmat', get_prefix() ),
    'not_found'          => __( 'Asetusryhmiä ei löytynyt', get_prefix() ),
    'not_found_in_trash' => __( 'Asetusryhmiä ei löytynyt roskakorista', get_prefix() ),
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