<?php

//helper

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
                        <a href="item.php?product_id={$row["product_id"]}"><img src="{$row["product_image"]}" alt=""></a>
                        <div class="caption">
                            <h4 class="pull-right">&#36;{$row["product_price"]}</h4>
                            <h4><a href="item.php?product_id={$row["product_id"]}">{$row["product_title"]}</a>
                            </h4>
                            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                            <a class="btn btn-primary" href="cart.php?add={$row["product_id"]}">Add to cart</a>
                        </div>
                    </div>
                </div>
    DELIMETER;
    echo $product;
    }
}

function get_categories()
{
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

function get_products_in_catagory_page()
{
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
                            <a href="#####" class="btn btn-primary">Buy Now!</a> <a href="item.php?product_id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
        DELIMETER;
        echo $category_products;
    }
}

function get_products_in_shop_page()
{
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
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?product_id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
        DELIMETER;
        echo $category_products;
    }
}

function get_products_in_slider()
{
    $query = query(" SELECT * FROM PRODUCTS WHERE show_on_slider =1");
    confirm($query);
    $row = fetch_array($query);
        $slider_products = <<<DELIMETER
            <div class='active item'>
            <img class="slide-image" src="{$row['wide_image']}" alt="">
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

function login_user()
{
    if(isset($_POST['submit']))
    {
        $user_name = escape_string($_POST['user_name']);
        $user_password = escape_string($_POST['user_password']);
        $query = query("SELECT * FROM users WHERE user_name = '{$user_name}' AND user_password = '{$user_password}' ");
        confirm($query);
        if (mysqli_num_rows($query) == 0)
        {
            set_message('Error: wrong pass or user name');
            redirect("login.php");
        }
        else{
            set_message("successful login, welcome back {$user_name}");
            redirect("admin");
        }
    }
}

function conatct_send_messege(){
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
