<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <?php get_catagory_header_in_catagory_page() ?>

        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Latest Products</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">
            <?php get_products_in_catagory_page() ?>
        </div>
        <!-- /.row -->

        <hr>


    </div>
    <!-- /.container -->


<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>

</body>

</html>
