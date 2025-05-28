<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url'); // Make sure URL helper is loaded for site_url()
        $this->load->model('Order_model'); // Load your Order_model

        // --- Access Control (THE PROTECTION) ---
        // Ensure only logged-in users can access this page
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('error', 'You must be logged in to access this page.');
            redirect('auth/login');
        }
    }

    /**
     * Displays the list of all orders.
     */
    public function index() {
        $data['title'] = 'Order List';
        $data['orders'] = $this->Order_model->get_all_orders(); // Fetch all orders

        // Tell the layout which content view to load
        $data['content_view'] = 'order_list_view'; // This is the new filename for your order list content

        // Load the main layout view
        $this->load->view('layouts/main_layout', $data);
    }

    // --- (Your existing methods for creating orders, etc. would be here) ---

    // Example of a view_order function (if you have one, or you can create it)
    // This function would display detailed info for a single order
    public function view_order($order_id) {
        $order = $this->Order_model->get_full_order_details($order_id);

        if (!$order) {
            show_404(); // Or redirect with error
            return;
        }

        $data['order'] = $order;
        $data['title'] = 'Order Details #' . $order_id;
        // Assuming you'll create a dedicated order_details_content.php
        $data['content_view'] = 'order_details_content'; // You'll create this file

        $this->load->view('layouts/main_layout', $data);
    }
}