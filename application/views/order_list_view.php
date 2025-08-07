<div class="main-content">

    <form action="<?php echo site_url('orders'); ?>" method="get" class="search-form">
        <input type="text" name="search_query" placeholder="Search by Order ID, Invoice No., Customer, Status..." value="<?php echo htmlspecialchars($search_query); ?>">
        <button type="submit">Search</button>
        <?php if (!empty($search_query)): ?>
            <a href="<?php echo site_url('orders'); ?>" class="btn btn-danger">Clear Search</a>
        <?php endif; ?>
    </form>
    <div class="page-body">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="flash-message success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="flash-message error"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
        <!-- <h2>All Orders</h2> -->
        <p><a href="<?php echo site_url('orders/create'); ?>" class="btn btn-primary">Create New Order</a></p>
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
                <?php print_r($order_statuses); 
                foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($order['invoice_no'] ? $order['invoice_no'] : 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($order['firstname'] . ' ' . $order['lastname']); ?></td>
                    <td><?php echo date('Y-m-d H:i', strtotime($order['date_added'])); ?></td>
                    <td><?php echo htmlspecialchars($order['currency_code']); ?> <?php echo number_format($order['total'], 2); ?></td>
                    <td><?php echo htmlspecialchars($order['order_status_name']); ?></td>
                    <td>
                        <select class="order-status-dropdown" data-order-id="<?php echo $order['order_id']; ?>">
                            <?php foreach ($order_statuses as $status): ?>
                                <option value="<?php echo $status['order_status_id']; ?>"
                                    <?php echo ($order['status_id'] == $status['order_status_id']) ? 'selected' : ''; ?>>
                                    <?php echo $status['order_status_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <a href="<?php echo site_url('orders/view_order/' . $order['order_id']); ?>" class="btn btn-info">View Details</a>
                        <a href="<?php echo site_url('invoice/download_pdf/' . $order['order_id']); ?>" class="btn btn-primary" target="_blank">PDF Invoice</a>
                        <a href="<?php echo site_url('invoice/send_email/' . $order['order_id']); ?>" class="btn btn-success" onclick="return confirm('Send invoice to <?php echo htmlspecialchars($order['firstname'] . ' ' . $order['lastname']); ?>?');">Email Invoice</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php echo $pagination_links; ?>
        <?php else: ?>
            <p>No orders found <?php if (!empty($search_query)) echo "matching '<b>" . htmlspecialchars($search_query) . "</b>'"; ?>.</p>
        <?php endif; ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Attach a change event listener to all dropdowns with the class 'order-status-dropdown'
    $('.order-status-dropdown').on('change', function() {
        const orderId = $(this).data('order-id');
        const newStatusId = $(this).val();
        const newStatusName = $(this).find('option:selected').text();
        const dropdownElement = $(this);

        // AJAX request to update the order status
        $.ajax({
            url: '<?php echo site_url("order/update_status"); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                order_id: orderId,
                status_id: newStatusId,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            beforeSend: function() {
                // Optional: Show a loading indicator
                dropdownElement.prop('disabled', true).after('<span class="loading-spinner">...</span>');
            },
            success: function(response) {
                if (response.success) {
                    // Update the status name on the list without refreshing
                    // The dropdown already shows the new status, so we don't need to do anything here
                    // unless you have a separate text field showing the status.

                    // Show a success popup
                    alert('Order ' + orderId + ' status updated to "' + newStatusName + '".');
                } else {
                    // Revert the dropdown if the update failed
                    alert('Failed to update status: ' + response.message);
                    dropdownElement.val(dropdownElement.data('old-status-id'));
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors
                alert('An error occurred. Please try again.');
                console.error(xhr.responseText);
                // Revert the dropdown on error
                dropdownElement.val(dropdownElement.data('old-status-id'));
            },
            complete: function() {
                // Optional: Hide loading indicator and re-enable the dropdown
                $('.loading-spinner').remove();
                dropdownElement.prop('disabled', false);
            }
        });
    });

    // Store the initial status ID on page load to revert on error
    $('.order-status-dropdown').each(function() {
        $(this).data('old-status-id', $(this).val());
    });
});
</script>