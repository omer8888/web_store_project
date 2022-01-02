<div class="col-md-12">
    <div class="row">
        <h1 class="page-header">
            All Orders

        </h1>
    </div>

    <?php  ?>

    <div class="row">
        <table class="table table-hover">
            <thead>

            <tr>
                <th>Order id</th>
                <th>Product title</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Order Date</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php get_reports(); ?>

            </tbody>
        </table>
    </div>

