<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function verify_opencart_admin_user($username, $password) {

        // Select user details based on username
        $this->db->select('user_id, username, password, salt, status, user_group_id');
        $this->db->from('oc_user'); // 'user' will become 'oc_user' due to dbprefix
        $this->db->where('username', $username);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            $user = $query->row_array();

            // Check if user is active in OpenCart admin
            if ($user['status'] == 0) { // 0 usually means disabled in OpenCart
                return false; // User is disabled
            }

            // Verify password using OpenCart's hashing method
            $hashed_password = sha1($user['salt'] . sha1($user['salt'] . sha1($password))); // THIS IS THE CORRECT HASHING

            if ($hashed_password === $user['password']) {
                // Password matches, return user data
                return $user;
            }
        }
        return false; // User not found or password incorrect
    }

    public function get_all_opencart_users() {
        // You might want to filter sensitive columns like 'password' and 'salt' in a real CRM
        $this->db->select('user_id, username, user_group_id, firstname, lastname, email, status, date_added');
        $this->db->from('oc_user'); // Corresponds to oc_user
        $this->db->order_by('username', 'ASC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array(); // Return an array of user arrays
        }
        return []; // Return an empty array if no users found
    }

}