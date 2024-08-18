<?php
@session_start();
$page_title="site";
$css_file="style.css";

include_once("./includes/templates/header.php");
require_once("connection.php");


global $con;
$stmtm= $con->prepare('SELECT * FROM cart');
$stmtm->execute();
$data = $stmtm->fetchAll();

if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] =="POST"){
    if(isset($_POST['qty'])){
        $id = $_POST['qt'];
        $qty=$_POST['qty'];
        $stmtc=$con->prepare("UPDATE cart SET quantity=? where id=?");
        $stmtc->execute(array($qty,$id));
        // echo "error";
        //$data['total_price']=$data['total_price']* $qty;
        // $stmtm= $con->prepare('SELECT * FROM cart where id=?');
        // $stmtm->execute(array($id));
        // $dataa = $stmtm->fetchAll();

        // $stmtn=$con->prepare("UPDATE cart SET total_price=? where id=?");
        // $stmtn->execute(array($dataa['total_price'] * $qty ,$id));

        echo "
        <script>
        toastr.success('added to cart')
        </script>";
    }
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        $stmt=$con->prepare("DELETE FROM cart WHERE id=?");
        $stmt->execute(array($id));
        header("Refresh:0;url=cart.php");
    }

}

?>






<header class="site_header">
    <div class="site">
        <div><img src="img/logo2.png" alt="" class=""></div>
        <div class="search">
            <i class="fas fa-search"></i>
            <input type="search" id="search" class="" placeholder="   Search the product....">
        </div>
        <a href="cart.php">
            <i class="shop fas fa-shopping-cart" title=""></i>
        </a>
        <a href="register.php">
            <i class="reg fas fa-sign-in-alt" title="signin & register"></i>
        </a>

    </div>        
</header>

<div class="cart">
    <div class="text"><h1>MY CART</h1></div>
    <div class="body">
        <div class="row flex-nowrap">
            <div class="col-7">
            <?php foreach($data as $lap){?>
            <div class="product d-flex">
                <div class="laptop d-flex">
                    <div class="img">
                        <img src="<?php echo $lap["laptop_img"];?>" alt="">
                    </div>
                        <div class="laptop_desc">
                            <div class="part-1 d-flex">
                                <p>
                                <?php echo $lap["laptop_desc"];?>
                                </p>
                                <div class="delete">
                                    <form action="" method="POST">
                                        <input type="hidden" name="id" value=<?php echo $lap['id'];?>>
                                        <button class="btn" type="submit" ><i class="del fas fa-trash"></i></button>
                                        
                                    </form>
                                </div>
                            </div>
                            <div class="part-2">
                                <!-- <div class="mt-3" >
                                    <form action="#" method="POST">
                                        <span class="me-5">Select Qty .</span>
                                        <input type="hidden" name="qt" value="<?php echo $lap['id'];?>">
                                        <input type="number" name="qty" class="qty">
                                        <button type="submit"></button>    
                                    </form>
                                </div> -->
                            
                                <div class="price mt-3">
                                    <span class="span1"><?php echo $lap['total_price']*$_POST['qty'];?></span>
                                    <span class="span2">EGP</span>
                                </div>
                                
                            </div>
                        </div>
                </div>
            </div>
            <div class="line1"></div>
            <?php }?>
        </div>
            <div class="payment col-4">
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
                <div class="btn">
                    <a href="order_form.php"><button type="button" class="btn btn-primary">Proceed to checkout</button></a>
                </div>
            </div>
        </div>
        <div class="back mb-5">
            <a href="index.php">
            <button class="btn"><i class="fa-solid fa-arrow-left"></i></button>
            </a>
            <div><p>Continue Shopping</p></div>
        </div>
    </div>
</div>













<?php
include_once("./includes/templates/footer.php");

?>


