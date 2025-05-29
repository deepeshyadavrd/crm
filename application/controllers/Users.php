<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('User_model'); // Load your User_model

        // --- Access Control (THE PROTECTION) ---
        // Check if user is NOT logged in. If not, redirect them to the login page.
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('error', 'You must be logged in to access this page.');
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'CRM User List';
        $data['current_user_username'] = $this->session->userdata('username'); // Pass current user's username

        // Fetch all users using the model
        $data['users'] = $this->User_model->get_all_opencart_users();

        // Load the view to display the user list
        $this->load->view('users_list_view', $data);
    }
}