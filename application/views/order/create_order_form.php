<div class="container">
    <?php if (isset($status) && $status === 'success'): ?>
        <p class="success">Order created successfully! Order ID: <?php echo htmlspecialchars($order_id); ?></p>
    <?php elseif (isset($status) && $status === 'error'): ?>
        <p class="error">Error creating order: <?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <?php echo validation_errors('<ul class="validation-errors"><li>', '</li></ul>'); ?>
    <?php echo form_open('orders/process'); ?>
        <h2>Customer Details</h2>
        <div class="form-group">
            <label for="firstname">First Name <span style="color: red;">*</span></label>
            <input type="text" id="firstname" name="firstname" value="<?php echo set_value('firstname'); ?>" required>
        </div>
        <div class="form-group">
            <label for="lastname">Last Name <span style="color: red;">*</span></label>
            <input type="text" id="lastname" name="lastname" value="<?php echo set_value('lastname'); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email <span style="color: red;">*</span></label>
            <input type="email" id="email" name="email" value="<?php echo set_value('email'); ?>" required>
        </div>
        <div class="form-group">
            <label for="telephone">Telephone <span style="color: red;">*</span></label>
            <input type="tel" id="telephone" name="telephone" value="<?php echo set_value('telephone'); ?>" required>
        </div>
        <h2>Payment Address</h2>
        <div class="form-group">
            <label for="payment_firstname">First Name <span style="color: red;">*</span></label>
            <input type="text" id="payment_firstname" name="payment_firstname" value="<?php echo set_value('payment_firstname'); ?>" required>
        </div>
        <div class="form-group">
            <label for="payment_lastname">Last Name <span style="color: red;">*</span></label>
            <input type="text" id="payment_lastname" name="payment_lastname" value="<?php echo set_value('payment_lastname'); ?>" required>
        </div>
        <div class="form-group">
            <label for="payment_company">Company (Optional)</label>
            <input type="text" id="payment_company" name="payment_company" value="<?php echo set_value('payment_company'); ?>">
        </div>
        <div class="form-group">
            <label for="payment_address_1">Address 1 <span style="color: red;">*</span></label>
            <input type="text" id="payment_address_1" name="payment_address_1" value="<?php echo set_value('payment_address_1'); ?>" required>
        </div>
        <div class="form-group">
            <label for="payment_address_2">Address 2 (Optional)</label>
            <input type="text" id="payment_address_2" name="payment_address_2" value="<?php echo set_value('payment_address_2'); ?>">
        </div>
        <div class="form-group">
            <label for="payment_city">City <span style="color: red;">*</span></label>
            <input type="text" id="payment_city" name="payment_city" value="<?php echo set_value('payment_city'); ?>" required>
        </div>
        <div class="form-group">
            <label for="payment_postcode">Postcode <span style="color: red;">*</span></label>
            <input type="text" id="payment_postcode" name="payment_postcode" value="<?php echo set_value('payment_postcode'); ?>" required>
        </div>
        <div class="form-group">
            <label for="payment_country_id">Country <span style="color: red;">*</span></label>
            <select id="payment_country_id" name="payment_country_id" required>
                <option value="">-- Select Country --</option>
                <!-- <option value="99" <?php echo (set_value('payment_country_id') == 99) ? 'selected' : ''; ?>>India</option> -->
                </select>
        </div>
        <div class="form-group">
            <label for="payment_zone_id">Region / State <span style="color: red;">*</span></label>
            <select id="payment_zone_id" name="payment_zone_id" required>
                <option value="">-- Select Region / State --</option>
                <!-- <option value="1485" <?php echo (set_value('payment_zone_id') == 1485) ? 'selected' : ''; ?>>Haryana</option> -->
                </select>
        </div>
        <div class="form-group">
            <label for="payment_method">Payment Method <span style="color: red;">*</span></label>
            <select id="payment_method" name="payment_method" required>
                <option value="">-- Select Payment Method --</option>
                <option value="ccavenue" <?php echo (set_value('payment_method') == 'ccavenue') ? 'selected' : ''; ?>>ccavenue</option>
                <!-- <option value="Bank Transfer" <?php echo (set_value('payment_method') == 'Bank Transfer') ? 'selected' : ''; ?>>Bank Transfer</option> -->
                </select>
        </div>
        <input type="hidden" id="payment_code" name="payment_code" value="<?php echo set_value('payment_code'); ?>">
        <div class="checkbox-group">
            <input type="checkbox" id="shipping_same_as_payment" name="shipping_same_as_payment" <?php echo set_checkbox('shipping_same_as_payment', 'on', true); ?>>
            <label for="shipping_same_as_payment">Shipping address same as payment address</label>
        </div>
        <div id="shipping_address_section" style="display: none;">
            <h2>Shipping Address</h2>
            <div class="form-group">
                <label for="shipping_firstname">First Name <span style="color: red;">*</span></label>
                <input type="text" id="shipping_firstname" name="shipping_firstname" value="<?php echo set_value('shipping_firstname'); ?>">
            </div>
            <div class="form-group">
                <label for="shipping_lastname">Last Name <span style="color: red;">*</span></label>
                <input type="text" id="shipping_lastname" name="shipping_lastname" value="<?php echo set_value('shipping_lastname'); ?>">
            </div>
            <div class="form-group">
                <label for="shipping_company">Company (Optional)</label>
                <input type="text" id="shipping_company" name="shipping_company" value="<?php echo set_value('shipping_company'); ?>">
            </div>
            <div class="form-group">
                <label for="shipping_address_1">Address 1 <span style="color: red;">*</span></label>
                <input type="text" id="shipping_address_1" name="shipping_address_1" value="<?php echo set_value('shipping_address_1'); ?>">
            </div>
            <div class="form-group">
                <label for="shipping_address_2">Address 2 (Optional)</label>
                <input type="text" id="shipping_address_2" name="shipping_address_2" value="<?php echo set_value('shipping_address_2'); ?>">
            </div>
            <div class="form-group">
                <label for="shipping_city">City <span style="color: red;">*</span></label>
                <input type="text" id="shipping_city" name="shipping_city" value="<?php echo set_value('shipping_city'); ?>">
            </div>
            <div class="form-group">
                <label for="shipping_postcode">Postcode <span style="color: red;">*</span></label>
                <input type="text" id="shipping_postcode" name="shipping_postcode" value="<?php echo set_value('shipping_postcode'); ?>">
            </div>
            <div class="form-group">
                <label for="shipping_country_id">Country <span style="color: red;">*</span></label>
                <select id="shipping_country_id" name="shipping_country_id">
                    <option value="">-- Select Country --</option>
                    <option value="99" <?php echo (set_value('shipping_country_id') == 99) ? 'selected' : ''; ?>>India</option>
                    </select>
            </div>
            <div class="form-group">
                <label for="shipping_zone_id">Region / State <span style="color: red;">*</span></label>
                <select id="shipping_zone_id" name="shipping_zone_id">
                    <option value="">-- Select Region / State --</option>
                    <option value="1485" <?php echo (set_value('shipping_zone_id') == 1485) ? 'selected' : ''; ?>>Haryana</option>
                    </select>
            </div>
            <div class="form-group">
                <label for="shipping_method">Shipping Method <span style="color: red;">*</span></label>
                <select id="shipping_method" name="shipping_method">
                    <option value="">-- Select Shipping Method --</option>
                    <option value="Flat Rate" <?php echo (set_value('shipping_method') == 'Flat Rate') ? 'selected' : ''; ?>>Flat Rate</option>
                    <option value="Free Shipping" <?php echo (set_value('shipping_method') == 'Free Shipping') ? 'selected' : ''; ?>>Free Shipping</option>
                    </select>
            </div>
            <input type="hidden" id="shipping_code" name="shipping_code" value="<?php echo set_value('shipping_code'); ?>">
        </div>
        <h2>Products</h2>
        <div id="product_list">
            <?php
            // Pre-populate products if validation failed
            $products_data = set_value('products');
            if (empty($products_data)) {
                // Default to one empty product if no products are set (initial load)
                $products_data = [['name' => '', 'product_id' => '', 'model' => '', 'quantity' => 1, 'price' => 0.00, 'tax_per_unit' => 0.00]];
            }
            foreach ($products_data as $index => $product):
            ?>
            <div class="product-item">
                <button type="button" class="remove-product" <?php echo ($index == 0 && count($products_data) == 1) ? 'style="display:none;"' : ''; ?>>Remove</button>
                <div class="form-group">
                    <label>Product Name <span style="color: red;">*</span></label>
                    <input type="text" name="products[<?php echo $index; ?>][name]" class="product-name" value="<?php echo htmlspecialchars($product['name']); ?>" required placeholder="Type product name or ID">
                    <input type="hidden" name="products[<?php echo $index; ?>][product_id]" class="product-id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                </div>
                <div class="form-group">
                    <label>Model</label>
                    <input type="text" name="products[<?php echo $index; ?>][model]" class="product-model" value="<?php echo htmlspecialchars($product['model']); ?>">
                </div>
                <div class="form-group">
                    <label>Quantity <span style="color: red;">*</span></label>
                    <input type="number" name="products[<?php echo $index; ?>][quantity]" class="product-quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" min="1" required>
                </div>
                <div class="form-group">
                    <label>Unit Price (Excluding Tax) <span style="color: red;">*</span></label>
                    <input type="number" step="0.01" name="products[<?php echo $index; ?>][price]" class="product-price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Tax per unit (if applicable)</label>
                    <input type="number" step="0.01" name="products[<?php echo $index; ?>][tax_per_unit]" class="product-tax-per-unit" value="<?php echo htmlspecialchars($product['tax_per_unit']); ?>">
                </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="add-product">Add Another Product</button>
        <h2>Order Totals & Comments</h2>
        <div class="form-group">
            <label for="order_status_id">Order Status <span style="color: red;">*</span></label>
            <select id="order_status_id" name="order_status_id" required>
                <option value="1" <?php echo (set_value('order_status_id') == 1) ? 'selected' : ''; ?>>Pending</option>
                <option value="2" <?php echo (set_value('order_status_id') == 2) ? 'selected' : ''; ?>>Processing</option>
                <option value="5" <?php echo (set_value('order_status_id') == 5) ? 'selected' : ''; ?>>Complete</option>
                </select>
        </div>
        <div class="form-group">
            <label for="comment">Internal Comment</label>
            <textarea id="comment" name="comment" placeholder="Notes for this order"><?php echo set_value('comment'); ?></textarea>
        </div>
        <div class="form-group">
            <label for="total_override">Grand Total Override (Optional)</label>
            <input type="number" step="0.01" id="total_override" name="total_override" value="<?php echo set_value('total_override'); ?>" placeholder="Calculated automatically if left blank">
        </div>
        <button type="submit">Create Order in OpenCart</button>
    <?php echo form_close(); ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shippingSameAsPayment = document.getElementById('shipping_same_as_payment');
        const shippingAddressSection = document.getElementById('shipping_address_section');
        const paymentMethodSelect = document.getElementById('payment_method');
        const paymentCodeInput = document.getElementById('payment_code');
        const shippingMethodSelect = document.getElementById('shipping_method');
        const shippingCodeInput = document.getElementById('shipping_code');
        const productList = document.getElementById('product_list');
        const addProductBtn = document.querySelector('.add-product');
        let productIndex = productList.children.length > 0 ? Array.from(productList.children).pop().querySelector('.product-name').name.match(/products\[(\d+)\]/)[1] * 1 + 1 : 0;
        // Toggle Shipping Address Section
        shippingSameAsPayment.addEventListener('change', function() {
            if (this.checked) {
                shippingAddressSection.style.display = 'none';
                shippingAddressSection.querySelectorAll('input, select').forEach(el => el.removeAttribute('required'));
            } else {
                shippingAddressSection.style.display = 'block';
                shippingAddressSection.querySelectorAll('input, select').forEach(el => el.setAttribute('required', 'required'));
            }
        });
        // Initial state based on checkbox on page load or after validation errors
        shippingSameAsPayment.dispatchEvent(new Event('change'));
        // Set Payment Code
        paymentMethodSelect.addEventListener('change', function() {
            const methodMap = {
                'Cash on Delivery': 'cod',
                'Bank Transfer': 'bank_transfer',
            };
            paymentCodeInput.value = methodMap[this.value] || '';
        });
        // Set initial value for payment code
        paymentMethodSelect.dispatchEvent(new Event('change'));
        // Set Shipping Code
        shippingMethodSelect.addEventListener('change', function() {
            const methodMap = {
                'Flat Rate': 'flat.flat',
                'Free Shipping': 'free.free',
            };
            shippingCodeInput.value = methodMap[this.value] || '';
        });
        // Set initial value for shipping code
        shippingMethodSelect.dispatchEvent(new Event('change'));
        // Add Product Row
        addProductBtn.addEventListener('click', function() {
            const newProductItem = document.createElement('div');
            newProductItem.classList.add('product-item');
            newProductItem.innerHTML = `
                <button type="button" class="remove-product">Remove</button>
                <div class="form-group">
                    <label>Product Name <span style="color: red;">*</span></label>
                    <input type="text" name="products[${productIndex}][name]" class="product-name" required placeholder="Type product name or ID">
                    <input type="hidden" name="products[${productIndex}][product_id]" class="product-id">
                </div>
                <div class="form-group">
                    <label>Model</label>
                    <input type="text" name="products[${productIndex}][model]" class="product-model">
                </div>
                <div class="form-group">
                    <label>Quantity <span style="color: red;">*</span></label>
                    <input type="number" name="products[${productIndex}][quantity]" class="product-quantity" value="1" min="1" required>
                </div>
                <div class="form-group">
                    <label>Unit Price (Excluding Tax) <span style="color: red;">*</span></label>
                    <input type="number" step="0.01" name="products[${productIndex}][price]" class="product-price" value="0.00" required>
                </div>
                <div class="form-group">
                    <label>Tax per unit (if applicable)</label>
                    <input type="number" step="0.01" name="products[${productIndex}][tax_per_unit]" class="product-tax-per-unit" value="0.00">
                </div>
            `;
            productList.appendChild(newProductItem);
            productIndex++;
            updateRemoveButtons();
        });
        // Remove Product Row
        productList.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-product')) {
                e.target.closest('.product-item').remove();
                updateRemoveButtons();
            }
        });
        function updateRemoveButtons() {
            const removeButtons = productList.querySelectorAll('.remove-product');
            if (removeButtons.length === 1) {
                removeButtons[0].style.display = 'none';
            } else {
                removeButtons.forEach(btn => btn.style.display = 'inline-block');
            }
        }
        // Initial call to set button visibility
        updateRemoveButtons();
    });

    $(document).ready(function() {
        const countryDropdown = $('#payment_country_id');
        const zoneDropdown = $('#payment_zone_id');

        /**
         * Fetches countries from the server, populates the country dropdown,
         * and automatically selects 'India'.
         */
        function loadCountriesAndSelectIndia() {
            countryDropdown.empty(); // Clear existing options
            countryDropdown.append($('<option></option>').val('').text('-- Loading Countries --'));

            $.ajax({
                url: '<?php echo site_url("orders/get_countries_json"); ?>', // CI endpoint for countries
                type: 'GET',
                dataType: 'json',
                success: function(countries) {
                    countryDropdown.empty(); // Clear loading message
                    countryDropdown.append($('<option></option>').val('').text('-- Select Country --'));

                    let indiaCountryId = null;
                    $.each(countries, function(index, country) {
                        const option = $('<option></option>').val(country.country_id).text(country.name);
                        countryDropdown.append(option);
                        if (country.name.toLowerCase() === 'india') {
                            indiaCountryId = country.country_id;
                        }
                    });

                    // Automatically select India if found
                    if (indiaCountryId !== null) {
                        countryDropdown.val(indiaCountryId);
                    }

                    // Trigger change event to load zones for the selected country (India or default)
                    countryDropdown.trigger('change');
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error (Countries): " + status + " - " + error);
                    console.log(xhr.responseText);
                    countryDropdown.empty();
                    countryDropdown.append($('<option></option>').val('').text('-- Error Loading Countries --'));
                    alert("Error loading countries. Please try again.");
                }
            });
        }

        /**
         * Fetches zones for a given country ID and populates the zone dropdown.
         * @param {string} countryId The ID of the selected country.
         */
        function loadZones(countryId) {
            zoneDropdown.empty(); // Clear existing options
            zoneDropdown.append($('<option></option>').val('').text('-- Select State/Zone --')); // Add default option

            if (!countryId) {
                return; // No country selected, no zones to load
            }

            $.ajax({
                url: '<?php echo site_url("orders/get_zones_json"); ?>', // CI endpoint for zones
                type: 'GET',
                data: { country_id: countryId },
                dataType: 'json',
                success: function(zones) {
                    $.each(zones, function(index, zone) {
                        zoneDropdown.append($('<option></option>').val(zone.zone_id).text(zone.name));
                    });

                    // If there was a previously selected zone (e.g., after validation error),
                    // try to re-select it. This relies on CodeIgniter's set_value() being present.
                    const previousZoneValue = '<?php echo set_value('zone'); ?>';
                    if (previousZoneValue) {
                        zoneDropdown.val(previousZoneValue);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error (Zones): " + status + " - " + error);
                    console.log(xhr.responseText);
                    zoneDropdown.empty();
                    zoneDropdown.append($('<option></option>').val('').text('-- Error Loading Zones --'));
                    alert("Error fetching zones. Please try again.");
                }
            });
        }

        // Event listener for country dropdown change
        countryDropdown.on('change', function() {
            const selectedCountryId = $(this).val();
            loadZones(selectedCountryId);
        });

        // Initial call to load countries and select India when the form loads
        loadCountriesAndSelectIndia();
    });
</script>