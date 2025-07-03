<div class="container mt-4">
  <h2 class="mb-4">Order Details - #<?= html_escape($order['order_id']) ?></h2>

  <!-- Customer & Order Info -->
  <div class="card mb-4">
    <div class="card-header">
      <strong>Customer Information</strong>
    </div>
    <div class="card-body">
      <p><strong>Name:</strong> <?= html_escape($order['customer_firstname'] . ' ' . $order['customer_lastname']) ?></p>
      <p><strong>Email:</strong> <?= html_escape($order['customer_email']) ?></p>
      <p><strong>Telephone:</strong> <?= html_escape($order['customer_telephone']) ?></p>
      <p><strong>Order Status:</strong> <?= html_escape($order['order_status_name']) ?></p>
      <p><strong>Date Added:</strong> <?= html_escape($order['date_added']) ?></p>
    </div>
  </div>

  <!-- Payment Address -->
  <div class="card mb-4">
    <div class="card-header">
      <strong>Payment Address</strong>
    </div>
    <div class="card-body">
      <address>
        <?= nl2br(html_escape($order['payment_firstname'] . ' ' . $order['payment_lastname'])) ?><br>
        <?= html_escape($order['payment_address_1']) ?><br>
        <?php if (!empty($order['payment_address_2'])): ?>
          <?= html_escape($order['payment_address_2']) ?><br>
        <?php endif; ?>
        <?= html_escape($order['payment_city']) ?>, <?= html_escape($order['payment_postcode']) ?><br>
        <?= html_escape($order['payment_zone']) ?><br>
        <?= html_escape($order['payment_country']) ?>
      </address>
    </div>
  </div>

  <!-- Products -->
  <div class="card mb-4">
    <div class="card-header">
      <strong>Ordered Products</strong>
    </div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Model</th>
            <th class="text-end">Quantity</th>
            <th class="text-end">Unit Price</th>
            <th class="text-end">Tax</th>
            <th class="text-end">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($order['products'] as $product): ?>
          <tr>
            <td><?= html_escape($product['name']) ?></td>
            <td><?= html_escape($product['model']) ?></td>
            <td class="text-end"><?= html_escape($product['quantity']) ?></td>
            <td class="text-end"><?= html_escape(number_format($product['price'], 2)) ?></td>
            <td class="text-end"><?= html_escape(number_format($product['tax'], 2)) ?></td>
            <td class="text-end">
              <?= html_escape(number_format(($product['price'] + $product['tax']) * $product['quantity'], 2)) ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Totals -->
  <div class="card mb-4">
    <div class="card-header">
      <strong>Order Totals</strong>
    </div>
    <div class="card-body">
      <ul class="list-group">
        <?php foreach ($order['totals'] as $total): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?= html_escape($total['title']) ?>
            <span><?= html_escape(number_format($total['value'], 2)) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <!-- Update Order Status and Upload Images -->
  <div class="card mb-4">
    <div class="card-header">
      <strong>Update Order Status & Upload Images</strong>
    </div>
    <div class="card-body">
      <form action="<?= site_url('orders/update_status_and_upload/'.$order['order_id']) ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="order_status_id" class="form-label">Order Status</label>
          <select name="order_status_id" id="order_status_id" class="form-select" required>
            <option value="">-- Select Status --</option>
            <?php foreach ($this->Order_model->get_all_statuses() as $status): ?>
              <option value="<?= $status['order_status_id'] ?>" <?php if($status['order_status_id'] == $order['order_status_id']) echo 'selected'; ?>><?= html_escape($status['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3" id="imageUploadContainer" style="display:none; margin-top:10px;">
          <label for="order_image" class="form-label">Upload Images (multiple)</label>
          <input type="file" name="order_images[]" id="order_image" class="form-control" multiple>
        </div>
        <label for="comment">Comment (optional):</label>
        <br>
        <textarea name="comment" id="comment" rows="3" cols="50"></textarea>
        <br>
        <button type="submit" class="btn btn-primary">Update Status</button>
      </form>
    </div>
  </div>

  <a href="<?= site_url('orders') ?>" class="btn btn-secondary">Back to Orders</a>
</div>


<script>
// Define which statuses require images
const statusesRequiringImage = [
    <?php
        // Replace these IDs with real IDs from your `oc_order_status` table
        $statusNames = ['Under Manufacturing', 'Under Polishing', 'Under Quality Check'];
        $statusIds = [];
        foreach ($this->Order_model->get_all_statuses() as $status) {
            if (in_array($status['name'], $statusNames)) {
                $statusIds[] = (int)$status['order_status_id'];
            }
        }
        echo implode(',', $statusIds);
    ?>
];

const statusSelect = document.getElementById('order_status_id');
const imageContainer = document.getElementById('imageUploadContainer');

function toggleImageInput() {
    const selectedId = parseInt(statusSelect.value);
    if (statusesRequiringImage.includes(selectedId)) {
        imageContainer.style.display = 'block';
    } else {
        imageContainer.style.display = 'none';
    }
}

// Initialize on page load
toggleImageInput();

// Update on change
statusSelect.addEventListener('change', toggleImageInput);
</script>

</div>
