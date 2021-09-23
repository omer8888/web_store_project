# Shopping Cart explained
As part of my private Ecom store project <br>
Iv implemented old school shopping cart feature for guest users <br>
<br>
<h1> ------ How its works? ↓ ↓ ↓ </h1> <br>
using old school SESSION <br>
1. user clicks on (add/remove/delete) <br>
2. redirects to cart.php?{add}?{product_id} <br>
3. im extracting the product_id from the url using GET <br>
4. now i can use the  product id to extract product DB info: price/quantity... <br>
<br>
<h1>------ Basic cart function:</h1> <br>
5.Add implemented by session[product_{product_id}]++ <br>
6. Deleting implemented by unset(session[product_{product_id}]) <br>
7. Removing implemented by --1 and unset on 0 <br>
<br>
<h1>------ More of the cart logic: </h1><br>
1. There is shipping logic 5$ per item, 3 items and more = free shipping <br>
2. veryfing available product quantiny <br>
3. presenting cart summary <br>
<br>
Code is on my GIT <br>
https://github.com/omer8888/web_store_project  <br>