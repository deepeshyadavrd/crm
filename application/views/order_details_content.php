<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
<style>
.container { max-width: 900px; margin: 0 auto; }
.card { border: 1px solid #ddd; border-radius: 4px; }
.card-header { background: #f8f9fa; font-weight: bold; }
.table { width: 100%; border-collapse: collapse; }
.table th, .table td { padding: 8px; border-bottom: 1px solid #ddd; }
.list-group-item { display: flex; justify-content: space-between; }
:root {
            --color-primary: #2563EB;
            --color-primary-700: #1D4ED8;
            --color-secondary: #64748B;
            --color-accent: #059669;
            --color-background: #FAFAFA;
            --color-surface: #FFFFFF;
            --color-text-primary: #1E293B;
            --color-text-secondary: #64748B;
            --color-success: #10B981;
            --color-warning: #F59E0B;
            --color-error: #EF4444;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-background);
            color: var(--color-text-primary);
        }

        .bg-surface {
            background-color: var(--color-surface);
        }

        .text-primary {
            color: var(--color-primary) !important;
        }

        .text-secondary {
            color: var(--color-text-secondary) !important;
        }

        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .btn-primary:hover {
            background-color: var(--color-primary-700);
            border-color: var(--color-primary-700);
        }

        .border-secondary {
            border-color: #E2E8F0 !important;
        }

        .bg-light-blue {
            background-color: #F8FAFC;
        }

        .text-success {
            color: var(--color-success) !important;
        }

        .text-warning {
            color: var(--color-warning) !important;
        }

        .text-danger {
            color: var(--color-error) !important;
        }

        .bg-success-light {
            background-color: #D1FAE5;
        }

        .bg-warning-light {
            background-color: #FEF3C7;
        }

        .bg-danger-light {
            background-color: #FEE2E2;
        }

        .btn-scale:active {
            transform: scale(0.98);
        }

        .upload-area {
            border: 2px dashed #E2E8F0;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: var(--color-primary);
            background-color: #EFF6FF;
        }

        .progress-bar {
            background-color: var(--color-primary);
        }

        .shadow-card {
            box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
        }

        .modal-shadow {
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
        }

        .image-thumbnail {
            width: 100%;
            height: 96px;
            object-fit: cover;
        }

        .remove-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 24px;
            height: 24px;
            background-color: var(--color-error);
            color: white;
            border: none;
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-container:hover .remove-btn {
            opacity: 1;
        }
</style>
<?php print_r($order); ?>
<header class="bg-surface border-bottom border-secondary sticky-top">
<div class="container-fluid">
            <div class="row justify-content-between align-items-center py-3">
                <!-- Logo -->
                <div class="col-auto d-flex align-items-center">
                    <div class="me-3">
                        <svg class="text-primary" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6M9 9h6m-6 4h6"/>
                        </svg>
                    </div>
                    <h1 class="h5 mb-0 fw-semibold">Order Details Manager</h1>
                </div>

            </div>
        </div>
    </header>

    <!-- Breadcrumb Navigation -->
    <div class="bg-surface border-bottom border-secondary">
        <div class="container-fluid py-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-secondary">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="order_details.html" class="text-decoration-none text-secondary">Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Order <?= html_escape($order['order_id']) ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container-fluid py-4">
        <div class="row g-4">
            <!-- Left Column - Order Details -->
            <div class="col-12 col-lg-8">
                <!-- Order Header -->
                <div class="card shadow-card mb-4">
                    <div class="card-body">
                        <div class="row justify-content-between align-items-center mb-4">
                            <div class="col-12 col-sm-auto">
                                <h2 class="h4 fw-semibold mb-1">Order <?= html_escape($order['order_id']) ?></h2>
                                <p class="text-secondary mb-0">Placed on <?= html_escape($order['date_added'])?></p>
                            </div>
                            <div class="col-12 col-sm-auto mt-3 mt-sm-0">
                                <span class="badge bg-warning-light text-warning fs-6 px-3 py-2">
                                    <i class="fas fa-clock me-2"></i>
                                    <?= html_escape($order['order_status_name']) ?>
                                </span>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <div class="bg-light-blue rounded p-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-shopping-cart text-primary fs-5 me-3"></i>
                                        <div>
                                            <p class="small text-secondary mb-1">Total Items</p>
                                            <p class="h5 fw-semibold mb-0"><?= html_escape(count($order['products'])) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="bg-light-blue rounded p-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-dollar-sign text-success fs-5 me-3"></i>
                                        <div>
                                            <p class="small text-secondary mb-1">Total Amount</p>
                                            <p class="h5 fw-semibold mb-0">₹<?= html_escape($order['total']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="bg-light-blue rounded p-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-truck text-primary fs-5 me-3"></i>
                                        <div>
                                            <p class="small text-secondary mb-1">Tracking</p>
                                            <p class="h5 fw-semibold mb-0"><?= html_escape($order['order_id']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="card shadow-card mb-4">
                    <div class="card-body">
                        <h3 class="h5 fw-semibold mb-4">Customer Information</h3>
                        <div class="row g-4">
                            <div class="col-12 col-md-6">
                                <h4 class="h6 fw-medium mb-2">Billing Address</h4>
                                <div class="small text-secondary">
                                    <p class="fw-medium text-dark mb-1"><?= nl2br(html_escape($order['payment_firstname'] . ' ' . $order['payment_lastname'])) ?></p>
                                    <p class="mb-1"><?= html_escape($order['email']) ?></p>
                                    <p class="mb-1"><?= html_escape($order['telephone']) ?></p>
                                    <p class="mb-1"><?= html_escape($order['payment_address_1']) ?></p>
                                    <?php if (!empty($order['payment_address_2'])): ?>
                                        <p class="mb-1"><?= html_escape($order['payment_address_2']) ?></p>
                                    <?php endif; ?>
                                    <p class="mb-1"><?= html_escape($order['payment_city']) ?>,<?= html_escape($order['payment_zone']) ?>, <?= html_escape($order['payment_postcode']) ?></p>
                                    <p class="mb-0"><?= html_escape($order['payment_country']) ?></p>
                                    
        
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <h4 class="h6 fw-medium mb-2">Shipping Address</h4>
                                <div class="small text-secondary">
                                    <p class="fw-medium text-dark mb-1"><?= nl2br(html_escape($order['payment_firstname'] . ' ' . $order['payment_lastname'])) ?></p>
                                    <p class="mb-1"><?= html_escape($order['payment_address_1']) ?></p>
                                    <p class="mb-1"><?= html_escape($order['payment_city']) ?>,<?= html_escape($order['payment_zone']) ?>, <?= html_escape($order['payment_postcode']) ?></p>
                                    <p class="mb-0"><?= html_escape($order['payment_country']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card shadow-card mb-4">
                    <div class="card-body">
                        <h3 class="h5 fw-semibold mb-4">Order Items</h3>
                        
                        <!-- Item 1 -->
                    <?php foreach ($order['products'] as $product): ?>
                        <div class="border border-secondary rounded p-3 mb-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img class="rounded" src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Wireless Headphones" width="64" height="64" style="object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1584824486509-112e4181ff6b?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'; this.onerror=null;" />
                                </div>
                                <div class="col">
                                    <h4 class="h6 fw-medium mb-1"><?= html_escape($product['name']) ?></h4>
                                    <p class="small text-secondary mb-1">Model: <?= html_escape($product['model']) ?></p>
                                    <!-- <p class="small text-secondary mb-0">Color: Black</p> -->
                                </div>
                                <div class="col-auto text-end">
                                    <p class="fw-medium mb-1">Qty: <?= html_escape($product['quantity']) ?></p>
                                    <p class="h5 fw-semibold mb-0"><?= html_escape(number_format(($product['price'] + $product['tax']) * $product['quantity'], 2)) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
          <!-- <tr>
            <td><?= html_escape($product['name']) ?></td>
            <td><?= html_escape($product['model']) ?></td>
            <td class="text-end"><?= html_escape($product['quantity']) ?></td>
            <td class="text-end"><?= html_escape(number_format($product['price'], 2)) ?></td>
            <td class="text-end"><?= html_escape(number_format($product['tax'], 2)) ?></td>
            <td class="text-end">
              <?= html_escape(number_format(($product['price'] + $product['tax']) * $product['quantity'], 2)) ?>
            </td>
          </tr> -->
          
                        <!-- Item 2 -->
                        <!-- <div class="border border-secondary rounded p-3 mb-4">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img class="rounded" src="https://images.pexels.com/photos/788946/pexels-photo-788946.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="Smartphone Case" width="64" height="64" style="object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1584824486509-112e4181ff6b?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'; this.onerror=null;" />
                                </div>
                                <div class="col">
                                    <h4 class="h6 fw-medium mb-1">Premium Smartphone Case</h4>
                                    <p class="small text-secondary mb-1">SKU: PSC-002</p>
                                    <p class="small text-secondary mb-0">Color: Navy Blue</p>
                                </div>
                                <div class="col-auto text-end">
                                    <p class="fw-medium mb-1">Qty: 2</p>
                                    <p class="h5 fw-semibold mb-0">$199.98</p>
                                </div>
                            </div>
                        </div> -->

                        <!-- Order Total -->
                        <div class="border-top border-secondary pt-3">
                            <div class="row justify-content-end">
                                <div class="col-12 col-sm-6">
                                    <div class="d-flex justify-content-between small mb-2">
                                        <span class="text-secondary">Subtotal</span>
                                        <span>$299.97</span>
                                    </div>
                                    <div class="d-flex justify-content-between small mb-2">
                                        <span class="text-secondary">Shipping</span>
                                        <span>Free</span>
                                    </div>
                                    <div class="d-flex justify-content-between small mb-3">
                                        <span class="text-secondary">Tax</span>
                                        <span>$0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between border-top border-secondary pt-2">
                                        <span class="h5 fw-semibold">Total</span>
                                        <span class="h5 fw-semibold">$299.97</span>
                                    </div>
                                    <?php foreach ($order['totals'] as $total): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?= html_escape($total['title']) ?>
            <span><?= html_escape(number_format($total['value'], 2)) ?></span>
          </li>
        <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Timeline -->
                <div class="card shadow-card">
                    <div class="card-body">
                        <h3 class="h5 fw-semibold mb-4">Order Timeline</h3>
                        
                        <!-- Timeline Item 1 -->
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-success-light rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fas fa-check text-success small"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h4 class="h6 fw-medium mb-0">Order Placed</h4>
                                    <span class="small text-secondary">Mar 15, 2025 2:30 PM</span>
                                </div>
                                <p class="small text-secondary mb-1">Order successfully placed and payment confirmed</p>
                                <p class="text-muted" style="font-size: 0.75rem;">Updated by: System</p>
                            </div>
                        </div>

                        <!-- Timeline Item 2 -->
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-warning-light rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fas fa-clock text-warning small"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h4 class="h6 fw-medium mb-0">Processing</h4>
                                    <span class="small text-secondary">Mar 15, 2025 3:15 PM</span>
                                </div>
                                <p class="small text-secondary mb-2">Order is being prepared for shipment</p>
                                <p class="text-muted mb-2" style="font-size: 0.75rem;">Updated by: John Smith</p>
                                <!-- Associated Images -->
                                <div class="d-flex">
                                    <img class="rounded border me-2" src="https://images.pixabay.com/photo/2016/11/29/05/45/astronomy-1867616_1280.jpg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="Processing Image" width="48" height="48" style="object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1584824486509-112e4181ff6b?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'; this.onerror=null;" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Status Update Form -->
            <div class="col-12 col-lg-4">
                <!-- Status Update Form -->
                <div class="card shadow-card mb-4">
                    <div class="card-body">
                        <h3 class="h5 fw-semibold mb-4">Update Order Status</h3>
                        <form id="statusUpdateForm">
                            <!-- Status Selection -->
                            <div class="mb-3">
                                <label for="orderStatus" class="form-label fw-medium">Order Status</label>
                                <select id="orderStatus" name="orderStatus" class="form-select" required>
                                    <option value>Select Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="processing" selected>Processing</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="refunded">Refunded</option>
                                </select>
                            </div>

                            <!-- Notes -->
                            <div class="mb-3">
                                <label for="statusNotes" class="form-label fw-medium">Notes (Optional)</label>
                                <textarea id="statusNotes" name="statusNotes" rows="3" placeholder="Add any additional notes about this status update..." class="form-control" style="resize: none;"></textarea>
                            </div>

                            <!-- Image Upload Section -->
                            <div class="mb-3">
                                <label class="form-label fw-medium">Upload Images</label>
                                <div id="imageUploadArea" class="upload-area rounded p-4 text-center" style="cursor: pointer;">
                                    <div id="uploadPrompt">
                                        <i class="fas fa-cloud-upload-alt fs-1 text-secondary mb-2"></i>
                                        <p class="small text-secondary mb-1">Drag and drop images here, or click to select</p>
                                        <p class="text-muted" style="font-size: 0.75rem;">PNG, JPG up to 5MB each</p>
                                    </div>
                                    <input type="file" id="imageInput" multiple accept="image/jpeg,image/png" class="d-none" />
                                </div>
                            </div>

                            <!-- Upload Progress -->
                            <div id="uploadProgress" class="d-none mb-3">
                                <div class="progress mb-2" style="height: 8px;">
                                    <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <p class="small text-secondary">Uploading images...</p>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2">
                                <button type="submit" id="updateButton" class="btn btn-primary flex-grow-1 btn-scale">
                                    <span id="updateButtonText">Update Status</span>
                                    <i id="updateButtonSpinner" class="fas fa-spinner fa-spin ms-2 d-none"></i>
                                </button>
                                <button type="button" id="cancelButton" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Uploaded Images Gallery -->
                <div id="imageGallery" class="card shadow-card mb-4">
                    <div class="card-body">
                        <h3 class="h5 fw-semibold mb-4">Uploaded Images</h3>
                        <div id="galleryGrid" class="row g-2">
                            <!-- Sample uploaded image -->
                            <div class="col-6">
                                <div class="position-relative image-container">
                                    <img class="image-thumbnail rounded border" src="https://images.pixabay.com/photo/2017/08/10/08/47/laptop-2620118_1280.jpg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="Uploaded Image" onerror="this.src='https://images.unsplash.com/photo-1584824486509-112e4181ff6b?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'; this.onerror=null;" />
                                    <button class="remove-btn" onclick="removeImage(this)">
                                        <i class="fas fa-times" style="font-size: 0.75rem;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <p class="small text-secondary mt-3 mb-0">1 image uploaded</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow-card">
                    <div class="card-body">
                        <h3 class="h5 fw-semibold mb-4">Quick Actions</h3>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                <i class="fas fa-print me-2"></i>
                                Print Order
                            </button>
                            <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                <i class="fas fa-envelope me-2"></i>
                                Email Customer
                            </button>
                            <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                <i class="fas fa-undo me-2"></i>
                                Refund Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-shadow">
                <div class="modal-body text-center p-4">
                    <div class="bg-success-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 48px; height: 48px;">
                        <i class="fas fa-check text-success fs-4"></i>
                    </div>
                    <h3 class="h5 fw-semibold mb-2">Status Updated Successfully</h3>
                    <p class="text-secondary mb-4">The order status has been updated and the customer has been notified.</p>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<div class="container mt-4">
  <h2 class="mb-4">Order Details - #<?= html_escape($order['order_id']) ?></h2>

  <!-- Customer & Order Info -->
  <div class="card mb-4">
    <div class="card-inner">
        <div class="card-header">
          <strong>Customer Information</strong>
        </div>
        <div class="card-body">
          <p><strong>Name:</strong> <?= html_escape($order['firstname'] . ' ' . $order['lastname']) ?></p>
          <p><strong>Email:</strong> <?= html_escape($order['email']) ?></p>
          <p><strong>Telephone:</strong> <?= html_escape($order['telephone']) ?></p>
          <p><strong>Order Status:</strong> <?= html_escape($order['order_status_name']) ?></p>
          <p><strong>Date Added:</strong> <?= html_escape($order['date_added']) ?></p>
        </div>
    </div>
    <div class="card-inner">
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
  </div>

  <!-- Payment Address -->
  <!-- <div class="card mb-4">
    
  </div> -->

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
