<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'CRM Dashboard'; ?></title>
    <style>
        /* Basic Reset & Body Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
            color: #333;
            display: flex; /* Use flexbox for main layout */
            min-height: 100vh; /* Ensure full height */
        }

        /* Sidebar Styles */
        .sidebar {
            width: 150px;
            background-color: #333;
            color: #fff;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Pushes logout to bottom */
            position: sticky; /* Makes sidebar sticky if content overflows */
            top: 0;
            height: 100vh; /* Full viewport height */
            overflow-y: auto; /* Enable scrolling if menu items overflow */
        }
        .sidebar .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar .logo-section img {
            max-width: 120px; /* Adjust logo size */
            height: auto;
            border-radius: 5px; /* Optional: subtle rounded corners */
        }
        .sidebar .logo-section h2 {
            color: #007bff;
            margin-top: 10px;
            font-size: 1.5em;
        }
        .sidebar nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1; /* Allows nav to take available space */
        }
        .sidebar nav ul li {
            margin-bottom: 10px;
        }
        .sidebar nav ul li a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .sidebar nav ul li a:hover {
            background-color: #007bff;
        }

        /* Highlight active menu item based on current URL segment */
        <?php $current_controller = $this->uri->segment(1); ?>
        <?php if ($current_controller == 'dashboard' || $current_controller == ''): ?>
            .sidebar nav ul li:nth-child(1) a { background-color: #0056b3; } /* Assuming Dashboard is first link */
        <?php elseif ($current_controller == 'orders' || $current_controller == 'invoice'): ?>
            .sidebar nav ul li:nth-child(2) a { background-color: #0056b3; } /* Assuming Orders is second link */
        <?php elseif ($current_controller == 'customers'): ?>
            .sidebar nav ul li:nth-child(3) a { background-color: #0056b3; } /* Assuming Customers is third link */
        <?php elseif ($current_controller == 'products'): ?>
            .sidebar nav ul li:nth-child(4) a { background-color: #0056b3; } /* Assuming Products is fourth link */
        <?php elseif ($current_controller == 'users'): ?>
            .sidebar nav ul li:nth-child(5) a { background-color: #0056b3; } /* Assuming Users is fifth link */
        <?php endif; ?>


        /* Logout Section */
        .sidebar .logout-section {
            margin-top: 30px;
            text-align: center;
        }
        .sidebar .logout-section a {
            display: block;
            background-color: #dc3545; /* Red for logout */
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .sidebar .logout-section a:hover {
            background-color: #c82333;
        }

        /* Main Content Styles */
        .main-content {
            flex-grow: 1; /* Takes remaining space */
            padding: 20px;
        }
        .header {
            background-color: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 1.8em;
        }
        .user-info {
            font-size: 1.1em;
            color: #555;
        }
        .page-body {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Table Specific Styles (from order_list_view) */
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

        /* Search Form Styles (from order_list_view) */
        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            align-items: center;
        }
        .search-form input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }
        .search-form button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.2s ease;
        }
        .search-form button:hover {
            background-color: #0056b3;
        }
        /* Pagination Styling */
        .pagination {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
        }
        .pagination span {
            display: inline-block;
            padding: 8px 12px;
            margin: 0 4px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #007bff;
            background-color: #f8f9fa;
        }
        .pagination span.current-page {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
            font-weight: bold;
        }
        .pagination span.page-link:hover {
            background-color: #e2e6ea;
        }
        .pagination a.page-link {
            color: #007bff; 
        }
        .pagination a.page-link:hover {
            color: #0056b3;
        }
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
                <li><a href="<?php echo site_url('orders'); ?>">Orders</a></li>
                <li><a href="<?php echo site_url('customers'); ?>">Customers</a></li>
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
            <h1><?php echo isset($title) ? htmlspecialchars($title) : 'Page Title'; ?></h1>
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

            <?php $this->load->view($content_view); ?>
        </div>
    </div>

</body>
</html>