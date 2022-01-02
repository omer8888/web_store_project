<?php require_once("config.php"); ?>
<?php

/* clicks Add to cart
* extracting the product id from the url using GET
* extracting product details using product id from DB
* verifying that user didnt reach product quantity limit (limit is on DB, user quantity on session)
* +1 on user product quantity
* redirect to checkout page
*/
if(isset($_GET['add'])){
    $query= query("SELECT * FROM products WHERE product_id =".escape_string($_GET['add'])." ");
    confirm($query);
    $row=fetch_array($query);
    if ($row['product_quantity'] != $_SESSION['product_'. $_GET['add']]){ #checking if quantity reach product stock limit
        $_SESSION['product_'. $_GET['add']]+=1;
        $_SESSION['cart_total_items']+=1;
    }
    else{#error is quantity reach product stock limit
        set_message("Sorry, limited stock,<br> only ". $row['product_quantity'] ." ". $row['product_title']." ". "available");
    }
    redirect("../public/checkout.php");
}

/* user click Remove
* -1 on product session, free memory if quantity reach 0, -1 on total items,
*/
if(isset($_GET['remove'])){
    $_SESSION['product_'. $_GET['remove']]-=1; # user item quantity
    if($_SESSION['product_'. $_GET['remove']]==0) # release memory if quantity is 0
        unset($_SESSION['product_'. $_GET['remove']]);
    $_SESSION['cart_total_items']-=1;

    redirect("../public/checkout.php");
}

/* user click Delete
* free this product quantity session
*/
if(isset($_GET['delete'])){
    $_SESSION['cart_total_items']-=$_SESSION['product_'. $_GET['delete']]; #reducing the product amount from the cart total items
    unset($_SESSION['product_'. $_GET['delete']]);
    redirect("../public/checkout.php");
}

/* Presenting user cart products
 * running on all the session array
 * looking for products
 * extracting product DB info
 * calculating shipping: 5$ for item, free for 3+ items
 * presenting on cart
 */
function show_cart_products(){
    $_SESSION['cart_total_price'] = $_SESSION['cart_total_items'] = $_SESSION['cart_shipping_method'] = 0;
    $cart_item_num =1; #index for each item (for paypal api)
    foreach ($_SESSION as $name => $user_product_quantity){
        if(strpos($name, 'product_')!==false && $user_product_quantity > 0){    //strpos: includes
            $product_id = explode("product_",$name)[1]; //explode: split the id from the product_X
            $query = query("SELECT * FROM products WHERE product_id= '{$product_id}'");
            confirm($query);
            $row = fetch_array($query);
            $sub_total = $user_product_quantity * $row['product_price'];
            $products = <<<DELIMETER
                    <tr>
                    <td>$row[product_title]</td>
                    <td>$row[product_price]</td>
                    <td>$user_product_quantity</td>
                    <td>$sub_total</td>          
                    <td><a class='btn btn-success' href="../resources/cart.php?add={$row['product_id']}"><span class='glyphicon glyphicon-plus'></span></span>Add</a></td>
                    <td><a class='btn btn-warning' href="../resources/cart.php?remove={$row['product_id']}"><span class='glyphicon glyphicon-minus'></span></span>Remove</a></td>
                    <td><a class='btn btn-danger' href="../resources/cart.php?delete={$row['product_id']}"><span class='glyphicon glyphicon-remove'></span></span>delete</a></td>          
                    </tr>
                    <input type="hidden" name="item_name_{$cart_item_num}" value="{$row['product_title']}">
                    <input type="hidden" name="item_number_{$cart_item_num}" value="{$row['product_id']}">
                    <input type="hidden" name="amount_{$cart_item_num}" value="{$row['product_price']}">
                    <input type="hidden" name="quantity_{$cart_item_num}" value="{$user_product_quantity}">
                DELIMETER;
                echo $products;
            $_SESSION['cart_total_price']+=$sub_total;
            $_SESSION['cart_total_items']+= $user_product_quantity;
            $_SESSION['cart_shipping_method'] = 5* $_SESSION['cart_total_items'];
            $cart_item_num+=1;
        }
    }
    # 3 items and more for free shipping
    if ($_SESSION['cart_total_items']>=3)
        $_SESSION['cart_shipping_method']='Free Shipping';
    else {
        #updating hidden element with shipping info to paypal api
        $_SESSION['cart_total_price'] += $_SESSION['cart_shipping_method'];
        $shipping = <<<DELIMETER
                    <input type="hidden" name="item_name_{$cart_item_num}" value="shipping fee">
                    <input type="hidden" name="item_number_{$cart_item_num}" value="9">
                    <input type="hidden" name="amount_{$cart_item_num}" value="{$_SESSION['cart_shipping_method']}">
                    <input type="hidden" name="quantity_{$cart_item_num}" value="{$user_product_quantity}">
                DELIMETER;
        echo $shipping;
    }

}

