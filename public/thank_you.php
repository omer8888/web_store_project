<!DOCTYPE html>
<html lang="en">

<?php require_once("../resources/config.php"); ?>

<?php
                                     #This is the thank you page the user sees after finishing purchasing using paypal
    if(isset($_GET['tx'])){          /*only if transaction exists (get the paypal info from the url)*/
        $order_amount = $_GET['amt'];
        $order_currency = $_GET['cc'];
        $order_transaction_id = $_GET['tx'];
        $order_status = $_GET['st'];
        insert_order_info_to_orders($order_amount,$order_currency,$order_transaction_id,$order_status); // inserting this order info into orders table,
        insert_order_products_to_reports();   // inserting product purchased into reports table

        session_destroy(); //cleaning cart
    }
    else{
        #redirect("index.php"); //redirect home in case no transaction
    }
?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>


<!-- Thank you page Content -->
<div class="container">
    <div class="col-md-3 col-sm-6 hero-feature ">
        <div class="thumbnail">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPTXTky8VCCIPZEZCIZmSL4z69BT10rX4DfA&usqp=CAU" alt="">
            <div class="caption">
                <h4>Order Completed!</h4>
                    Purchase price: <?php echo $order_amount." ".$order_currency?> <br>
                    Transaction id: <?php echo $order_transaction_id ?> <br><br>
                    <a class="btn btn-primary" href="index.php">Go to Home page</a>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
</div>
<!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
