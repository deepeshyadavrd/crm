<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    private function _apply_order_search_filter($search_query) {
        if (!empty($search_query)) {
            $search_query = $this->db->escape_like_str($search_query);
            $this->db->group_start();
            $this->db->or_like('o.order_id', $search_query);
            $this->db->or_like('o.invoice_no', $search_query);
            $this->db->or_like('o.firstname', $search_query);
            $this->db->or_like('o.lastname', $search_query);
            $this->db->or_like('os.name', $search_query);
            $this->db->group_end();
        }
    }
    public function get_all_orders($limit, $offset, $search_query = null) {
        $this->db->select(
            'o.order_id, o.invoice_no, o.date_added, o.total, o.currency_code, ' .
            'o.firstname AS firstname, o.lastname AS lastname, ' .
            'os.name AS order_status_name'
        );
        $this->db->from('oc_order o'); // oc_order
        // $this->db->join('oc_customer c', 'c.customer_id = o.customer_id', 'left'); // oc_customer
        $this->db->join('oc_order_status os', 'os.order_status_id = o.order_status_id', 'left'); // oc_order_status
        // --- Apply Search Filter ---
        if (!empty($search_query)) {
            $search_query = $this->db->escape_like_str($search_query); // Escape for LIKE queries
            $this->db->group_start(); // Start a group for OR conditions
            $this->db->or_like('o.order_id', $search_query);
            $this->db->or_like('o.invoice_no', $search_query);
            $this->db->or_like('o.firstname', $search_query);
            $this->db->or_like('o.lastname', $search_query);
            $this->db->or_like('os.name', $search_query); // Allow searching by status name too
            $this->db->group_end(); // End the group
        }
        $this->db->order_by('o.date_added', 'DESC'); // Latest orders first
        $this->db->limit($limit, $offset); // Apply pagination limits

        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_all_orders($search_query = null) {
        $this->db->from('oc_order o');
        // $this->db->join('customer c', 'c.customer_id = o.customer_id', 'left');
        $this->db->join('oc_order_status os', 'os.order_status_id = o.order_status_id', 'left');

        $this->_apply_order_search_filter($search_query); // Apply search filter

        return $this->db->count_all_results();
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