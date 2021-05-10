<?php  
    include_once('config.php');  

    if(isset($_POST['login']) && $_POST['login'] != ''){  
        $emailid = $_POST['emailid'];  
        $password = $_POST['password'];  
        $user = Login($emailid, $password);  
        if ($user) {  
            // Registration Success  
           header("location:home.php");  
        } else {  
            // Registration Failed  
            echo "<script>alert('Emailid / Password Not Match')</script>";  
        }  
    }  
    if(isset($_POST['register'])){  
        $username = $_POST['username'];  
        $emailid = $_POST['emailid'];  
        $password = $_POST['password'];  
        $confirmPassword = $_POST['confirm_password'];  
        if($password == $confirmPassword){  
            $email = isUserExist($emailid);  
            if(!$email){  
                $register = UserRegister($username, $emailid, $password);  
                if($register){  
                     echo "<script>alert('Registration Successful')</script>";  
                     $_POST = array();
                }else{  
                    echo "<script>alert('Registration Not Successful')</script>";  
                }  
            } else {  
                echo "<script>alert('Email Already Exist')</script>";  
            }  
        } else {  
            echo "<script>alert('Password Not Match')</script>";  
          
        }  
    }  
?>  
<!DOCTYPE html>  
 <html lang="en" class="no-js">  
 <head>  
        <meta charset="UTF-8" />  
        <title>Login and Registration Form with HTML5 and CSS3</title>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

         <!-- <link rel="shortcut icon" href="../favicon.ico">   
        <link rel="stylesheet" type="text/css" href="css/demo.css" />  
        <link rel="stylesheet" type="text/css" href="css/style2.css" />  
        <link rel="stylesheet" type="text/css" href="css/animate-custom.css" />   -->
    </head>  
    <body>  
        <div class="container">  
            <header>  
                <h1>Login and Registration Form  </h1>  
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
                                    <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>  
                                    <input id="emailsignup" name="emailid" required="required" type="email" placeholder="mysupermail@mail.com"/>   
                                </p>  
                                <p>   
                                    <label for="password" class="youpasswd" data-icon="p"> Your password </label>  
                                    <input id="password" name="password" required="required" type="password" placeholder="eg. X8df!90EO" />   
                                </p>  
                                <p class="keeplogin">   
                                    <input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" />   
                                    <label for="loginkeeping">Keep me logged in</label>  
                                </p>  
                                <p class="login button">   
                                    <input type="submit" name="login" value="Login" />   
                                </p>  
                                <p class="change_link">  
                                    Not a member yet ?  
                                    <a href="#toregister" class="to_register">Join us</a>  
                                </p>  
                            </form>  
                        </div>  
  
                        <div id="register" class="animate form">  
                            <form name="login" method="post" action="">  
                                <h1> Sign up </h1>   
                                <p>   
                                    <label for="usernamesignup" class="uname" data-icon="u">Your username</label>  
                                    <input id="usernamesignup" name="username" required="required" type="text" placeholder="mysuperusername690" />  
                                </p>  
                                <p>   
                                    <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>  
                                    <input id="emailsignup" name="emailid" required="required" type="email" placeholder="mysupermail@mail.com"/>   
                                </p>  
                                <p>   
                                    <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>  
                                    <input id="passwordsignup" name="password" required="required" type="password" placeholder="eg. X8df!90EO"/>  
                                </p>  
                                <p>   
                                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>  
                                    <input id="passwordsignup_confirm" name="confirm_password" required="required" type="password" placeholder="eg. X8df!90EO"/>  
                                </p>  
                                <p class="signin button">   
                                    <input type="submit" name="register" value="Sign up"/>   
                                </p>  
                                <p class="change_link">    
                                    Already a member ?  
                                    <a href="#tologin" class="to_register"> Go and log in </a>  
                                </p>  
                            </form>  
                        </div>  
                          
                    </div>  
                </div>    
            </section>  
        </div>  
    </body>  
</html>  