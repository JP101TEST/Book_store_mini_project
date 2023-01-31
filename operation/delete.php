<?php
session_start();
require_once '../server.php';
if (!isset($_SESSION['urole_admin'])) {
    header('location: ../home_index.php');
}

if (!isset($_GET['idISBN'])) {
    $idISBN = $_GET['id'];
    echo "ISBN : ".$idISBN." is gone";
    $stmt = $conn->prepare("DELETE FROM book WHERE id_isbn = :id_isbn");
    $stmt->bindParam(":id_isbn", $idISBN);
    $stmt->execute();
    echo "<br>";
    echo '<a href="../admin/ad_index.php" style="text-decoration: none;">
    <p class="login-button-admin">cancel</p>
</a>';
}
