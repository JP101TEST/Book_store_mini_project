<?php
session_start();
require_once '../server.php';
if (!isset($_SESSION['urole_admin'])) {
    header('location: ../home_index.php');
}

if (!isset($_GET['idISBN'])) {//เช็คว่ามีค่าเข้ามา
    $idISBN = $_GET['id'];
    echo "ISBN : " . $idISBN . " is gone";
    //ลบหนังสือที่มีรหัส ISBN
    $stmt = $conn->prepare("DELETE FROM book WHERE id_isbn = :id_isbn");
    $stmt->bindParam(":id_isbn", $idISBN);
    $stmt->execute();
    function phpAlert($msg) {//Alert
        echo '<script type="text/javascript">alert("' . $msg . '");window.location.href = "../admin/ad_index.php";</script>';
    }
    phpAlert( "ลบเสร็จสิ้น");
    //echo "เสร็จสิ้น :" . $amount . "<br>";
    /*
    echo "<br>";
    echo '<a href="../admin/ad_index.php" style="text-decoration: none;">
    <p class="login-button-admin">กลับสู่หน้าหลัก</p>
</a>';
*/
}
