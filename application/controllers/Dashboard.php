<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        // Check if user is logged in, otherwise redirect to login
        if (!$this->session->userdata('is_logged_in')) {
            redirect('auth/login');
        }
        
    }

    public function index() {
        $data['title'] = 'CRM Dashboard';
        $data['username'] = $this->session->userdata('username');
        
        $data['content_view'] = 'dashboard_view'; // This is the new filename for your dashboard content

        // Load the main layout view
        $this->load->view('layouts/main_layout', $data);
    }
}