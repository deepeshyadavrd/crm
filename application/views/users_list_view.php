<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; color: #333; }
        .container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #007bff; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007bff; }
        .nav a:hover { text-decoration: underline; }
        .user-info { float: right; }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-info">Logged in as: <strong><?php echo $current_user_username; ?></strong> | <a href="<?php echo site_url('auth/logout'); ?>">Logout</a></div>
        <h1><?php echo $title; ?></h1>

        <div class="nav">
            <a href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
            <a href="<?php echo site_url('users'); ?>">View Users</a>
            </div>

        <?php if (!empty($users)): ?>
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Date Added</th>
                        <th>Group ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo ($user['status'] == 1) ? 'Active' : 'Inactive'; ?></td>
                            <td><?php echo htmlspecialchars($user['date_added']); ?></td>
                            <td><?php echo htmlspecialchars($user['user_group_id']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No users found in the system.</p>
        <?php endif; ?>
    </div>
</body>
</html>