<?php
@session_start();
$page_title="site";
$css_file="style.css";

if(isset($_SESSION['email'])&& $_SESSION['type']=="user"){   

include_once("./includes/templates/header.php");
require_once("connection.php");

global $con;
$stmt= $con->prepare('SELECT * FROM laptops');
$stmt->execute();
$data_lap = $stmt->fetchAll();

if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['type'])){
        $stmtl= $con->prepare('SELECT * FROM laptops where type=?');
        $stmtl->execute(array($_GET['type']));
        $data_lap = $stmtl->fetchAll();
        
    }
    else{
        $stmt= $con->prepare('SELECT * FROM laptops');
        $stmt->execute();
        $data_lap = $stmt->fetchAll();
    }

    // search about product
    if(isset($_GET['search_input'])){
        $search_term=$_GET['search_input'];
        if(!empty($search_term)){

            $stmtn= $con->prepare('SELECT * FROM laptops where name=?');
            $stmtn->execute(array($_GET['search_input']));
            $data = $stmtn->fetchAll();
            
            foreach($data as $lap){
                if(stripos($lap['name'],$search_term)!== false){
                    $data_lap=$data;
                }
                else{
                    $stmt= $con->prepare('SELECT * FROM laptops');
                    $stmt->execute();
                    $data_lap = $stmt->fetchAll();
                }
            }
        }
        
    }
    
    
    
}

if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['order_id'])){
        global $con;
        $stmt= $con->prepare('SELECT * FROM laptops WHERE id=?');
        $stmt->execute(array($_GET['order_id']));
        $data = $stmt->fetch();

        // $qty=$_GET['qty'];
        $stmt2=$con->prepare('INSERT INTO cart(laptop_name,laptop_img,laptop_desc,total_price)
                            value(?,?,?,?)');
        @$stmt2->execute(array($data['name'],$data['image'],$data['description'],$data['newPrice']));
        echo "
        <script>
            toastr.success('added to cart')
        </script>";
    }
}
?>

<!-- header -->
<header class="site_header">
    <div class="site">

        <div><img src="img/logo2.png" alt="" class=""></div>
        <form action="#" method="GET">
            <div class="search">
                <i class="fas fa-search"></i>
                <input type="text" id="search" placeholder="   Search the product...." name="search_input">
                <!-- <button type="supmit">search</button> -->
            </div>
        </form>
        <a href="cart.php">
            <i class="shop fas fa-shopping-cart" title=""></i>
        </a>
        <a href="logout.php">
            <i class="reg fas fa-sign-in-alt" title="logout"></i>
        </a>
       
        <!-- <div class="dropdown">
            
            <i class="list-icon fas fa-list"></i>
            
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="addProduct.php">Add Product</a></li>
                <li><a class="dropdown-item" href="dashboard.php">dashboard</a></li>
            </ul>
        </div> -->
            
    </div>        
</header>
<!-- end the header  -->

