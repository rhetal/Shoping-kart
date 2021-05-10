<?php   
    // include_once('dbFunction.php'); 
    include_once('config.php'); 
     if(!($_SESSION['uid'])){  
        header("Location:index.php");  
    }  
    if(isset($_POST['action']) && $_POST['action'] == 'addToCart'){
        $prod = addToCart($_POST['products']);
       /* if($prod){
            header("Location:cart.php");  
        }*/
    }
    if(isset($_POST['welcome'])){  
        // remove all session variables  
        session_unset();   
  
        // destroy the session   
        session_destroy();  
    }  
    if(!($_SESSION)){  
        header("Location:index.php");  
    }  

    $getProducts = getallProducts();
    // $cartProducts = getcartValue();
?>  
<!DOCTYPE html>  
 <html lang="en" class="no-js">  
 <head>  
        <meta charset="UTF-8" />  
        <title>HOME</title>  
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
       
    </head>  
    <body>  
        <div class="container">  
            <section>               
                <div id="container_demo" > 
                    <a class="hiddenanchor" id="toregister"></a>  
                    <a class="hiddenanchor" id="tologin"></a>  
                    <div id="wrapper">  
                        <div id="login" class="animate form">  
                           <form name="login" method="post" action="">  
                                <h1>Welcome </h1>   
                                <p>   
                                    <label for="emailid" class="uname"   > Your Name </label>  
                                   <?=$_SESSION['username']?>  
                  
                                </p>  
                                <p>   
                                    <label for="email" class="youpasswd"  > Your Email </label>  
                                    <?=$_SESSION['email']?>  
                                </p>  
                                   
                                <p class="login button">   
                                    <input type="submit" name="welcome" value="Logout" />   
                                </p>  

                                <button><a href="<?php echo SITE_URL.'cart.php';?>">CART</a></button>  >
                                   
                            </form>  
                        </div>  
                    </div>  

                
                </div> 
                <table class="table">
              <thead>
                <tr>
                  
                  <th scope="col">Category</th>
                  <th scope="col">Product</th>
                  <th scope="col">Product Image</th>
                  <th scope="col">Price</th>
                  <th scope="col"></th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
               <?php  echo  $getProducts; ?>
                
              </tbody>
            </table>   
            <form>
                <input type="button" name="addToCart" id="addToCart" value="Add to Cart"/>
                 </form>
            </section>  
        </div>  
    </body>  
</html>  

<script type="text/javascript">
var SITE_URL = "<?php echo SITE_URL;?>";
$(document).on('click','#addToCart',function(){
   var cartArray= [];
   $("input:checkbox[name=products]:checked").each(function(){
        cartArray.push($(this).val());
    });
   if (cartArray.length) {
        $.ajax({
           url:"home.php",
           type:"POST",
           data:{products:cartArray,action:'addToCart'},    
           success:function()
           {    
             window.location.replace(SITE_URL+'cart.php');
           }
        });      
        }   
    });     
</script>