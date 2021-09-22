<?php require_once("../resources/config.php"); ?>
<?php

/* clicks Add to cart
* extracting the product id from the url using GET
* extracting product details using product id from DB
* verifing that user didnt reach product quantity limit (limit is on DB, user quantity on session)
* +1 on user product quantity
* redirect to checkout page
*/
if(isset($_GET['add'])){
    $query= query("SELECT * FROM products WHERE product_id =".escape_string($_GET['add'])." ");
    confirm($query);
    $row=fetch_array($query);
    if ($row['product_quantity'] != $_SESSION['product_'. $_GET['add']]){ #error is quantity reach product stock limit
        $_SESSION['product_'. $_GET['add']]+=1;
    }
    else{
        set_message("Sorry, limited stock,<br> only ". $row['product_quantity'] ." ". $row['product_title']." ". "available");
    }
    redirect("checkout.php");
}

/* user click Remove
* -1 on product session, free memory if quantity reach 0
*/
if(isset($_GET['remove'])){
    $_SESSION['product_'. $_GET['remove']]-=1;
    if($_SESSION['product_'. $_GET['remove']]==0)
        unset($_SESSION['product_'. $_GET['remove']]);
    redirect("checkout.php");
}

/* user click Delete
* free this product quantity session
*/
if(isset($_GET['delete'])){
    unset($_SESSION['product_'. $_GET['delete']]);
    redirect("checkout.php");
}

/* presenting user cart products
 * running on all the session array
 * looking for products
 * extracting product DB info
 * presenting on cart
 */
function show_cart_products()
{
    foreach ($_SESSION as $name => $user_product_quantity){
        if(strpos($name, 'product_')!==false && $user_product_quantity > 0){    //strpos: includes
            $product_id = explode("product_",$name)[1]; //explode: split the if from the product_X
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
                    <td><a class='btn btn-success' href="cart.php?add={$row['product_id']}"><span class='glyphicon glyphicon-plus'></span></span>Add</a></td>
                    <td><a class='btn btn-warning' href="cart.php?remove={$row['product_id']}"><span class='glyphicon glyphicon-minus'></span></span>Remove</a></td>
                    <td><a class='btn btn-danger' href="cart.php?delete={$row['product_id']}"><span class='glyphicon glyphicon-remove'></span></span>delete</a></td>          
                    </tr>
                DELIMETER;
                echo $products;
            }
    }
}

?>
