<?php

//helper

function last_id(){
    global $connection;
    return mysqli_insert_id($connection);
}

function set_message($msg){
    if (!empty($msg)){
        $_SESSION['message'] = $msg;
    }else{
        $msg = '';
    }
}

function display_message(){
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function redirect($location){
    header("Location: $location ");
}

function query($sql){
    global $connection;
    return mysqli_query($connection, $sql);
}

function confirm($result){
    global $connection;
    if(!$result){
        die("query failed with error:  ". mysqli_error($connection));
    }
}

function escape_string($string){
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}


function fetch_array($result){
    return mysqli_fetch_array($result);
}

// get product

function get_products(){
    $query = query(" SELECT * FROM PRODUCTS");
    confirm($query);
    while($row = fetch_array($query)){
        $product = <<<DELIMETER
                <div class="col-sm-4 col-lg-4 col-md-4">
                    <div class="thumbnail">
                        <a href="item.php?product_id={$row["product_id"]}"><img src="{$row["product_image"]}" alt="" width="300" height="510"></a>
                        <div class="caption">
                            <h4 class="pull-right">&#36;{$row["product_price"]}</h4>
                            <h4><a href="item.php?product_id={$row["product_id"]}">{$row["product_title"]}</a>
                            </h4>                  
                            <p>{$row["short_desc"]} <a href="item.php?product_id={$row["product_id"]}">More info</a></p>
                            <a class="btn btn-primary" href="../resources/cart.php?add={$row["product_id"]}">Add to cart</a>
                        </div>
                    </div>
                </div>
    DELIMETER;
    echo $product;
    }
}

function get_categories(){
    $query = query(" SELECT * FROM categories");
    confirm($query);
    while ($row = fetch_array($query)) {
        $category_links = <<<DELIMETER
              <a href='category.php?catagory_id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>
        DELIMETER;
        echo $category_links;
    }
}

function get_catagory_header_in_catagory_page(){
    $query = query(" SELECT * FROM categories WHERE cat_id =" . escape_string($_GET['catagory_id']) . " ");
    confirm($query);
    while ($row = fetch_array($query)) {
        $category_header = <<<DELIMETER
             <header class="jumbotron hero-spacer">
                <h1>{$row['cat_title']} Catagory</h1>
                <p>{$row['cat_desc']}</p>
                <p><a class="btn btn-primary btn-large">Call to action!</a>
                </p>
            </header>
        <hr>
        DELIMETER;
        echo $category_header;
    }
}

function get_products_in_catagory_page(){
    $query = query(" SELECT * FROM PRODUCTS WHERE product_catagory_id =" . escape_string($_GET['catagory_id']) . " ");
    confirm($query);
    while ($row = fetch_array($query)) {
        $category_products = <<<DELIMETER
            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="$row[product_image]" alt="">
                    <div class="caption">
                        <h3>$row[product_title]</h3>
                        <p>$row[short_desc]</p>
                        <p>
                            <a href="checkout.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?product_id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
        DELIMETER;
        echo $category_products;
    }
}

function get_products_in_shop_page(){
    $query = query(" SELECT * FROM PRODUCTS ");
    confirm($query);
    while ($row = fetch_array($query)) {
        $category_products = <<<DELIMETER
            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="$row[product_image]" alt="">
                    <div class="caption">
                        <h3>$row[product_title]</h3>
                        <p>$row[short_desc]</p>
                        <p>
                            <a href="../resources/cart.php?add={$row["product_id"]}" class="btn btn-primary">Buy Now!</a> <a href="item.php?product_id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
        DELIMETER;
        echo $category_products;
    }
}

function get_products_in_slider(){
    $query = query(" SELECT * FROM PRODUCTS WHERE show_on_slider =1");
    confirm($query);
    $row = fetch_array($query);
        $slider_products = <<<DELIMETER
            <div class='active item'>
            <img class="slide-image" src="{$row['wide_image']}" alt="" width="1000" height="300">
            </div>
        DELIMETER;
    echo $slider_products;

    while ($row = fetch_array($query)){
    $slider_other_products = <<<DELIMETER
            <div class='item'>
            <img class="slide-image" src="{$row['wide_image']}" alt="">
            </div>
    DELIMETER;
    echo $slider_other_products;
    }
}

function login_user(){
    if(isset($_POST['submit']))
    {
        $user_name = escape_string($_POST['user_name']);
        $user_password = escape_string($_POST['user_password']);
        $query = query("SELECT * FROM users WHERE user_name = '{$user_name}' AND user_password = '{$user_password}' ");
        confirm($query);
        if (mysqli_num_rows($query) == 0) #wrong loging info
        {
            set_message('Error: wrong pass or user name');
            redirect("login.php");
        }
        else{ #correct login info
            $_SESSION['username'] = $user_name;
            set_message("successful login, welcome back {$user_name}");
            redirect("admin");
        }
    }
}

function contact_send_messege(){
    if(isset($_POST['submit'])){
        $sent_to ="gvina.the.cat@gmail.com";
        $form_name=$_POST['name'];
        $form_email=$_POST['email'];
        $form_subject=$_POST['subject'];
        $form_message=$_POST['message'];

        $headers ="From: {$form_name} {$form_email}";
        $email_sent = mail($sent_to, $form_subject, $form_message, $headers);
        if(!$email_sent){
            set_message("Sorry - Email wasent sent");
            redirect("contact.php");
        }
        else{
            set_message("Email was sent successfully");
        }
    }
}
//********************
//*** prints orders to admin page

function get_reports(){
    $query = query("SELECT * FROM REPORTS");
    confirm($query);
    while($row = fetch_array($query)){
        $report = <<<DELIMETER
            <tr>
                <td>{$row["order_id"]}</td>
                <td>{$row["product_title"]}</td>
                <td>{$row["product_price"]}</td>
                <td>{$row["product_quantity"]}</td>
                <td>Jan 2022</td>
                <td>Completed</td>
            </tr>
    DELIMETER;
    echo $report;
    }
}

//********************
//*** prints products to admin page
function get_admin_product_view(){
    $query = query("SELECT * FROM PRODUCTS");
    confirm($query);
    while($row = fetch_array($query)){
        $product = <<<DELIMETER
            <tr>
                <td>{$row["product_id"]}</td>
                <td>{$row["product_title"]}</td>
                <td>{$row["product_catagory_id"]}</td>
                <td>{$row["product_price"]}</td>
                <td>{$row["product_quantity"]}</td>
                
            </tr>
    DELIMETER;
        echo $product;
    }
}

//********************
//*** prints categories to admin page
function get_admin_categories_view(){
    $query = query("SELECT * FROM CATEGORIES");
    confirm($query);
    while($row = fetch_array($query)){
        $cat = <<<DELIMETER
            <tr>
                <td>{$row["cat_id"]}</td>
                <td>{$row["cat_title"]}</td>
                <td>{$row["cat_desc"]}</td>               
            </tr>
    DELIMETER;
        echo $cat;
    }
}

//********************
//*** prints categories to admin page
function get_admin_users_view(){
    $query = query("SELECT * FROM USERS");
    confirm($query);
    while($row = fetch_array($query)){
        $user = <<<DELIMETER
                <tr>
                    <td>{$row["user_id"]}</td>
                    <td>{$row["user_email"]}</td>
                    <td>{$row["user_name"]}
                        <div class="action_links">
                            <a href="">Delete</a>
                            <a href="">Edit</a>
                        </div>
                    </td>
                    <td><img class="admin-user-thumbnail user_image" src="{$row["user_small_imag"]}" alt="" width="50" height="50"/></td>
                </tr>
    DELIMETER;
        echo $user;
    }
}

//********************
//*** prints orders to admin page

function get_orders(){
    $query = query("SELECT * FROM ORDERS");
    confirm($query);
    while($row = fetch_array($query)){
        $order = <<<DELIMETER
            <tr>
                <td>{$row["order_id"]}</td>
                <td>{$row["order_amount"]}</td>
                <td>{$row["order_currency"]}</td>
                <td>{$row["order_status"]}</td>
                <td>{$row["order_transaction_id"]}</td>
                <td>Jan 2022</td>
            </tr>
    DELIMETER;
        echo $order;
    }
}

function get_total_table_values(string $table_name){
    $query = query("SELECT count(*) AS TOTAL_ORDER FROM $table_name");
    confirm($query);
    echo fetch_array($query)[0];
}


