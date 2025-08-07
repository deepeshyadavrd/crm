<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url'); // Make sure URL helper is loaded for site_url()
        $this->load->model('Order_model'); // Load your Order_model
        $this->load->library('pagination'); // Load the Pagination Library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // --- Access Control (THE PROTECTION) ---
        // Ensure only logged-in users can access this page
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('error', 'You must be logged in to access this page.');
            redirect('auth/login');
            if ($this->input->is_ajax_request()) {
                $this->output
                     ->set_content_type('application/json')
                     ->set_output(json_encode(['success' => false, 'message' => 'Authentication failed.']));
                exit();
            } else {
                redirect('login');
            }
        }
    }

    /**
     * Displays the list of all orders.
     */
    public function index() {
        $data['title'] = 'Order List';

        $search_query = $this->input->get('search_query', TRUE);
        $data['search_query'] = $search_query;

        // --- Pagination Configuration ---
        $config['base_url'] = site_url('orders/index'); // Base URL for pagination links
        $config['total_rows'] = $this->Order_model->count_all_orders($search_query); // Total records (with search filter)
        $config['per_page'] = 20; // Number of orders per page
        $config['uri_segment'] = 3; // The URI segment that contains the page number (e.g., /orders/index/20 where 20 is offset)
        $config['page_query_string'] = TRUE; // Use query strings for pagination (e.g., ?per_page=20)
        $config['query_string_segment'] = 'offset'; // The query string segment for the offset

        // Styling for pagination links (optional, but makes them look nicer)
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = 'Next &rarr;';
        $config['prev_link'] = '&larr; Previous';
        $config['cur_tag_open'] = '<span class="current-page">';
        $config['cur_tag_close'] = '</span>';
        $config['num_tag_open'] = '<span class="page-link">';
        $config['num_tag_close'] = '</span>';
        $config['attributes'] = array('class' => 'page-link'); // Apply class to all links

        // For query string pagination, you need to handle the 'offset'
        // from $_GET or $this->uri->segment() as per your config['uri_segment'] choice.
        // If 'page_query_string' is TRUE, CI automatically looks for 'offset' or whatever 'query_string_segment' is.
        $offset = $this->input->get('offset'); // Get the offset from the URL query string

        $this->pagination->initialize($config); // Initialize the pagination library


        $data['orders'] = $this->Order_model->get_all_orders($config['per_page'], $offset, $search_query); // Fetch all orders
        $data['order_statuses'] = $this->Order_model->get_order_statuses();
        $data['pagination_links'] = $this->pagination->create_links(); // Generate pagination links

        // Tell the layout which content view to load
        $data['content_view'] = 'order_list_view'; // This is the new filename for your order list content

        // Load the main layout view
        $this->load->view('layouts/main_layout', $data);
    }

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

    public function create() {
        // This method displays the form
        $data['title'] = 'Create New Order';
        $data['content_view'] =  'order/create_order_form';
        $this->load->view('layouts/main_layout', $data);
    }
    public function process() {
        // This method handles form submission

        // Set validation rules
        $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|max_length[32]');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|max_length[32]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[96]');
        $this->form_validation->set_rules('telephone', 'Telephone', 'required|trim|max_length[32]');

        $this->form_validation->set_rules('payment_firstname', 'Payment First Name', 'required|trim|max_length[32]');
        $this->form_validation->set_rules('payment_lastname', 'Payment Last Name', 'required|trim|max_length[32]');
        $this->form_validation->set_rules('payment_company', 'Payment Company', 'trim|max_length[64]');
        $this->form_validation->set_rules('payment_address_1', 'Payment Address 1', 'required|trim|max_length[128]');
        $this->form_validation->set_rules('payment_address_2', 'Payment Address 2', 'trim|max_length[128]');
        $this->form_validation->set_rules('payment_city', 'Payment City', 'required|trim|max_length[128]');
        $this->form_validation->set_rules('payment_postcode', 'Payment Postcode', 'required|trim|max_length[10]');
        $this->form_validation->set_rules('payment_country_id', 'Payment Country', 'required|integer');
        $this->form_validation->set_rules('payment_zone_id', 'Payment Region/State', 'required|integer');
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'required|trim|max_length[128]');
        $this->form_validation->set_rules('payment_code', 'Payment Code', 'trim|max_length[32]'); // Hidden, set by JS

        // Conditional validation for shipping address
        if (!$this->input->post('shipping_same_as_payment')) {
            $this->form_validation->set_rules('shipping_firstname', 'Shipping First Name', 'required|trim|max_length[32]');
            $this->form_validation->set_rules('shipping_lastname', 'Shipping Last Name', 'required|trim|max_length[32]');
            $this->form_validation->set_rules('shipping_company', 'Shipping Company', 'trim|max_length[64]');
            $this->form_validation->set_rules('shipping_address_1', 'Shipping Address 1', 'required|trim|max_length[128]');
            $this->form_validation->set_rules('shipping_address_2', 'Shipping Address 2', 'trim|max_length[128]');
            $this->form_validation->set_rules('shipping_city', 'Shipping City', 'required|trim|max_length[128]');
            $this->form_validation->set_rules('shipping_postcode', 'Shipping Postcode', 'required|trim|max_length[10]');
            $this->form_validation->set_rules('shipping_country_id', 'Shipping Country', 'required|integer');
            $this->form_validation->set_rules('shipping_zone_id', 'Shipping Region/State', 'required|integer');
            $this->form_validation->set_rules('shipping_method', 'Shipping Method', 'required|trim|max_length[128]');
            $this->form_validation->set_rules('shipping_code', 'Shipping Code', 'trim|max_length[32]'); // Hidden, set by JS
        }

        // Validate products
        $products = $this->input->post('products');
        if (empty($products)) {
            $this->form_validation->set_rules('products', 'Products', 'required', ['required' => 'At least one product is required.']);
        } else {
            foreach ($products as $key => $product) {
                $this->form_validation->set_rules("products[$key][name]", "Product #".($key+1)." Name", 'required|trim|max_length[255]');
                $this->form_validation->set_rules("products[$key][product_id]", "Product #".($key+1)." ID", 'integer'); // Can be 0
                $this->form_validation->set_rules("products[$key][model]", "Product #".($key+1)." Model", 'trim|max_length[64]');
                $this->form_validation->set_rules("products[$key][quantity]", "Product #".($key+1)." Quantity", 'required|integer|greater_than[0]');
                $this->form_validation->set_rules("products[$key][price]", "Product #".($key+1)." Unit Price", 'required|numeric|greater_than_equal_to[0]');
                $this->form_validation->set_rules("products[$key][tax_per_unit]", "Product #".($key+1)." Tax per Unit", 'numeric|greater_than_equal_to[0]');
            }
        }

        $this->form_validation->set_rules('order_status_id', 'Order Status', 'required|integer');
        $this->form_validation->set_rules('comment', 'Internal Comment', 'trim');
        $this->form_validation->set_rules('total_override', 'Grand Total Override', 'numeric|greater_than_equal_to[0]');


        if ($this->form_validation->run() == FALSE) {
            // Validation failed, reload the form with errors and previously entered data
            $data['status'] = 'error';
            $data['message'] = 'Please correct the errors in the form.';
            $this->load->view('order/create_order_form', $data);
        } else {
            // Validation passed, process the order
            $order_data = $this->input->post(); // Get all POST data

            $country_id = isset($order_data['payment_country_id']) ? (int)$order_data['payment_country_id'] : 0;
            $zone_id = isset($order_data['payment_zone_id']) ? (int)$order_data['payment_zone_id'] : 0;


            // Fetch country name and zone name based on the IDs from the database
            $country_name = $this->Order_model->get_country_name_by_id($country_id);
            $zone_name = $this->Order_model->get_zone_name_by_id($zone_id);

            // Now, add the fetched names to the $order_data array
            // This is how you "push" new data into your processing array.
            $order_data['payment_country'] = $country_name;
            $order_data['payment_zone'] = ($zone_id > 0) ? $zone_name : NULL;

            try {
                $order_id = $this->Order_model->create_opencart_order($order_data);

                $data['status'] = 'success';
                $data['order_id'] = $order_id;
                redirect('orders');
            } catch (Exception $e) {
                $data['status'] = 'error';
                $data['message'] = $e->getMessage();
                // If you want to show the form again with previous data after an error,
                // you'll need to set the `set_value` in the view manually.
                redirect('orders/create');
            }
        }
    }
    public function get_countries_json() {
        // Ensure this is an AJAX request or protect it as needed
        if (!$this->input->is_ajax_request()) {
            show_404(); // Or return an error
        }

        $countries = $this->Order_model->get_countries();
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($countries));
    }
    public function get_zones_json() { // Renamed for consistency
        // Ensure this is an AJAX request or protect it as needed
        if (!$this->input->is_ajax_request()) {
            show_404(); // Or return an error
        }

        $country_id = $this->input->get('country_id', TRUE); // TRUE for XSS cleaning

        if ($country_id) {
            $zones = $this->Order_model->get_zones_by_country($country_id);
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode($zones));
        } else {
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode([])); // Return empty array if no country_id
        }
    }
    public function update_status_and_upload($order_id){
        $this->load->library('upload');

        $order_status_id = $this->input->post('order_status_id');
        $comment = $this->input->post('comment');

        // Validate status
        if (!$order_status_id) {
            $this->session->set_flashdata('error', 'Please select a status.');
            redirect('orders/view_order/' . $order_id);
        }

        // Insert into oc_order_history
        $this->db->insert('oc_order_history', [
            'order_id' => $order_id,
            'order_status_id' => $order_status_id,
            'comment' => $comment,
            'date_added' => date('Y-m-d H:i:s'),
            'notify' => 0
        ]);

        // Update main order status
        $this->db->where('order_id', $order_id);
        $this->db->update('oc_order', ['order_status_id' => $order_status_id]);

        // Handle multiple image uploads
        if (!empty($_FILES['order_images']['name'][0])) {
            $uploadPath = './uploads/order_stage_images/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $files = $_FILES;
            $fileCount = count($_FILES['order_images']['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                $_FILES['order_image']['name'] = $files['order_images']['name'][$i];
                $_FILES['order_image']['type'] = $files['order_images']['type'][$i];
                $_FILES['order_image']['tmp_name'] = $files['order_images']['tmp_name'][$i];
                $_FILES['order_image']['error'] = $files['order_images']['error'][$i];
                $_FILES['order_image']['size'] = $files['order_images']['size'][$i];

                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB per image
                $config['file_name'] = 'order_' . $order_id . '_' . time() . '_' . $i;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('order_image')) {
                    $fileData = $this->upload->data();

                    // Insert record into oc_order_status_images
                    $this->db->insert('oc_order_status_images', [
                        'order_id' => $order_id,
                        'order_status_id' => $order_status_id,
                        'filename' => $fileData['file_name'],
                        'date_added' => date('Y-m-d H:i:s')
                    ]);
                } else {
                    // If even one upload fails, show the error and stop
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('orders/view_order/' . $order_id);
                }
            }
        }

        $this->session->set_flashdata('success', 'Order status updated successfully.');
        redirect('orders/view_order/' . $order_id);
    }

    // New method for AJAX status updates
    public function update_status() {
        if (!$this->input->is_ajax_request()) {
            // Not an AJAX request, reject it
            show_404();
        }

        // Set validation rules for the incoming POST data
        $this->form_validation->set_rules('order_id', 'Order ID', 'required|integer');
        $this->form_validation->set_rules('status_id', 'Status ID', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, send back an error response
            $response = [
                'success' => false,
                'message' => validation_errors()
            ];
        } else {
            $order_id = $this->input->post('order_id');
            $status_id = $this->input->post('status_id');

            // Call the model method to update the order status
            $result = $this->Order_model->update_order_status1($order_id, $status_id);

            if ($result) {
                // Success, send back a success response
                $response = [
                    'success' => true,
                    'message' => 'Order status updated successfully.'
                ];
            } else {
                // Update failed, send back an error response
                $response = [
                    'success' => false,
                    'message' => 'Database update failed.'
                ];
            }
        }

        // Send the JSON response and stop execution
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($response));
    }

}