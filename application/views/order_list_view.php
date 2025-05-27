<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - CRM</title>
    <style>
        /* Basic Styles (similar to your dashboard_view, but scoped to this page) */
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f4f4; color: #333; display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: #333; color: #fff; padding: 20px; box-shadow: 2px 0 5px rgba(0,0,0,0.2); display: flex; flex-direction: column; justify-content: space-between; }
        .sidebar .logo-section { text-align: center; margin-bottom: 30px; }
        .sidebar .logo-section img { max-width: 120px; height: auto; border-radius: 5px; }
        .sidebar .logo-section h2 { color: #007bff; margin-top: 10px; font-size: 1.5em; }
        .sidebar nav ul { list-style: none; padding: 0; margin: 0; flex-grow: 1; }
        .sidebar nav ul li { margin-bottom: 10px; }
        .sidebar nav ul li a { display: block; color: #fff; text-decoration: none; padding: 10px 15px; border-radius: 4px; transition: background-color 0.3s ease; }
        .sidebar nav ul li a:hover { background-color: #007bff; }
        .sidebar .logout-section { margin-top: 30px; text-align: center; }
        .sidebar .logout-section a { display: block; background-color: #dc3545; color: white; padding: 10px 15px; border-radius: 4px; text-decoration: none; transition: background-color 0.3s ease; }
        .sidebar .logout-section a:hover { background-color: #c82333; }

        .main-content { flex-grow: 1; padding: 20px; }
        .header { background-color: #fff; padding: 15px 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { margin: 0; color: #333; font-size: 1.8em; }
        .user-info { font-size: 1.1em; color: #555; }
        .page-body { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }

        /* Table Specific Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table thead th {
            background-color: #007bff;
            color: white;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table tbody td {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        table tbody tr:hover {
            background-color: #f9f9f9;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        /* Action Buttons */
        .btn {
            display: inline-block;
            padding: 8px 12px;
            margin: 2px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 0.9em;
            transition: background-color 0.2s ease;
        }
        .btn-info { background-color: #17a2b8; }
        .btn-info:hover { background-color: #138496; }
        .btn-primary { background-color: #007bff; }
        .btn-primary:hover { background-color: #0056b3; }
        .btn-success { background-color: #28a745; }
        .btn-success:hover { background-color: #218838; }
        .btn-danger { background-color: #dc3545; }
        .btn-danger:hover { background-color: #c82333; }

        /* Flash Messages */
        .flash-message { padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .flash-message.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .flash-message.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo-section">
            <img src="<?php echo base_url('assets/images/crm_logo.png'); ?>" alt="CRM Logo">
        </div>
        <nav>
            <ul>
                <li><a href="<?php echo site_url('dashboard'); ?>">Dashboard</a></li>
                <li style="background-color: #007bff;"><a href="<?php echo site_url('orders'); ?>">Orders</a></li> <li><a href="<?php echo site_url('customers'); ?>">Customers</a></li>
                <li><a href="<?php echo site_url('products'); ?>">Products</a></li>
                <li><a href="<?php echo site_url('users'); ?>">Users</a></li>
                </ul>
        </nav>
        <div class="logout-section">
            <a href="<?php echo site_url('auth/logout'); ?>">Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1><?php echo $title; ?></h1>
            <div class="user-info">
                Welcome, <strong><?php echo htmlspecialchars($this->session->userdata('username')); ?></strong>!
            </div>
        </div>

        <div class="page-body">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="flash-message success"><?php echo $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="flash-message error"><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <h2>All Orders</h2>
            <p><a href="<?php echo site_url('orders/create_order_form'); ?>" class="btn btn-primary">Create New Order</a></p>

            <?php if (!empty($orders)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Invoice No.</th>
                        <th>Customer Name</th>
                        <th>Date Added</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['invoice_no'] ? $order['invoice_no'] : 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($order['customer_firstname'] . ' ' . $order['customer_lastname']); ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($order['date_added'])); ?></td>
                        <td><?php echo htmlspecialchars($order['currency_code']); ?> <?php echo number_format($order['total'], 2); ?></td>
                        <td><?php echo htmlspecialchars($order['order_status_name']); ?></td>
                        <td>
                            <a href="<?php echo site_url('orders/view_order/' . $order['order_id']); ?>" class="btn btn-info">View Details</a>
                            <a href="<?php echo site_url('invoice/download_pdf/' . $order['order_id']); ?>" class="btn btn-primary" target="_blank">PDF Invoice</a>
                            <a href="<?php echo site_url('invoice/send_email/' . $order['order_id']); ?>" class="btn btn-success" onclick="return confirm('Send invoice to <?php echo htmlspecialchars($order['customer_firstname'] . ' ' . $order['customer_lastname']); ?>?');">Email Invoice</a>
                            </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No orders found.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>