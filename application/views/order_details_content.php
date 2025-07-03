<div class="container mt-4">
    <h2>Order Details #<?php echo $order['order_id']; ?></h2>

<!-- Customer Information -->
<h3>Customer</h3>
<p>
    <?php echo htmlspecialchars($order['customer_firstname'] . ' ' . $order['customer_lastname']); ?><br>
    Email: <?php echo htmlspecialchars($order['customer_email']); ?><br>
    Phone: <?php echo htmlspecialchars($order['customer_telephone']); ?>
</p>

<!-- Current Order Status -->
<h3>Status</h3>
<p><strong><?php echo htmlspecialchars($order['order_status_name']); ?></strong></p>

<!-- Products -->
<h3>Products</h3>
<table border="1" cellpadding="6" cellspacing="0">
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
            <td><?php echo htmlspecialchars($product['name']); ?></td>
            <td><?php echo htmlspecialchars($product['model']); ?></td>
            <td><?php echo (int)$product['quantity']; ?></td>
            <td><?php echo number_format($product['price'], 2); ?></td>
            <td><?php echo number_format($product['total'], 2); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- Totals -->
<h3>Order Totals</h3>
<ul>
<?php foreach ($order['totals'] as $total): ?>
    <li><?php echo htmlspecialchars($total['title']); ?>: <?php echo number_format($total['value'], 2); ?></li>
<?php endforeach; ?>
</ul>

<!-- Flash Messages -->
<?php if($this->session->flashdata('success')): ?>
    <div style="color: green;"><?php echo $this->session->flashdata('success'); ?></div>
<?php endif; ?>
<?php if($this->session->flashdata('error')): ?>
    <div style="color: red;"><?php echo $this->session->flashdata('error'); ?></div>
<?php endif; ?>

<hr>

<!-- Form to Update Status -->
<h3>Update Order Status</h3>
<form method="post" action="<?php echo site_url('orders/update_status/' . $order['order_id']); ?>">
    <label for="order_status_id">Select New Status:</label>
    <select name="order_status_id" id="order_status_id" required>
        <?php foreach ($this->Order_model->get_all_statuses() as $status): ?>
            <option value="<?php echo $status['order_status_id']; ?>" <?php if($status['order_status_id'] == $order['order_status_id']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($status['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>
    <label for="comment">Comment (optional):</label>
    <br>
    <textarea name="comment" id="comment" rows="3" cols="50"></textarea>
    <br>
    <button type="submit">Update Status</button>
</form>

<hr>

<!-- Form to Upload Image for a Specific Status -->
<h3>Upload Image (for specific status)</h3>
<form method="post" enctype="multipart/form-data" action="<?php echo site_url('orders/upload_images/' . $order['order_id']); ?>">
    <label for="order_status_id">Status this image belongs to:</label>
    <select name="order_status_id" id="order_status_id" required>
        <?php foreach ($this->Order_model->get_all_statuses() as $status): ?>
            <option value="<?php echo $status['order_status_id']; ?>">
                <?php echo htmlspecialchars($status['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>
    <label for="order_image">Select Image:</label>
    <input type="file" name="order_image" id="order_image" required>
    <br>
    <button type="submit">Upload Image</button>
</form>
</div>
