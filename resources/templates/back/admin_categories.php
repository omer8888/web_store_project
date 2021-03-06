<h1 class="page-header">
    Product Categories

</h1>


<div class="col-md-4">

    <form action="" method="post">

        <div class="form-group">
            <label for="category-title">Title</label>
            <input type="text" class="form-control">
        </div>

        <div class="form-group">

            <input type="submit" class="btn btn-primary" value="Add Category">
        </div>


    </form>


</div>


<div class="col-md-8">

    <table class="table">
        <thead>

        <tr>
            <th>id</th>
            <th>Title</th>
        </tr>
        </thead>


        <tbody>

        <?php get_admin_categories_view(); ?>

        </tbody>

    </table>

</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="../../../public/admin/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../../../public/admin/js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="../../../public/admin/js/plugins/morris/raphael.min.js"></script>
<script src="../../../public/admin/js/plugins/morris/morris.min.js"></script>
<script src="../../../public/admin/js/plugins/morris/morris-data.js"></script>

</body>

</html>
