<?php
session_start();
require_once '../server.php';

if (!isset($_SESSION['urole_admin'])) {
    header('location: ../home_index.php');
}

if (isset($_POST['back'])) {
    header("location: ../admin/ad_index.php");
}

if (isset($_POST['insert'])) {
    /*1*/
    $id_isbn = $_POST['id_isbn'];
    /*2*/
    $id_typeB = $_POST['id_typeB'];
    /*3*/
    $bookN = $_POST['bookN'];
    /*5*/
    $id_publisher = $_POST['id_publisher'];
    /*6*/
    $id_author = $_POST['id_author'];
    /*7*/
    $price = $_POST['price'];
    /*8*/
    $amount = $_POST['amount'];

    /*4*/
    try {
        $image_file = $_FILES['imgeB']['name'];
        $type = $_FILES['imgeB']['type'];
        $size = $_FILES['imgeB']['size'];
        $temp = $_FILES['imgeB']['tmp_name'];
        $path = "../image/upload/" . $image_file; // set upload folder path
        if (empty($image_file)) {
            echo "ยังไม่ได้เลือกรูปภาพ";
            $_SESSION['error_image'] = "ยังไม่ได้เลือกรูปภาพ";
        } else if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png" || $type == "image/gif") {
            if (!file_exists($path)) { // check file not exist in your upload folder path
                if ($size < 5000000) { // check file size 5MB
                    move_uploaded_file($temp, '../image/upload/' . $image_file); // move upload file temperory directory to your upload folder
                } else {
                    echo "ขนาดรูปภาพ เกิน 5MB"; // error message file size larger than 5mb
                    $_SESSION['error_image'] =  "ขนาดรูปภาพ เกิน 5MB"; // error message file size larger than 5mb
                }
            } else {
                echo "รูปภาพซ้ำ"; // error message file not exists your upload folder path
            }
        } else {
            echo "ต้องเป็นไฟล์ภาพประเภทดังนี JPG, JPEG, PNG";
            $_SESSION['error_image'] = "ต้องเป็นไฟล์ภาพประเภทดังนี JPG, JPEG, PNG";
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
    echo "<br>";


    $id_typeB_T = $conn->query("SELECT * From Type_book where id_typeB = '$id_typeB' ")->fetch();
    $id_publisher_T = $conn->query("SELECT * From publisher_name where id_publisher = '$id_publisher' ")->fetch();
    $id_author_T = $conn->query("SELECT * From author where id_author = '$id_author' ")->fetch();

    if (empty($id_isbn)) {
        $_SESSION['error_ISBN'] = 'ISBN is empty';
        header("location: ../admin/insert_book_page.php?id_isbn=$id_isbn&id_typeB=$id_typeB&bookN=$bookN&id_publisher=$id_publisher&id_author=$id_author&price=$price&amount=$amount&image_file=$image_file");
    }
    if (empty($bookN)) {
        $_SESSION['error_bookN'] = 'BookName is empty';
        header("location: ../admin/insert_book_page.php?id_isbn=$id_isbn&id_typeB=$id_typeB&bookN=$bookN&id_publisher=$id_publisher&id_author=$id_author&price=$price&amount=$amount&image_file=$image_file");
    }
    if (empty($price)) {
        $_SESSION['error_price'] = 'Price is empty';
        header("location: ../admin/insert_book_page.php?id_isbn=$id_isbn&id_typeB=$id_typeB&bookN=$bookN&id_publisher=$id_publisher&id_author=$id_author&price=$price&amount=$amount&image_file=$image_file");
    }
    /*
    if (empty($amount)) {
        $_SESSION['error_amount'] = 'Amount is empty';
        header("location: ../admin/insert_book_page.php");
    }*/
    if (isset($_SESSION['error_image'])) {
        # code...
        header("location: ../admin/insert_book_page.php?id_isbn=$id_isbn&id_typeB=$id_typeB&bookN=$bookN&id_publisher=$id_publisher&id_author=$id_author&price=$price&amount=$amount&image_file=$image_file");
    }
    echo "รหัส ISBN :" . $id_isbn . "<br>";
    echo "ประเภทหนังสือ :" . $id_typeB_T['typeN'] . "<br>";
    echo "ชื่อหนังสือ :" . $bookN . "<br>";
    echo "รูป :" . $id_isbn . "<br>";
    echo "ผู้จัดจำหน่าย :" . $id_publisher_T['publisherN'] . "<br>";
    echo "ผู้เขียน :" . $id_author_T['authorFN'] . " " . $id_author_T['authorLN'] . "<br>";
    echo "ราคา :" . $price . "<br>";
    echo "จำนวน :" . $amount . "<br>";

    //เช็คค่าซ้ำ
    if (!empty($id_isbn) && !empty($bookN) && !empty($price) && !isset($_SESSION['error_image'])) {
        try {
            $checkId_isbn = $conn->prepare("SELECT id_isbn FROM book WHERE id_isbn = :id_isbn"); //$userName
            $checkId_isbn->bindParam(":id_isbn", $id_isbn);
            $checkId_isbn->execute();
            $row = $checkId_isbn->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                # code...
                $_SESSION['error_ISBN'] = "มี Id isbn นี้อยู่ในระบบแล้ว";
                header("location: ../admin/insert_book_page.php?id_isbn=$id_isbn&id_typeB=$id_typeB&bookN=$bookN&id_publisher=$id_publisher&id_author=$id_author&price=$price&amount=$amount&image_file=$image_file");
            } else {
                # code...
                //echo "ไม่มี Id isbn นี้อยู่ในระบบ";
                echo "<br>";
                $checkId_isbn = $conn->prepare("SELECT id_isbn FROM book WHERE bookN = :bookN"); //$userName
                $checkId_isbn->bindParam(":bookN", $bookN);
                $checkId_isbn->execute();
                $row = $checkId_isbn->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    # code...
                    $_SESSION['error_bookN'] = "มีชื่อหนังสือนี้อยู่ในระบบแล้ว";
                    header("location: ../admin/insert_book_page.php?id_isbn=$id_isbn&id_typeB=$id_typeB&bookN=$bookN&id_publisher=$id_publisher&id_author=$id_author&price=$price&amount=$amount&image_file=$image_file");
                } else {
                    //echo "ยังไม่มีชื่อหนังสือนี้อยู่ในระบบ";
                    $stmt = $conn->prepare("INSERT INTO `book`(`id_isbn`, `id_typeB`, `bookN`, `imgeB`, `id_publisher`, `id_author`, `price`, `amount`) VALUES (:id_isbn,:id_typeB,:bookN,:imgeB,:id_publisher,:id_author,:price,:amount)");
                    $stmt->bindParam(":id_isbn", $id_isbn);
                    $stmt->bindParam(":id_typeB", $id_typeB);
                    $stmt->bindParam(":bookN", $bookN);
                    $stmt->bindParam(":imgeB", $image_file);
                    $stmt->bindParam(":id_publisher", $id_publisher);
                    $stmt->bindParam(":id_author", $id_author);
                    $stmt->bindParam(":price", $price);
                    $stmt->bindParam(":amount", $amount);
                    $stmt->execute();
                    function phpAlert($msg) {
                        echo '<script type="text/javascript">alert("' . $msg . '");window.location.href = "../admin/ad_index.php";</script>';
                    }
                    phpAlert( "เพิ่มหนังสือเสร็จสิ้น");
                    //header("location: ../admin/ad_index.php");
                }
            }
        } catch (\Throwable $e) {
            //throw $th;
        }
    }
    echo "<br>";
    //echo "เสร็จสิ้น :" . $amount . "<br>";
    /*echo '<a href="../admin/ad_index.php" style="text-decoration: none;">
    <p class="login-button-admin">กลับสู่หน้าหลัก</p>
</a>';*/
    
}
