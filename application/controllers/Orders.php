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

        // Load your dashboard layout (or a simple header/footer structure)
        // If you have a full layout with sidebar:
        // $this->load->view('dashboard_header', $data); // Assuming dashboard_header handles the sidebar and top part
        // $this->load->view('order_list_view', $data);
        // $this->load->view('dashboard_footer'); // Assuming dashboard_footer closes the layout

        // For simplicity, directly load the view with a simple HTML structure
        // This will embed the whole page, including basic CSS.
        // For production, consider using a proper templating system or modular views.
        $this->load->view('order_list_view', $data);
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
        $this->load->view('order_details_view', $data); // You'd create an order_details_view for this
    }
}