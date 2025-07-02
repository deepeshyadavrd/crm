<div class="container mt-4">
    <h2>Order Details #<?= htmlspecialchars($order['order_id']) ?></h2>

    <h4 class="mt-3">Customer Information</h4>
    <table class="table table-bordered">
        <tr><th>Name</th><td><?= htmlspecialchars($order['firstname'].' '.$order['lastname']) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($order['email']) ?></td></tr>
        <tr><th>Telephone</th><td><?= htmlspecialchars($order['telephone']) ?></td></tr>
        <tr><th>Status</th><td><?= htmlspecialchars($order['order_status_name']) ?></td></tr>
        <tr><th>Date Added</th><td><?= htmlspecialchars($order['date_added']) ?></td></tr>
    </table>

    <h4 class="mt-4">Products</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product</th>
                <th>Model</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($order['products'] as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['model']) ?></td>
                <td><?= (int)$product['quantity'] ?></td>
                <td><?= number_format($product['price'], 2) ?></td>
                <td><?= number_format($product['total'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h4 class="mt-4">Order Totals</h4>
    <table class="table">
        <tbody>
        <?php foreach ($order['totals'] as $total): ?>
            <tr>
                <th><?= htmlspecialchars($total['title']) ?></th>
                <td><?= number_format($total['value'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
