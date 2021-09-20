<?php require_once("../resources/config.php"); ?>
 <?php

if(isset($_GET['add'])){
    $query= query("SELECT * FROM products WHERE product_id =".escape_string($_GET['add'])." ");
    confirm($query);
    while($row=fetch_array($query)){
        if ($row['product_quantity'] != $_SESSION['product_'. $_GET['add']]){ #available quantity vs user cart quantity should
            $_SESSION['product_'. $_GET['add']]+=1;
        }
        else{
            set_message("Sorry, limited stock,<br> only ". $row['product_quantity'] ." ". $row['product_title']." ". "available");
        }
        redirect("checkout.php");
    }
}

if(isset($_GET['remove'])){
    $_SESSION['product_'. $_GET['remove']]-=1;
    redirect("checkout.php");
}

if(isset($_GET['delete'])){
    $_SESSION['product_'. $_GET['delete']]='0';
    redirect("checkout.php");
}

function show_cart_products()
{
    $query = query("SELECT * FROM products");
    confirm($query);
    while ($row = fetch_array($query)) {
        if(isset($_SESSION['product_'.$row['product_id']])){
            $user_quantity = $_SESSION['product_'.$row['product_id']];
            if ($user_quantity > 0){
                $sub_total = $user_quantity * $row['product_price'];
                $products = <<<DELIMETER
                    <tr>
                    <td>$row[product_title]</td>
                    <td>$row[product_price]</td>
                    <td>$user_quantity</td>
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
}






?>