<div class="row content-div">
    <div class="col-sm-3 sidenav hidden-xs">
        <!-- <h2>Logo</h2> -->
        <ul class="nav nav-pills nav-stacked">
            <!-- <li class="item"><a href="dashboard.php">Dashboard</a></li> -->
            <li class="item active"><a href="admin.php">Products</a></li>
            <li class="item"><a href="#">Feedback</a></li>
            <!-- <li class="item"><a href="addProduct.php">Add Product</a></li> -->
        </ul><br>
    </div><br>
        
        

        <div class="col-sm-9 index2">
            <div class="products container">
                <div class="type d-flex">
            <a href="index.php"><button>All laptops</button></a>
            <a href="index.php?type=lenovo"><button>Lenovo</button></a>
            <a href="index.php?type=hp"><button>HP</button></a>
            <a href="index.php?type=dell"><button>Dell</button></a>
            <a href="index.php?type=asus"><button>Asus</button></a>
            <a href="index.php?type=acer"><button>Acer</button></a>
            <a href="index.php?type=msi"><button>MSI</button></a>
            <a href="index.php?type=apple"><button>Apple</button></a>
            <a href="index.php?type=huawei"><button>Huawei</button></a>
            <a href="index.php?type=microsoft"><button>Microsoft</button></a>
        </div>
        
        <div class="row">
            <?php
            foreach ($data_lap as $lap) {?>
                <div class="ccc col-xl-4">
                    <div class="card " >
                        <div class="card-body">
                            
                            <p class="card-code bg-success">code: <?php echo $lap['code']; ?></p>
                            <p class="card-off bg-danger"><?php echo $lap['offer']; ?> OFF</p>
                            <img class="card-img-top" src="<?php echo $lap['image']; ?>" alt="" style="width:30%">
                            
                            <p class="card-name"><?php echo $lap['name']; ?></p>
                            <p class="card-desc"><?php echo $lap['description']; ?></p>
                            <div class="par">
                                <p class="card-newprice text-primary"><b>$<?php echo $lap['newPrice']; ?></b></p>
                                <p class="card-oldprice text-secondary">$<?php echo $lap['price']; ?></p>
                            </div>
                            <!-- <div class="de ">
                                <a href="deleteProduct.php?admin_id=<?php echo $lap['id']."&image_path=".$lap['image'];?>">
                                    <button class="del-btn bg-danger"><i class="del fas fa-trash"></i></button>
                                </a>
                                <a href="update.php?admin_id=<?php echo $lap['id']; ?>"><button class="edit-btn bg-info">edit</button></a>
                            </div> -->
                        </div>
                        <div class="input_2">
                        <div class="qty">
                        <form action="#" method="GET">
                            <span class="me-5">Select Qty .</span>
                            <input type="hidden" name="qt" value="<?php echo $lap['id'];?>">
                            <input type="number" name="qty" class="qty">
                            <button type="submit"></button>    
                        </form>
                        </div>
                        </div>
                        <div class="dd">
                            <form action="#" method="GET" class="btns">
                                <input type="hidden" value="<?php  echo $lap['id'];?>" name="order_id">
                                <button type="submit" class="btn btn-primary">add to cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
                
        </div>
    </div>
    
</div>



<!-- footer -->
<div class="footter">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 mt-4">
              <ul>
                <li class="head mb-5 fs-2"><b>About Bag Store</b></li>
                <li class="text-black-50 mb-3">Who we are</li>
                <li class="text-black-50 mb-3"> Store Locator</li>
                <li class="text-black-50 mb-3">Bag Store Installments</li>
                <li class="text-black-50 mb-3">Bag Store Plus</li>
              </ul>
              <div class="icon mt-5 ">
                  <i class="fab fa-facebook-f me-3 text-black-50"></i>
                  <i class="fab fa-twitter me-3 text-black-50"></i>
                  <i class="fab fa-instagram"></i>
                  <i class="fab fa-linkedin-in"></i>
              </div>
            </div>
            <div class="col-lg-2">
              <ul>
                <li class="head mb-5 fs-2 mt-4"><b>Customer Support</b></li>
                <li class="text-black-50 mb-3">Request Maintenance </li>
                <li class="text-black-50 mb-3"> Live Chat</li>
                <li class="text-black-50 mb-3">FAQs</li>
                <li class="text-black-50 mb-3">Contact us</li>
              </ul>
            </div>
            <div class="col-lg-2 mt-4"> <ul>
                <li class="head mb-5 fs-2"><b>More</b></li>
                <li class="text-black-50 mb-3">Installment offers</li>
                <li class="text-black-50 mb-3"> Terms and Conditions</li>
                <li class="text-black-50 mb-3">Privacy Policy</li>
              </ul>
            </div>
            <div class="col-lg-3 mt-4"> <ul>
              <li class="head mb-5 fs-2"><b>Download App</b></li>
              <li class="text-black-50 mb-3">App Store</li>
              <li class="text-black-50 mb-3"> Google Play  </li>
            </ul>
          </div>
            
           <div class="col-lg-2 mt-4">
              <div>
                <p class="head text-black-50 mb-5 fs-3"><b>  Stay in the know</b></p>
                <p class="text-black-50"> Subscribe to our newsletter</p>
                <input type="text" id="email-id" name="text" class="input__email" placeholder="Email Address">
              </div> 
              <div class="icon mt-5 ">
                <i class="fab fa-cc-visa"></i>
                <i class="fab fa-cc-mastercard"></i>
                <img src="imags/valu.25194da.png" alt="">
                <img src="imags/premium.2499650.png" alt="">
              </div>
            </div>
        </div>
        <h5 class="text-center text-black-50 mt-5">©2023 - Bag store | All right reserved</h5>
    </div>
</div>
<!-- =====end footer===== -->
    
    
<?php
include_once("./includes/templates/footer.php");
}
else{
    header("Refresh:0;url=register.php");
}

?>