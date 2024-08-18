<?php
@session_start();
if(isset($_SESSION['email'])&& $_SESSION['type']=="admin"){
    //include_once("./includes/templates/header.php");
    require_once("connection.php");

  ///  $_GET['admin_id']=5;
    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET'){
        if(isset($_GET['admin_id'])){
            global $con;
            $stmt=$con->prepare('DELETE FROM laptops where id=?');
            $stmt->execute(array($_GET['admin_id']));
            @unlink($_GET['image_path']);
        }
        header('location:admin.php');

    }


}else{
    header('location:register.php');
}