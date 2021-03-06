<!DOCTYPE html>
<html lang="en">

<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>


<!-- Page Content -->
<div class="container">

<!-- /.row --> 

<div class="row">
    <h4 class="text-center bg-danger"> <?php  display_message();  ?> </h4> <!--error if quantity reach product stock limit-->
      <h1>Checkout</h1>

<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_cart">
        <input type="hidden" name="business" value="business_test1@ecom.com">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="upload" value="1">

    <table class="table table-striped">
        <thead>
          <tr>
           <th>Product</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Sub-total</th>
     
          </tr>
        </thead>
        <tbody>
            <?php show_cart_products(); ?>
        </tbody>
    </table>

    <?php show_paypal_button(); ?>

</form>

<!--  *********** CART TOTALS (right info box) *************-->
            
<div class="col-xs-4 pull-right ">
<h2>Summary</h2>
    <?php show_cart_summary(); ?>
    <p>5$ shipping fee per item, free shipping for 3 items or more</p>
</div><!-- CART TOTALS-->

 </div><!--Main Content-->

</div>
<!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>

 <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
