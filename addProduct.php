<?php
session_start();

$page_title="Add Product";
$css_file="style.css";


if(isset($_SESSION['email'])&& $_SESSION['type']=="admin"){

    include_once("./includes/templates/header.php");
    require_once("connection.php");
    

    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] =="POST"){
        global $con;

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
        @$newPrice= $price - ($price*($off/100));


        $stmt=$con->prepare('INSERT INTO laptops(name,description,type,image,price,offer,code,newPrice)
                            value(?,?,?,?,?,?,?,?)');
        @$stmt->execute(array($name,$desc,$type,$img_dest,$price,$off,$code,$newPrice));


    }

?>

<!-- fixed header with my logo -->
<header class="header-logo"><img src="./img/logo2.png" alt="" class="logo"></header>

<div class="row content-div">
    <div class="col-sm-3 sidenav hidden-xs">
        <!-- <h2>Logo</h2> -->
        <ul class="nav nav-pills nav-stacked">
            <li class="item"><a href="dashboard.php">Dashboard</a></li>
            <li class="item"><a href="admin.php">Products</a></li>
            <li class="item"><a href="#">Feedback</a></li>
            <li class="item active"><a href="addProduct.php">Add Product</a></li>
            <li class="item logout"><a href="logout.php">log out</a></li>
        </ul><br>
    </div><br>


<div class="addproduct container col-sm-9">
    <div class="admin-h1"><h1>Welcome <?php echo $_SESSION['name']; ?></h1><hr></div>
    <div class="form">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" class="add_form">

            <div class="content-form">
                <div class="f1">

                    <div class="mb-3 mt-3">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your name" name="name">
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="price">Price:</label>
                        <input type="number" class="form-control" id="price" placeholder="Enter price" name="price">
                    </div>

                    <div class="mb-3">
                        <label for="desc">Description:</label>
                        <input type="text" class="form-control" id="desc" placeholder="Enter description" name="desc">
                    </div>

                    <div class="mb-3">
                        <label for="img">Image:</label>
                        <input type="file" class="form-control" id="img" placeholder="Enter image" name="img">
                    </div>
                </div>

                <div class="f2">

                    <div class="mb-3">
                        <label for="type">Type:</label>
                        <input type="text" class="form-control" id="type" placeholder="Enter type" name="type">
                    </div>

                    <div class="mb-3">
                        <label for="off">Offer:</label>
                        <input type="text" class="form-control" id="off" placeholder="Enter offer" name="off">
                    </div>

                    <div class="mb-3">
                        <label for="code">Code for offer:</label>
                        <input type="text" class="form-control" id="code" placeholder="Enter Code" name="code">
                    </div>
                </div>
                </div>
            <div class="class-b"><button type="submit" class="add-btn" >Add</button></div>
        </form>
    </div>
    <!-- <a href="logout.php"><button type="submit" class="logout-btn bg-danger" >log out</button></a> -->
</div>

</div>


<?php
include_once("./includes/templates/footer.php");
}else{
    header("Refresh:0;url=register.php");
}

?>