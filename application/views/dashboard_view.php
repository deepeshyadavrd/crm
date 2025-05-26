<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - CRM Dashboard</title>
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
            width: 250px;
            background-color: #333;
            color: #fff;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Pushes logout to bottom */
        }
        .sidebar .logo-section {
            text-align: center;
            margin-bottom: 30px;
            background: white;
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
        .dashboard-body {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
            <h1><?php echo $title; ?></h1>
            <div class="user-info">
                Welcome, <strong><?php echo htmlspecialchars($username); ?></strong>!
            </div>
        </div>

        <div class="dashboard-body">
            <p>This is your central hub for managing your CRM operations.</p>
            <p>Use the side menu to navigate through different sections.</p>
            <p>You can add summaries, quick links, or widgets here.</p>
        </div>
    </div>

</body>
</html>