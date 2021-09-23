# Shopping Cart explained
As part of my private Ecom store project 
Iv implemented old school shopping cart feature for guest users

------ How its works? ↓ ↓ ↓
using old school SESSION
1. user clicks on (add/remove/delete)
2. redirects to cart.php?{add}?{product_id}
3. im extracting the product_id from the url using GET
4. now i can use the  product id to extract product DB info: price/quantity...

------ Basic cart function:
5.Add implemented by session[product_{product_id}]++
6. Deleting implemented by unset(session[product_{product_id}])
7. Removing implemented by --1 and unset on 0

------ More of the cart logic:
1. There is shipping logic 5$ per item, 3 items and more = free shipping
2. veryfing available product quantiny
3. presenting cart summary

Code is on my GIT
https://github.com/omer8888/web_store_project 