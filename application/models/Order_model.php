<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_orders() {
        $this->db->select(
            'o.order_id, o.invoice_no, o.date_added, o.total, o.currency_code, ' .
            'c.firstname AS customer_firstname, c.lastname AS customer_lastname, ' .
            'os.name AS order_status_name'
        );
        $this->db->from('oc_order o'); // oc_order
        $this->db->join('oc_customer c', 'c.customer_id = o.customer_id', 'left'); // oc_customer
        $this->db->join('oc_order_status os', 'os.order_status_id = o.order_status_id', 'left'); // oc_order_status
        $this->db->order_by('o.date_added', 'DESC'); // Latest orders first

        $query = $this->db->get();
        return $query->result_array();
    }
    /**
     * Fetches comprehensive details for a specific order, including customer and product information.
     * Assumes OpenCart 3 database structure.
     *
     * @param int $order_id The ID of the order to fetch.
     * @return array|false Returns an array of order details on success, false if order not found.
     */
    public function get_full_order_details($order_id) {
        // Fetch main order details and join with customer and order_status
        $this->db->select('o.*, c.firstname AS customer_firstname, c.lastname AS customer_lastname, c.email AS customer_email, ' .
                          'c.telephone AS customer_telephone, os.name AS order_status_name');
        $this->db->from('oc_order o'); // oc_order
        $this->db->join('oc_customer c', 'c.customer_id = o.customer_id', 'left'); // oc_customer
        $this->db->join('oc_order_status os', 'os.order_status_id = o.order_status_id', 'left'); // oc_order_status
        $this->db->where('o.order_id', $order_id);
        $order_query = $this->db->get();

        if ($order_query->num_rows() == 0) {
            return false; // Order not found
        }

        $order = $order_query->row_array();

        // Fetch order products
        $this->db->select('*');
        $this->db->from('oc_order_product'); // oc_order_product
        $this->db->where('order_id', $order_id);
        $order_products_query = $this->db->get();
        $order['products'] = $order_products_query->result_array();

        // Fetch order totals (sub-total, shipping, tax, total)
        $this->db->select('*');
        $this->db->from('oc_order_total'); // oc_order_total
        $this->db->where('order_id', $order_id);
        $this->db->order_by('sort_order', 'ASC');
        $order_totals_query = $this->db->get();
        $order['totals'] = $order_totals_query->result_array();

        return $order;
    }
}