/* Presenting cart summary box
 * total price ,
 * showing shipping with $ - only when its not free
 */
function show_cart_summary(){
    $shipping_price = get_cart_shipping_price();
    $cart_total_price = $_SESSION['cart_total_price'];
    $cart_totals = <<<DELIMETER
        <table class="table table-bordered" cellspacing="0">

        <tr class="cart-subtotal">
        <th>Items:</th>
        <td><span class="amount">{$_SESSION['cart_total_items']}</span></td>
        </tr>
        <tr class="shipping">
        <th>Shipping and Handling</th>
        <td>{$shipping_price}</td>
        </tr>

        <tr class="order-total">
        <th>Order Total</th>
        <td><strong><span class="amount">{$cart_total_price}&#36;</span></strong> </td>
        </tr>
    
        </tbody>

        </table>
    DELIMETER;
    echo $cart_totals;
}

/* Returning shipping price String with $ currency only for not free shipment */
function get_cart_shipping_price(){
    return ($_SESSION['cart_shipping_method'] == 'Free Shipping') ? $_SESSION['cart_shipping_method'] : ($_SESSION['cart_shipping_method'] . ' $');
}

#paypal submit button will appear only when there are items on cart
function show_paypal_button(){
    if (isset($_SESSION['cart_total_items'])&&($_SESSION['cart_total_items']>0)) {
        $paypal_button = <<<DELIMETER
                <input type="image" name="submit" border="0"
               src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
               alt="PayPal - The safer, easier way to pay online">
        DELIMETER;
        echo $paypal_button;
    }
}

/* inserting purchase info into reports table: (product purchased)
 * running on all the session array
 * looking for products
 * extracting product info from products table,
 * inserting relevant info into reports table
 */
function insert_order_products_to_reports()
{
    $last_reported_order_id = last_id(); #gets last order id inserted into orders table
    /* inserting the order purchased products info into DB reports table */
    foreach ($_SESSION as $name => $user_product_quantity) {
        if (strpos($name, 'product_') !== false && $user_product_quantity > 0) {    //strpos: includes
            $product_id = explode("product_", $name)[1]; //explode: split the id from the product_X
            $query = query("SELECT * FROM products WHERE product_id= '{$product_id}'");
            confirm($query);
            $row = fetch_array($query);

            $send_product = query("INSERT INTO reports (product_id,order_id,product_title,product_price,product_quantity)
            VALUES ('{$product_id}','{$last_reported_order_id}','{$row['product_title']}','{$row['product_price']}','{$user_product_quantity}')");

            confirm($send_product);
            unset($_SESSION[$name]); //removing product from the cart
        }
    }
}

function insert_order_info_to_orders($order_amount,$order_currency,$order_transaction_id,$order_status)
{
    /* inserting the order info into DB orders table - from the paypal returned url */

    $send_order = query("INSERT INTO orders (order_amount,order_currency,order_transaction_id,order_status)
        VALUES ('{$order_amount}','{$order_currency}','{$order_transaction_id}','{$order_status}')");
    confirm($send_order);
}

?>
