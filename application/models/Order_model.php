<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->default_currency_code    = 'INR';
        $this->default_currency_value   = 1.0000;
        $this->default_customer_group_id = 1;
        $this->default_store_id         = 1;
        $this->default_store_name       = 'Urbanwood'; // Replace with actual store name
        $this->default_language_id      = 1;
        $this->default_language_code    = 'en';
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

    public function create_opencart_order($order_data) {
        $this->db->trans_start(); // Start a transaction for atomicity

        try {
            // 1. Fetch currency ID dynamically
            $query = $this->db->get_where('oc_currency', ['code' => $this->default_currency_code]);
            $currency = $query->row_array();

            if (!$currency) {
                throw new Exception("Default currency '{$this->default_currency_code}' not found in OpenCart.");
            }

            $data_oc_order = [
                'invoice_no'            => 0, // OpenCart generates this later
                'invoice_prefix'        => '', // OpenCart generates this later
                'store_id'              => $this->default_store_id,
                'store_name'            => $this->default_store_name,
                'store_url'             => base_url(), // Or fetch actual OpenCart store URL
                'customer_id'           => 0, // Assuming guest order, implement lookup if needed
                'customer_group_id'     => $this->default_customer_group_id,
                'firstname'             => $order_data['firstname'],
                'lastname'              => $order_data['lastname'],
                'email'                 => $order_data['email'],
                'telephone'             => $order_data['telephone'],
                'fax'                   => $order_data['fax'] ?? '',
                'custom_field'          => '[]', // JSON string for customer custom fields
                'payment_firstname'     => $order_data['payment_firstname'],
                'payment_lastname'      => $order_data['payment_lastname'],
                'payment_company'       => $order_data['payment_company'] ?? '',
                'payment_address_1'     => $order_data['payment_address_1'],
                'payment_address_2'     => $order_data['payment_address_2'] ?? '',
                'payment_city'          => $order_data['payment_city'],
                'payment_postcode'      => $order_data['payment_postcode'],
                'payment_country_id'    => $order_data['payment_country_id'],
                'payment_zone_id'       => $order_data['payment_zone_id'],
                'payment_method'        => $order_data['payment_method'],
                'payment_code'          => $order_data['payment_code'],
                'payment_address_format'=> '', // OpenCart usually generates this
                'payment_custom_field'  => '[]', // JSON string for payment custom fields
                'shipping_firstname'    => '', // Will be set below
                'shipping_lastname'     => '',
                'shipping_company'      => '',
                'shipping_address_1'    => '',
                'shipping_address_2'    => '',
                'shipping_city'         => '',
                'shipping_postcode'     => '',
                'shipping_country_id'   => 0,
                'shipping_zone_id'      => 0,
                'shipping_method'       => '',
                'shipping_code'         => '',
                'shipping_address_format'=> '',
                'shipping_custom_field' => '[]', // JSON string for shipping custom fields
                'comment'               => $order_data['comment'] ?? '',
                'total'                 => 0.00, // Will be updated after products
                'order_status_id'       => $order_data['order_status_id'],
                'affiliate_id'          => 0,
                'marketing_id'          => 0,
                'tracking'              => '',
                'language_id'           => $this->default_language_id,
                'currency_id'           => $currency['currency_id'],
                'currency_code'         => $currency['code'],
                'currency_value'        => $currency['value'],
                'ip'                    => $this->input->ip_address(), // CRM user's IP
                'user_agent'            => $this->input->user_agent(),
                'accept_language'       => $this->input->server('HTTP_ACCEPT_LANGUAGE'),
                'date_added'            => date('Y-m-d H:i:s'),
                'date_modified'         => date('Y-m-d H:i:s')
            ];

            // Handle shipping address
            if (isset($order_data['shipping_same_as_payment']) && $order_data['shipping_same_as_payment'] === 'on') {
                $data_oc_order['shipping_firstname'] = $order_data['payment_firstname'];
                $data_oc_order['shipping_lastname'] = $order_data['payment_lastname'];
                $data_oc_order['shipping_company'] = $order_data['payment_company'] ?? '';
                $data_oc_order['shipping_address_1'] = $order_data['payment_address_1'];
                $data_oc_order['shipping_address_2'] = $order_data['payment_address_2'] ?? '';
                $data_oc_order['shipping_city'] = $order_data['payment_city'];
                $data_oc_order['shipping_postcode'] = $order_data['payment_postcode'];
                $data_oc_order['shipping_country_id'] = $order_data['payment_country_id'];
                $data_oc_order['shipping_zone_id'] = $order_data['payment_zone_id'];
                // Shipping method/code might be empty if "same as payment" implies no separate shipping cost
                $data_oc_order['shipping_method'] = '';
                $data_oc_order['shipping_code'] = '';

            } else {
                $data_oc_order['shipping_firstname'] = $order_data['shipping_firstname'];
                $data_oc_order['shipping_lastname'] = $order_data['shipping_lastname'];
                $data_oc_order['shipping_company'] = $order_data['shipping_company'] ?? '';
                $data_oc_order['shipping_address_1'] = $order_data['shipping_address_1'];
                $data_oc_order['shipping_address_2'] = $order_data['shipping_address_2'] ?? '';
                $data_oc_order['shipping_city'] = $order_data['shipping_city'];
                $data_oc_order['shipping_postcode'] = $order_data['shipping_postcode'];
                $data_oc_order['shipping_country_id'] = $order_data['shipping_country_id'];
                $data_oc_order['shipping_zone_id'] = $order_data['shipping_zone_id'];
                $data_oc_order['shipping_method'] = $order_data['shipping_method'];
                $data_oc_order['shipping_code'] = $order_data['shipping_code'];
            }

            // Insert into oc_order
            $this->db->insert('oc_order', $data_oc_order);
            $order_id = $this->db->insert_id();

            if (!$order_id) {
                throw new Exception("Failed to insert main order data.");
            }

            // 2. Insert into oc_order_product and calculate order total
            $sub_total = 0;
            $total_tax = 0;

            foreach ($order_data['products'] as $product) {
                $product_quantity = (int)$product['quantity'];
                $product_price = (float)$product['price'];
                $product_tax_per_unit = (float)($product['tax_per_unit'] ?? 0);

                $product_total_price = $product_quantity * $product_price;
                $product_total_tax = $product_quantity * $product_tax_per_unit;

                $sub_total += $product_total_price;
                $total_tax += $product_total_tax;

                $data_oc_order_product = [
                    'order_id'      => $order_id,
                    'product_id'    => (int)($product['product_id'] ?? 0),
                    'name'          => $product['name'],
                    'model'         => $product['model'] ?? '',
                    'quantity'      => $product_quantity,
                    'price'         => $product_price,
                    'total'         => $product_total_price,
                    'tax'           => $product_total_tax,
                    'reward'        => 0 // Assuming no reward points
                ];

                $this->db->insert('oc_order_product', $data_oc_order_product);
                if ($this->db->affected_rows() === 0) {
                    throw new Exception("Failed to insert product: " . $product['name']);
                }

                // Handle product options here if needed (oc_order_option table).
                // This is more complex and would require additional form fields and logic.
            }

            // 3. Insert into oc_order_total
            // Sub-Total
            $this->db->insert('oc_order_total', [
                'order_id'   => $order_id,
                'code'       => 'sub_total',
                'title'      => 'Sub-Total',
                'value'      => $sub_total,
                'sort_order' => 1
            ]);

            // Shipping Cost (Example, define your logic or fetch from a form field)
            $shipping_cost = 0;
            if (!empty($data_oc_order['shipping_method'])) {
                // Example: If flat rate is used, add a fixed shipping cost.
                // You might need a specific input field for shipping cost in your form.
                if ($data_oc_order['shipping_code'] == 'flat.flat') {
                    $shipping_cost = 10.00; // Example flat rate
                }
                $this->db->insert('oc_order_total', [
                    'order_id'   => $order_id,
                    'code'       => 'shipping',
                    'title'      => $data_oc_order['shipping_method'],
                    'value'      => $shipping_cost,
                    'sort_order' => 3
                ]);
            }

            // Tax
            if ($total_tax > 0) {
                $this->db->insert('oc_order_total', [
                    'order_id'   => $order_id,
                    'code'       => 'tax',
                    'title'      => 'Tax',
                    'value'      => $total_tax,
                    'sort_order' => 4
                ]);
            }

            // Grand Total
            $grand_total = $sub_total + $shipping_cost + $total_tax;
            if (isset($order_data['total_override']) && is_numeric($order_data['total_override']) && $order_data['total_override'] !== '') {
                $grand_total = (float)$order_data['total_override'];
            }

            $this->db->insert('oc_order_total', [
                'order_id'   => $order_id,
                'code'       => 'total',
                'title'      => 'Total',
                'value'      => $grand_total,
                'sort_order' => 9
            ]);

            // Update the `total` field in the `oc_order` table
            $this->db->where('order_id', $order_id);
            $this->db->update('oc_order', ['total' => $grand_total]);
            if ($this->db->affected_rows() === 0) {
                throw new Exception("Failed to update order total in main order table.");
            }

            // 4. Insert into oc_order_history
            $this->db->insert('oc_order_history', [
                'order_id'        => $order_id,
                'order_status_id' => $data_oc_order['order_status_id'],
                'notify'          => 0, // Don't notify customer from CRM creation
                'comment'         => 'Order registered via CRM',
                'date_added'      => date('Y-m-d H:i:s')
            ]);

            $this->db->trans_complete(); // Complete the transaction

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Database transaction failed. Order might not be fully recorded.");
            }

            return $order_id; // Return the new order ID
        } catch (Exception $e) {
            $this->db->trans_rollback(); // Rollback on any error
            log_message('error', 'OpenCart order creation failed: ' . $e->getMessage());
            throw new Exception("Failed to create order: " . $e->getMessage());
        }
    }
    public function get_countries() {
        $this->db->select('country_id, name');
        $this->db->from('oc_country');
        $this->db->where('status', 1); // Assuming 1 means active in OpenCart
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result(); // Returns an array of objects
    }
}