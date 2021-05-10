<?php  
    include_once('config.php');  
    if(!($_SESSION['uid'])){  
        header("Location:index.php");  
    }  

    $getCartItems = getCartItems();

    if(isset($_POST['action']) && $_POST['action'] == 'checkout'){ 
        if($_POST['address'] != '' && $_POST['total'] > 0 ){

                $order = cartCheckout($_POST['address'],$_POST['total']);  
                if ($order) {  
                   header("location:cart.php");  
                   $_POST = array();
                  
                } else {  
                    echo "<script>alert('Something went wrong while placing order')</script>";  
                } 
        }
       
    } 
    if(isset($_POST['action']) && $_POST['action'] == 'deleteItem'){ 
        $item_id = $_POST['id']; 
        $item = deleteItem($item_id);  
    }  

    

?>  
<!DOCTYPE html>  
 <html lang="en" class="no-js">  
 <head>  
        <meta charset="UTF-8" />  
        <title>Add Product</title>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>

    </head>  
    <body>  
        <div class="container">  
            <header>  
                <button><a href="<?php echo SITE_URL.'home.php';?>">HOME</a></button>  ><h1>CART</h1>  
            </header>  
            <section>               
                <div id="container_demo" >   

                <table class="table">
			  <thead>
			    <tr>
			      <th scope="col">Category</th>
			      <th scope="col">Product</th>
                  <th scope="col">Product Image</th>
                  <th scope="col">Price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col"></th>
			      <th scope="col"></th>
			    </tr>
			  </thead>
			  <tbody>
			   <?php  echo  $getCartItems; ?>
			    
			  </tbody>
			</table>
            <form id="checkoutForm">
                <label for="address">Checkout Address:</label>
                <textarea id="address" name="address" rows="4" cols="50"></textarea><br/><br/><br/>
                <input type="button" name="checkout" id="checkout" value="Checkout"/>
            </form>

            </section>  
        </div>  
    </body>  
</html>  

<script type="text/javascript">
var total = $('#total').attr('data-attr');
if(total == 0){
    $('#checkoutForm').hide();
}
$(document).on('click','.del_item',function(){
	var attrId = $(this).attr('id');
	var data =  attrId.split("_");
	var ID = data[0];
	
    if (confirm("Are you sure to remove the item from the cart ?")) {
    	$.ajax({
           url:"cart.php",
           type:"POST",
           data:{id:ID,action:'deleteItem'},       
           success:function()
           {	
           	 alert('Item Removed Succesfully');
           	 $('#row_'+ID).remove();
             location.reload();
           }
        });			
    }

});

$(document).on('click','#checkout',function(){
    var address = $('#address').val();
    var total = $('#total').attr('data-attr');
   if(address.length > 0 && total > 0){
        $.ajax({
           url:"cart.php",
           type:"POST",
           data:{address:address,total:total,action:'checkout'},       
           success:function()
           {    
             
             location.reload();
           }
        });
   }

})

   	 
</script>