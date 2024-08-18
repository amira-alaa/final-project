<?php
session_start();

$page_title="Edit Product";
$css_file="style.css";


if(isset($_SESSION['email'])&& $_SESSION['type']=="admin"){

    include_once("./includes/templates/header.php");
    require_once("connection.php");
    
    global $con;
    //$_GET['admin_id']=6;
    if($_GET['admin_id']){
        $stmt=$con->prepare('SELECT * from laptops where id=?');
        $stmt->execute(array($_GET['admin_id']));
        $data=$stmt->fetch();
    }
    

    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] =="POST"){


        $name=$_POST['name'];
        $desc=$_POST['desc'];
        $type=$_POST['type'];

        $img_name=$_FILES['img']['name'];
        $img_temp=$_FILES['img']['tmp_name'];

        $extintions_img=array("png","svg","jpg","jpeg","webp");
        @$extintion_img=strtolower(end(explode(".",$img_name)));

        if(in_array($extintion_img,$extintions_img)){
            $final_img= $name. "_" . rand(0,1000) . "." . $extintion_img;
            $img_dest='img/laps/'.$final_img;

            move_uploaded_file($img_temp,$img_dest);
        }


        $price=$_POST['price'];
        $off=$_POST['off'];
        $code=$_POST['code'];
        $newPrice= (float)$price - ((float)$price*((float)$off/100));

        $lap=array($name,$desc,$type,$img_name,$img_temp,$img_dest,$price,$off,$code,$newPrice);

        $stmt=$con->prepare('UPDATE laptops SET name=?,description=?,type=?,image=?,price=?,offer=?,code=?,newPrice=? WHERE id=?');
        $stmt->execute(array($name,$desc,$type,$img_dest,$price,$off,$code,$newPrice,$_GET['admin_id']));
        echo "
    <script>
        toastr.success('Done Process')
    </script>";
    header("Refresh:2;url=admin.php");


    }

?>

<!-- fixed header with my logo -->
<header class="header-logo"><img src="./img/logo2.png" alt="" class="logo"></header>

<div class="addproduct container">
    <div class="admin-h1"><h1>Welcome <?php echo $_SESSION['name']; ?> </h1><hr></div>
    <div class="form">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" class="add_form">

            <div class="content-form">
                <div class="f1">

                    <div class="mb-3 mt-3">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" value="<?php echo $data['name'];?>" name="name">
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="price">Price:</label>
                        <input type="number" class="form-control" id="price" value="<?php echo $data['price'];?>" name="price">
                    </div>

                    <div class="mb-3">
                        <label for="desc">Description:</label>
                        <input type="text" class="form-control" id="desc" value="<?php echo $data['description'];?>" name="desc">
                    </div>

                    <div class="mb-3">
                        <label for="img">Image:</label>
                        <input type="file" class="form-control" id="img" value="<?php echo $data['image'];?>" name="img">
                    </div>
                </div>

                <div class="f2">

                    <div class="mb-3">
                        <label for="type">Type:</label>
                        <input type="text" class="form-control" id="type" value="<?php echo $data['type'];?>" name="type">
                    </div>

                    <div class="mb-3">
                        <label for="off">Offer:</label>
                        <input type="text" class="form-control" id="off" value="<?php echo $data['offer'];?>" name="off">
                    </div>

                    <div class="mb-3">
                        <label for="code">Code for offer:</label>
                        <input type="text" class="form-control" id="code" value="<?php echo $data['code'];?>" name="code">
                    </div>
                </div>
                </div>
            <div class="class-b"><button type="submit" class="add-btn" >Edit</button></div>
        </form>
    </div>
</div>




<?php
include_once("./includes/templates/footer.php");
}else{
    header("Refresh:0;url=register.php");
}

?>