<?php
$page_title="login";
// handle request from ajax and change title page
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['title'])){
    $newtitle=$_POST['title'];
    $page_title=$newtitle;
    echo $page_title;
    exit;
}

$css_file="style.css";

include_once("./includes/templates/header.php");
require_once("./connection.php");

global $con;

if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] =="POST"){


    
    // add data to database (backend for register form)
    if(isset($_POST['register'])){

        $name=$_POST['name'];
        $email=$_POST['email'];
        $pass=$_POST['pass'];

        $hashed_pass=password_hash($pass,PASSWORD_DEFAULT);

        $stmt=$con->prepare("INSERT INTO users(name,email,password) value(?,?,?)");
        $stmt->execute(array($name,$email,$hashed_pass));
        echo "
        <script>
            toastr.success('Done Process')
        </script>";

        
    }


    // chack if the entered data in database or not (backend for login form)
    elseif(isset($_POST['login'])){

        $email=$_POST['email'];
        $pass=$_POST['pass'];
        $hashed_pass=password_hash($pass,PASSWORD_DEFAULT);

        // admins
        $admin_stmt=$con->prepare("SELECT * from admins where email=?");
        $admin_stmt->execute(array($email));
        $admin_data= $admin_stmt->fetch();
        $row_count_admin=$admin_stmt->rowCount();
    

        if($row_count_admin>0){
            @$admin_pass=password_verify($pass,$admin_data['pass']);
            if(isset($admin_pass)){
                
                @session_start();
                $_SESSION['id']=$admin_data['id'];
                $_SESSION['name']=$admin_data['name'];
                $_SESSION['email']=$admin_data['email'];
                $_SESSION['type']=$admin_data['type'];

                echo "
                <script>
                    toastr.success('Welcome to your site my admin')
                </script>";

                header("Refresh:0;url=admin.php");
            }

        }


        // users
        $stmt=$con->prepare("SELECT * from users where email=?");
        $stmt->execute(array($email));
        $data=$stmt->fetch();
        $row_count=$stmt->rowCount();


        if($row_count>0){
            @$r_pass=password_verify($pass,$data['pass']);
            if(isset($r_pass)){
                
                @session_start();
                $_SESSION['id']=$data['id'];
                $_SESSION['name']=$data['name'];
                $_SESSION['email']=$data['email'];
                $_SESSION['type']=$data['type'];


                echo "
                <script>
                    toastr.success('Done Process')
                </script>";

                header("Refresh:0;url=index.php");
            }

            
            else{
                echo "
                <script>
                    toastr.error('please get your right password')
                </script>";
            }
        }
        else{
            echo "
            <script>
            toastr.error('please get your right email')
            </script>";
        }
    }
    
}
?>

<!-- fixed header with my logo -->
<header class="header-logo"><img src="./img/logo2.png" alt="" class="logo"></header>

<!-- login form-->
<div class="login container mt-3">


    <!-- outside form -->
    <div class="login2 container ml-3">
        <img src="./img/login-illustration.5919de7.png" alt="" class="">
        <div class="h1">
            <h1 class="h1"> Don't have an account ?</h1></div>
            <div>
                <button href="register.php" class="reg-btn ml-2" name="reg-btn" method="POST">Create Account</button>
            </div>
        </div>
        
        
        <!-- heading for my form -->
        <div class="content2">
            <div class="create-h1"><h1>Login to Your Account</h1></div>
            <!-- inside form -->
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="mb-3 mt-3">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                </div>
                <div class="mb-3">
                    <label for="pass">Password:</label>
                    <input type="password" class="form-control" id="pass" placeholder="Enter password" name="pass">
                </div>
                <div class="none-input">
                    <input type="hidden" class="form-type" name="login">
                </div>
                
                <button type="submit" class="submit-btn" >Login</button>
            </form>
        </div>
    </div>
</div>


<!-- register form-->


<!-- heading for my form -->
<div class="register container mt-3">
    <div class="content">
        <div class="create-h1"><h1>Create Your Account</h1></div>

        <!-- inside form -->
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="mb-3 mt-3">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your name" name="name">
            </div>
            <div class="mb-3 mt-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="mb-3">
                <label for="pass">Password:</label>
                <input type="password" class="form-control" id="pass" placeholder="Enter password" name="pass">
            </div>
            <div class="none-input">
                <input type="hidden" class="form-type" name="register">
            </div>
    
            <button type="submit" class="submit-btn" >create account</button>
        </form>
    </div>

    <!-- outside form -->
    <div class="login1 container ml-3">
        <img src="./img/register.45273d0.svg" alt="" class="">
        <div class="h1">
            <h1 class="h1"> Already have an account ?</h1></div>
            <div>
                <button href="" class="login-btn ml-2" name="submit-btn" method="POST">Login to my Account</button>
            </div>
        </div>
        
    </div>
</div>




<?php
include_once("./includes/templates/footer.php");

?>