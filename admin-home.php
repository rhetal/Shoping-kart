<?php   
    // include_once('dbFunction.php'); 
    include_once('config.php'); 
    if(isset($_POST['welcome'])){  
        // remove all session variables  
        session_unset();   
  
        // destroy the session   
        session_destroy();  
    }  
    if(!($_SESSION)){  
        header("Location:admin-login.php");  
    }  
?>  
<!DOCTYPE html>  
 <html lang="en" class="no-js">  
 
    <body>  
        <div class="container">  
            <header>  
                <h1>Welcome ADMIN  </h1>  
            </header>  
            <section>               
                <div id="container_demo" >  
                     
                    <a class="hiddenanchor" id="toregister"></a>  
                    <a class="hiddenanchor" id="tologin"></a>  
                    <div id="wrapper">  
                        <div id="login" class="animate form">  
                           <button type="button"><a href="<?php echo SITE_URL.'category.php'?>">Add Category</a></button>
                            <button type="button"><a href="<?php echo SITE_URL.'product.php'?>">Add Product</a></button>
                        </div> 
                        <form name="login" method="post" action="">  
                        <p class="login button">   
                            <input type="submit" name="welcome" value="Logout" />   
                        </p>  
                        </form> 
                    </div>  
                </div>    
            </section>  
        </div>  
    </body>  
</html>  