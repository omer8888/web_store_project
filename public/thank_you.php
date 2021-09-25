<!DOCTYPE html>
<html lang="en">

<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

  <!-- clean cart -->

<?php
    if(isset($_GET['tx'])){
        $order_amount= $_GET['amt'];
        $order_currency= $_GET['cc'];
        $order_transaction_id= $_GET['tx'];
        $order_status= $_GET['st'];

        $query = query("INSERT INTO orders (order_amount,order_currency,order_transaction_id,order_status)
        VALUES ('{$order_amount}','{$order_currency}','{$order_transaction_id}','{$order_status}')");
        confirm($query);

        session_destroy();
    }
    else{
        redirect("index.php");
    }
?>


<!-- Page Content -->
<div class="container">
    <div class="col-md-3 col-sm-6 hero-feature ">
        <div class="thumbnail">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPTXTky8VCCIPZEZCIZmSL4z69BT10rX4DfA&usqp=CAU" alt="">
            <div class="caption">
                <h4>Order Completed!</h4>
                <p>
                    You were charged for <?php echo $order_amount." ".$order_currency?> <br>
                    Transcation: <?php echo $order_transaction_id ?> <br>
                    you will receive a confirmation email</p>
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
