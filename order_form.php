<?php
@session_start();
$page_title="site";
$css_file="style.css";

include_once("./includes/templates/header.php");
require_once("connection.php");


global $con;
$stmt= $con->prepare('SELECT * FROM cart');
$stmt->execute();
$data = $stmt->fetchAll();

if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] =="POST"){

    $user_name=$_POST['name'];
    $phone=$_POST['phone'];
    $govern=$_POST['govern'];
    $area=$_POST['area'];
    foreach($data as $laptop){
    global $con;
    $stmt=$con->prepare('INSERT INTO dashboard(user_name,phone,governorate,area,product,quantity,total_price)
                        value(?,?,?,?,?,?,?)');
    @$stmt->execute(array($user_name,$phone,$govern,$area,$laptop["laptop_name"],$laptop["quantity"],$laptop["total_price"]));
    }

    echo "
    <script>
        toastr.success('Done Process')
    </script>";
    header("Refresh:2;url=index.php");


}





?>

<header class="header-logo"><img src="./img/logo2.png" alt="" class="logo"></header>



<div class="checkout">
    <div class="text">
        <h1>CHECKOUT</h1>
    </div>
    <div class="body">
        <div class="row flex-nowrap">
            <div class="col-7">
                <div class="order">
                <form class="row g-3" method='POST'>
                    <div class="col-md-12 mb-4">
                      <label for="inputEmail4" class="form-label">Full Name</label>
                      <input type="Text" class="form-control" id="inputEmail4"  name="name">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="inputEmail4" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputEmail4">
                      </div>
                    <div class="col-md-12 mb-4">
                      <label for="inputPassword4" class="form-label">Phone Number</label>
                      <input type="phone" class="form-control" id="inputPassword4"  name="phone">
                    </div>
                    <div class="col-md-6 mb-4">
                      <label for="inputCity" class="form-label">Governorate</label>
                      <input type="text" class="form-control" id="inputCity"  name="govern">
                    </div>
                    <div class="col-md-6 mb-4">
                      <label for="inputCity" class="form-label">Area</label>
                      <input type="text" class="form-control" id="inputCity"  name="area">
                    </div>
                    
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </form>
        </div>
    </div>
            <div class="col-4">
              <div class="payment">
                <h2>Payment summary</h2>
                <div class="total_price d-flex justify-content-between">
                    <div><p>Subtotal</p></div>
                    <div>
                        <span>10000</span>
                        <span>EGP</span>
                    </div>
                </div>
                <div class="total_price d-flex justify-content-between">
                    <div><p>Shipping Fees</p></div>
                    <div>
                        <span>To be calculated</span>
                    </div>
                </div>
                <div class="line2"></div>
                <div class="total_price d-flex justify-content-between">
                    <div><p>Total VAT Included</p></div>
                    <div>
                        <span class="span1">10000</span>
                        <span class="span2">EGP</span>
                    </div>
                </div>
              </div>
              <div class="product">
                <h2>Product summary</h2>
                <?php foreach($data as $lap){?>
                    <div class="laptop d-flex">
                        <div class="img">
                            <img src="<?php echo $lap["laptop_img"];?>" alt="">
                        </div>
                            <div class="laptop_desc">
                                <p>
                                <?php echo $lap["laptop_desc"];?>
                                </p>
                                <div class="part-2 d-flex">
                                    <div class="Qty" >
                                        <span class="me-1">Qty .</span>
                                        <span><?php echo $lap["quantity"];?></span>
                                    </div>
                                    <div class="price">
                                        <span class="span1"><?php echo $lap["total_price"];?></span>
                                        <span class="span2">EGP</span>
                                    </div>
                                </div>
                            </div>
                    </div>
                <div class="line1"></div>
                <?php }?>
              </div>
            </div>
        </div>
    </div>
</div>






<?php
include_once("./includes/templates/footer.php");

?>