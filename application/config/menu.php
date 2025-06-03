<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Define your menu items in a nested array
// 'url' should be the CodeIgniter route (e.g., 'dashboard', 'users/manage')
// 'text' is what's displayed in the menu
// 'allowed_groups' is an array of user groups that can see this menu item.
// If 'allowed_groups' is empty or not set, it means it's visible to everyone logged in.

$config['app_menu'] = array(
    array(
        'url' => 'dashboard',
        'text' => 'Dashboard',
        'icon' => 'fa fa-tachometer-alt', // Optional: for icons
        'allowed_groups' => array('admin', 'editor', 'customer') // Visible to these groups
    ),
    // array(
    //     'url' => 'users',
    //     'text' => 'User Management',
    //     'icon' => 'fa fa-users',
    //     'allowed_groups' => array('admin') // Only visible to admin
    // ),
    array(
        'url' => 'leads',
        'text' => 'Leads',
        'icon' => 'fa fa-box',
        'allowed_groups' => array('admin', 'editor') // Visible to admin and editor
    ),
    array(
        'url' => 'orders',
        'text' => 'Orders',
        'icon' => 'fa fa-shopping-cart',
        'allowed_groups' => array('admin', 'sales', 'customer')
    ),
    array(
        'url' => 'customer_portal',
        'text' => 'Customer Portal',
        'icon' => 'fa fa-user-circle',
        'allowed_groups' => array('customer')
    ),
    array(
        'url' => 'reports',
        'text' => 'Reports',
        'icon' => 'fa fa-chart-line',
        'allowed_groups' => array('admin', 'manager') // Example of a new group 'manager'
    ),
    array(
        'url' => 'settings',
        'text' => 'Settings',
        'icon' => 'fa fa-cog',
        'allowed_groups' => array('admin')
    ),
    // Add more menu items here
);