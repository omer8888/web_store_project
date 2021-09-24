<!DOCTYPE html>
<html lang="en">

<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<?php session_destroy(); ?>  <!-- clean cart -->


<!-- Page Content -->
<div class="container">

    <br>
    <h1>Order Completed Successfully!</h1>
    <p>Thank you! Your purchase is complete and you will receive a confirmation email shortly.</p>
    <br>
    <br>
    <a class="btn btn-primary" href="index.php">Go to Home page</a>
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
