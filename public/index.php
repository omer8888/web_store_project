<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<!-- Page content -->
<div class="container">
    <div class="row">

        <?php include(TEMPLATE_FRONT . DS . "side_nav.php"); ?>

        <div class="col-md-9">
            <div class="row carousel-holder">
                <div class="col-md-12">
                    <?php include(TEMPLATE_FRONT . DS . "slider.php"); ?>
                </div>
            </div>
            <div class="row">
                <?php get_products() ?>
            </div> <!-- /.row end -->
        </div>
    </div>
</div>
<!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
