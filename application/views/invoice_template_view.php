<!DOCTYPE html>
<html>
<head>
    <title>Invoice #<?php echo htmlspecialchars($order['order_id']); ?></title>
    <style>
        body { font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.4; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px; line-height: 24px; color: #555; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        .invoice-box table td { padding: 10px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: right; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.top table td.title { font-size: 45px; line-height: 45px; color: #333; }
        .invoice-box table tr.information table td { padding-bottom: 40px; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; padding: 10px; }
        .invoice-box table tr.details td { padding-bottom: 20px; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; padding: 10px; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
        .rtl { direction: rtl; }
        .rtl table { text-align: right; }
        .rtl table tr td:nth-child(2) { text-align: left; }
        .company-logo { max-width: 150px; height: auto; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .strong { font-weight: bold; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://www.urbanwood.in/catalog/view/javascript/assets/image/urbanwoodlogo.png" class="company-logo" alt="Company Logo 1">
                            </td>
                            <td>
                                Invoice #: <?php echo htmlspecialchars($order['order_id']); ?><br>
                                Order Date: <?php echo date('F j, Y', strtotime($order['date_added'])); ?><br>
                                Invoice Date: <?php echo date('F j, Y'); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Urbanwood Furnitures Pvt Ltd<br>
                                Y136, Udyog Vihar Phase 1<br>
                                Secto 20, Gurgaon, Haryana<br>
                                Phone: <?php echo htmlspecialchars('9311662218'); ?><br>
                                Email: <?php echo htmlspecialchars('support@urbanwood.in'); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($order['firstname'] . ' ' . $order['lastname']); ?><br>
                                <?php echo htmlspecialchars($order['payment_address_1']); ?><br>
                                <?php echo htmlspecialchars($order['payment_address_2']); ?><br>
                                <?php echo htmlspecialchars($order['payment_city'] . ', ' . $order['payment_postcode']); ?><br>
                                <?php echo htmlspecialchars($order['payment_zone']); ?>, <?php echo htmlspecialchars($order['payment_country']); ?><br>
                                <?php echo htmlspecialchars($order['email']); ?><br>
                                <?php echo htmlspecialchars($order['telephone']); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Payment Method</td>
                <td>Check #</td>
            </tr>
            <tr class="details">
                <td><?php echo $order['payment_method']; ?></td>
                <td><?php echo htmlspecialchars($order['payment_code']); ?></td>
            </tr>

            <tr class="heading">
                <td>Item</td>
                <td class="text-right">Price</td>
            </tr>

            <?php foreach ($order['products'] as $product): ?>
            <tr class="item">
                <td><?php echo htmlspecialchars($product['name']); ?> (x<?php echo htmlspecialchars($product['quantity']); ?>)</td>
                <td class="text-right"><?php echo htmlspecialchars($order['currency_code']); ?> <?php echo number_format($product['price'] * $product['quantity'], 2); ?></td>
            </tr>
            <?php endforeach; ?>

            <?php if (!empty($order['totals'])): ?>
                <?php foreach ($order['totals'] as $total): ?>
                <tr class="total">
                    <td></td>
                    <td class="text-right">
                        <?php echo htmlspecialchars($total['title']); ?>: <?php echo htmlspecialchars($order['currency_code']); ?> <?php echo number_format($total['value'], 2); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- <tr class="total">
                <td></td>
                <td class="text-right strong">
                    Total: <?php echo htmlspecialchars($order['currency_code']); ?> <?php echo number_format($order['total'], 2); ?>
                </td>
            </tr> -->

            <tr>
                <td colspan="2" class="text-center" style="padding-top: 30px;">
                    Thank you for your business!
                </td>
            </tr>
        </table>
    </div>
</body>
</html>