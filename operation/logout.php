<?php
session_start();
if (isset($_POST['logout'])){
    unset($_SESSION['urole_admin']);
    unset($_SESSION['urole_user']);
    header("location: ../home_index.php");
}
?>