<?php  
    include_once('config.php'); 
       
    if(isset($_POST['login']) && $_POST['login'] != ''){  
        $uname = isset($_POST['uname']) ? $_POST['uname'] : '';  
        $password = isset($_POST['password']) ? $_POST['password'] : '';  
        if($uname != '' && $password != ''){
             echo "<script>alert('Invalid Credentails')</script>"; 
             $_POST = array(); 
        }
        $user = adminLogin($uname, $password);  
        if ($user) {  
            // Registration Success  
           header("location:admin-home.php");  
        } else {  
            // Registration Failed  
            echo "<script>alert('Emailid / Password Does Not Match')</script>";  
            
        }  
    }  
?>  
<!DOCTYPE html>  
 <html lang="en" class="no-js">  
 <head>  
        <meta charset="UTF-8" />  
        <title>Admin Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    </head>  
    <body>  
        <div class="container">  
            <header>  
                <h1>ADmin Login</h1>  
            </header>  
            <section>               
                <div id="container_demo" >  
                    <a class="hiddenanchor" id="toregister"></a>  
                    <a class="hiddenanchor" id="tologin"></a>  
                    <div id="wrapper">  
                        <div id="login" class="animate form">  
                           <form name="login" method="post" action="">  
                                <h1>Log in</h1>   
                                <p>   
                                    <label for="uname" class="youmail" data-icon="e" >Username</label>  
                                    <input id="uname" name="uname" required="required"/>   
                                </p>  
                                <p>   
                                    <label for="password" class="youpasswd" data-icon="p">Password </label>  
                                    <input id="password" name="password" required="required" type="password"/>   
                                </p>  
                                <p class="login button">   
                                    <input type="submit" name="login" value="Login" />   
                                </p>  
                            </form>  
                        </div>                          
                    </div>  
                </div>    
            </section>  
        </div>  
    </body>  
</html>  