<div class="col-lg-12">

    <h1 class="page-header">
        Users

    </h1>
    <p class="bg-success">
    </p>

    <a href="add_user.php" class="btn btn-primary">Add User</a>


    <div class="col-md-12">

        <table class="table table-hover">
            <thead>
            <tr>
                <th>Id</th>
                <th>Email</th>
                <th>Username</th>
                <th>Photo</th>
            </tr>
            </thead>
            <tbody>
                <?php get_admin_users_view(); ?>
            </tbody>
        </table> <!--End of Table-->

    </div>

</div>
    



