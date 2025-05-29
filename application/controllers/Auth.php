<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url'); // For redirect()
        $this->load->library('session'); // For session management
        $this->load->model('User_model'); // Load your new model
    }

    public function login() {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('is_logged_in')) {
            redirect('dashboard'); // Assuming you'll have a dashboard controller
        }

        $data['title'] = 'CRM Login';
        $this->load->view('login_form', $data);
    }

    public function process_login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        // var_dump($this->input->post('username'), $this->input->post('password'));

        $user = $this->User_model->verify_opencart_admin_user($username, $password);

        if ($user) {
            // Login successful, set session data
            $session_data = array(
                'user_id'       => $user['user_id'],
                'username'      => $user['username'],
                'user_group_id' => $user['user_group_id'],
                'is_logged_in'  => TRUE
            );
            $this->session->set_userdata($session_data);
            redirect('dashboard'); // Redirect to your CRM dashboard
        } else {
            // Login failed, redirect back to login with error
            $this->session->set_flashdata('error', 'Invalid username or password or inactive user.');
            redirect('auth/login');
        }
    }

    public function logout() {
        $this->session->sess_destroy(); // Destroy all session data
        redirect('auth/login'); // Redirect to login page
    }
}