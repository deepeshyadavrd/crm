<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Order_model'); // Load your Order_model
        $this->load->library('email'); // Load CI's Email Library
        $this->load->library('pdf_generator'); // Load your custom PDF generator library

        // --- Access Control (THE PROTECTION) ---
        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('error', 'You must be logged in to access this page.');
            redirect('auth/login');
        }
    }

    /**
     * Displays the invoice as an HTML page in the browser.
     * @param int $order_id The ID of the order.
     */
    public function view($order_id) {
        $order = $this->Order_model->get_full_order_details($order_id);

        if (!$order) {
            show_404(); // Or redirect with an error message
            return;
        }

        $data['order'] = $order;
        $data['title'] = 'Invoice for Order #' . $order_id;

        // Load the invoice template view
        $data['content_view'] = 'invoice_templete_view'; // You'd create this

        $this->load->view('layouts/main_layout', $data);
    }

    /**
     * Generates and downloads the invoice as a PDF file.
     * @param int $order_id The ID of the order.
     */
    public function download_pdf($order_id) {
        $order = $this->Order_model->get_full_order_details($order_id);

        if (!$order) {
            show_404();
            return;
        }

        $data['order'] = $order;
        // Get the HTML content of the invoice view
        $html = $this->load->view('invoice_template_view', $data, TRUE); // TRUE to return as string

        $filename = 'invoice_' . $order_id . '.pdf';
        $this->pdf_generator->generate($html, $filename, 'A4', 'portrait', TRUE); // Stream to browser
    }

    /**
     * Sends the invoice as a PDF attachment to the customer's email.
     * @param int $order_id The ID of the order.
     */
    public function send_email($order_id) {
        $order = $this->Order_model->get_full_order_details($order_id);

        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found for invoice email.');
            redirect('orders'); // Redirect back to orders list
            return;
        }

        // Generate PDF content as a string (not streamed)
        $data['order'] = $order;
        $html = $this->load->view('invoice_template_view', $data, TRUE);
        $pdf_content = $this->pdf_generator->generate($html, '', 'A4', 'portrait', FALSE); // FALSE to return as string

        // --- Email Configuration (You MUST configure application/config/email.php first) ---
        // Load email config (if not autoloaded)
        // $this->load->config('email'); // If you put config in a separate file

        $this->email->from('raoshsbh6@gmail.com', 'Deepesh'); // Replace with your actual email
        $this->email->to($order['email']);
        $this->email->subject('Your Invoice for Order #' . $order_id . ' from Urbanwood');
        $this->email->message('Dear ' . htmlspecialchars($order['firstname']) . ',<br><br>' .
                               'Thank you for your recent order (Order #' . $order_id . ').<br>' .
                               'Please find your invoice attached to this email.<br><br>' .
                               'Regards,<br>Urbanwood');

        // Attach the generated PDF
        $filename = 'invoice_' . $order_id . '.pdf';
        $this->email->attach($pdf_content, 'attachment', $filename, 'application/pdf');

        if ($this->email->send()) {
            $this->session->set_flashdata('success', 'Invoice for Order #' . $order_id . ' sent successfully to ' . htmlspecialchars($order['customer_email']) . '.');
        } else {
            $this->session->set_flashdata('error', 'Failed to send invoice for Order #' . $order_id . '. Error: ' . $this->email->print_debugger());
            // Log the error for debugging: log_message('error', 'Email send failed: ' . $this->email->print_debugger());
        }

        redirect('orders'); // Redirect back to orders list or order details page
    }
}