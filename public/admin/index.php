<?php require_once("../../resources/config.php"); ?>
<?php include(TEMPLATE_BACK . "/header.php"); ?>


<?php
#This the the admin home page
//blocking un logged admin from getting this page
if (!isset($_SESSION['username'])) {
    redirect("../../public/login.php");
}
?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Dashboard <small>Statistics Overview</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!--presenting admin content after verifying url-->
        <?php
        if ($_SERVER['REQUEST_URI'] == "/ecom/public/admin/" || $_SERVER['REQUEST_URI'] == "/ecom/public/admin/index.php") {
            include(TEMPLATE_BACK . "/admin_content.php");
        }


        if (isset($_GET['orders'])) {
            include(TEMPLATE_BACK . "/admin_orders.php");
        }
        if (isset($_GET['products'])) {
            include(TEMPLATE_BACK . "/admin_products.php");
        }
        if (isset($_GET['add_product'])) {
            include(TEMPLATE_BACK . "/admin_add_product.php");
        }
        if (isset($_GET['categories'])) {
            include(TEMPLATE_BACK . "/admin_categories.php");
        }
        if (isset($_GET['users'])) {
            include(TEMPLATE_BACK . "/admin_users.php");
        }
        ?>


    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->


<?php include(TEMPLATE_BACK . "/footer.php"); ?>
