<?php
@session_start();
$page_title="site";
$css_file="style.css";

include_once("./includes/templates/header.php");
require_once("connection.php");



global $con;
$stmt= $con->prepare('SELECT * FROM dashboard');
$stmt->execute();
$data = $stmt->fetchAll();











?>



<!-- ************************* header ************************* -->
<!-- <header class="site_header">
    <div class="site">
        <div><img src="img/logo2.png" alt="" class=""></div>
        <div class="search">
            <i class="fas fa-search"></i>
            <input type="search" id="search" class="" placeholder="   Search the product....">
        </div>
        <a href="reset.php">
            <i class="shop fas fa-shopping-cart" title=""></i>
        </a>
        <a href="register.php">
            <i class="reg fas fa-sign-in-alt" title="signin & register"></i>
        </a>
        <!-- <ul class="dropdown-menu">
            <li><a href="addProduct.php">Add Product</a></li>
            <li><a href="dashboard.php">dashboard</a></li>
        </ul>      
    -->
    <!-- <div class="dropdown">
        
            <i class="list-icon fas fa-list"></i>
        
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="addProduct.php">Add Product</a></li>
                    <li><a class="dropdown-item" href="dashboard.php">dashboard</a></li>
                </ul>
            </div>
            
        </div>        
    </header> --> 
<!-- ************************* header ************************* -->

<!-- <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">user name</th>
      <th scope="col">phone</th>
      <th scope="col">location</th>
      <th scope="col">product</th>
      <th scope="col">quantity</th>
      <th scope="col">time</th>
      <th scope="col">total price</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($data as $order){?>
    <tr>
      <th scope="row"><?php echo $order["id"];?></th>
      <td><?php echo $order["user_name"];?></td>
      <td><?php echo $order["phone"];?></td>
      <td><?php echo $order["location"];?></td>
      <td><?php echo $order["product"];?></td>
      <td><?php echo $order["quantity"];?></td>
      <td><?php echo $order["time"];?></td>
      <td><?php echo $order["total_price"];?></td>
    </tr>
    <?php }?>
  </tbody>
</table>
 -->



 <nav class="navbar navbar-inverse visible-xs">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="dashboard.php">Dashboard</a></li>
        <li><a href="admin.php">products</a></li>
        <li><a href="#">feedback</a></li>
        <li><a href="addProduct.php">Add Product</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav hidden-xs">
      <h2>Logo</h2>
      <ul class="nav nav-pills nav-stacked">
        <li class="item active"><a href="dashboard.php">Dashboard</a></li>
        <li class="item"><a href="admin.php">products</a></li>
        <li class="item"><a href="#">feedback</a></li>
        <li class="item"><a href="addProduct.php">Add Product</a></li>
      </ul><br>
    </div>
    <br>
    
    <div class="col-sm-9">
      <!-- <div class="well ">
        <h4>Dashboard</h4>
        <p>Some text..</p>
      </div> -->
      <div class="row">
        <div class="col-sm-3">
          <div class="well">
            <h4>total Orders</h4>
            <!-- <p><?php echo $savingOrder['id'];?></p>  -->
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>total Sales</h4>
            <!-- <p><?php echo $order['pending'];?></p>  -->
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>Sessions</h4>
            <p></p> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>Bounce</h4>
            <p>30%</p> 
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-8">
          <div class="well w-100">
            <h4>Recent Sales</h4>
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th scope="col">Customer</th>
                  <th scope="col">Product</th>
                  <th scope="col">quantity</th>
                  <th scope="col">Date</th>
                  <th scope="col">Total Price</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($data as $order){?>
              <tr>
                <td><?php echo $order["user_name"];?></td>
                <td><?php echo $order["product"];?></td>
                <td><?php echo $order["quantity"];?></td>
                <td><?php echo $order["time"];?></td>
                <td><?php echo $order["total_price"];?></td>
              </tr>
              <?php }?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="well">
            <h4>Rated</h4>
            <p><?php echo $lap['name']; ?></p> 
            <p><?php echo $lap['star']; ?></p> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  



<?php
include_once("./includes/templates/footer.php");
?>