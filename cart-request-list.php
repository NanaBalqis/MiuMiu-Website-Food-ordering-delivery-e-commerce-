<?php if (!isset($_SESSION['cart'])): ?>
    <div class="empty">
        <p>Your cart is empty.</p>
    </div>
<?php else: ?>
    <?php foreach ($_SESSION['cart'] as $product_id => $product): ?>
        <?php if ($_SESSION['cart'][$product_id]['quantity'] == 0) {
            unset($_SESSION['cart'][$product_id]);
        } ?>
        <div class="item" data-id="<?php echo $product_id; ?>" id="item-<?php echo $product_id; ?>">
            <div class="image">
                <img src="<?php echo $product['image']; ?>" alt="">
            </div>
            <div class="name">
                <?php echo $product['name']; ?>
            </div>
            <div class="totalPrice">
                RM
                <span class="priceTotal">
                    <?php echo $product['price'] * $product['quantity']; ?>
                </span>
            </div>
            <div class="quantity">
                <span class="minus">&lt;</span>
                <span class="qty">
                    <?php echo $product['quantity']; ?>
                </span>
                <span class="plus">&gt;</span>
            </div>
        </div>
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
        <input type="hidden" name="product_qty" value="<?php echo $product['quantity']; ?>">
    <?php endforeach; ?>
<?php endif; ?>
<script>
    $('.minus').click(function () {
        var $input = $(this).parent().find('span:nth-child(2)');
        var count = parseInt($input.text()) - 1;
        count = count < 1 ? 1 : count;
        $input.text(count);
        var $item = $(this).closest('.item');
        var id = $item.data('id');
        var price = $item.find('.priceTotal').text();
        var quantity = parseInt($input.text());
        updateCart(id, quantity, price, 'minus');
        // if 0
        if (count == 0) {
            $item.remove();
        }
    });

    $('.plus').click(function () {
        var $input = $(this).parent().find('span:nth-child(2)');
        $input.text(parseInt($input.text()) + 1);
        var $item = $(this).closest('.item');
        var id = $item.data('id');
        var price = $item.find('.priceTotal').text();
        var quantity = parseInt($input.text());
        updateCart(id, quantity, price, 'plus');
    });

    function updateCart(id, quantity, price, action) {
        $.ajax({
            url: 'cart-request.php',
            method: 'POST',
            data: {
                action: 'update',
                product_id: id,
                quantity: quantity,
                price: price,
                method: action

            },
            success: function (response) {

                // update cart count
                $.ajax({
                    url: 'cart-request.php',
                    method: 'POST',
                    data: {
                        action: 'count'
                    },
                    success: function (response) {
                        $('.cart-count').text(response);
                    }
                });

                // update cart list
                listCart();
            }
        });
    }
</script>