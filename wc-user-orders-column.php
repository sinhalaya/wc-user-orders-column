<?php
/*
Plugin Name: WC User Orders Column
Plugin URI: https://redmedia.lk
Description: Adds a column to show the number of WooCommerce orders placed by each user in the WordPress Users area.
Version: 1.0
Requires at least: 5.0
Tested up to: 6.6
Requires PHP: 7.2
Author: RED Media Corporation
Author URI: https://redmedia.lk
License: GPL-2.0+
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wc-user-orders-column
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Add new column in Users list table
function wc_add_order_column( $columns ) {
    $columns['no_of_orders'] = __('No of Orders', 'wc-user-orders-column');
    return $columns;
}
add_filter( 'manage_users_columns', 'wc_add_order_column' );

// Display WooCommerce orders count for each user
function wc_show_order_count( $value, $column_name, $user_id ) {
    if ( 'no_of_orders' === $column_name ) {
        if ( class_exists( 'WooCommerce' ) ) {
            $orders = wc_get_orders( array( 'customer_id' => $user_id ) );
            return count( $orders );
        } else {
            return __('WooCommerce not found', 'wc-user-orders-column');
        }
    }
    return $value;
}
add_action( 'manage_users_custom_column', 'wc_show_order_count', 10, 3 );

// Make column sortable
function wc_sortable_order_column( $columns ) {
    $columns['no_of_orders'] = 'no_of_orders';
    return $columns;
}
add_filter( 'manage_users_sortable_columns', 'wc_sortable_order_column' );
