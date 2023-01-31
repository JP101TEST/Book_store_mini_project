<?php
session_start();
require_once '../server.php';
if (!isset($_SESSION['urole_admin'])) {
    header('location: ../home_index.php');
}
//เลือก row ทั้งหมดจากตาราง type_book
$queryTB = "SELECT * FROM type_book ORDER BY id_typeB";
//เรียกใช้คำสั่ง ->query() 
//ใช้คำสั่ง fetchAll() เพื่อเก็บผลลัพธ์ที่ได้จาก query ไว้ในตัวแปร $typeBooks
$typeBooks = $conn->query($queryTB)->fetchAll();

$queryTB = "SELECT * FROM publisher_name ORDER BY id_publisher";
$idPublishers = $conn->query($queryTB)->fetchAll();
$queryTB = "SELECT * FROM author ORDER BY id_author";
$authorSs = $conn->query($queryTB)->fetchAll();

if (isset($_GET['id_isbn'])) {
    $id_isbn = $_GET['id_isbn'];
    $id_typeB = $_GET['id_typeB'];
    $bookN = $_GET['bookN'];
    $id_publisher = $_GET['id_publisher'];
    $id_author = $_GET['id_author'];
    $price = $_GET['price'];
    $amount = $_GET['amount'];
    $image_file = $_GET['image_file'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['urole_admin']; ?></title>
    <!-- css -->
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../button.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <!-- <header> -->
    <div class="C-header C-red-color">
        <div class="C-header-logo">
            <img src="../image/book_logo.png" alt="book_logo_color.png" height="75px" style="text-align: center;">
        </div>
        <div style="flex-grow: 1;text-align: left;font-family: arial;color: white;;font-size: 50px;">
            <strong>|ADD BOOK</strong>
            <div style="text-align: left;">
                <strong style="text-align: center;font-family: arial;color: #ffffff;font-size: 15px;">welcome
                    <?php echo $_SESSION['urole_admin']; ?></strong>
            </div>
        </div>
        <div class="C-header-loging">
            <ul>
                <form>
                    <!-- hello admin-->
                    <a href="ad_index.php" style="text-decoration: none;">
                        <p class="login-button-admin">cancel</p>
                    </a>
                </form>
            </ul>
        </div>
    </div>
    <hr>
    <article>
        <div class="d-flex justify-content-center">
            <div class="w-50">
                <?php if (isset($_SESSION['error_ISBN'])) { ?>
                    <div class="d-flex justify-content-center">
                        <div class="btn btn-danger">
                            <?php
                            echo " *" . $_SESSION['error_ISBN'] . "* ";
                            unset($_SESSION['error_ISBN']);
                            ?></div>
                    </div><br>
                <?php } ?>
                <?php if (isset($_SESSION['error_bookN'])) { ?>
                    <div class="d-flex justify-content-center">
                        <div class="btn btn-danger">
                            <?php
                            echo " *" . $_SESSION['error_bookN'] . "* ";
                            unset($_SESSION['error_bookN']);
                            ?></div>
                    </div><br>
                <?php } ?>
                <?php if (isset($_SESSION['error_image'])) { ?>
                    <div class="d-flex justify-content-center">
                        <div class="btn btn-danger">
                            <?php
                            echo " *" . $_SESSION['error_image'] . "* ";
                            unset($_SESSION['error_image']);
                            ?></div>
                    </div><br>
                <?php } ?>
                <?php if (isset($_SESSION['error_price'])) { ?>
                    <div class="d-flex justify-content-center">
                        <div class="btn btn-danger">
                            <?php
                            echo " *" . $_SESSION['error_price'] . "* ";
                            unset($_SESSION['error_price']);
                            ?></div>
                    </div><br>
                <?php } ?>
                <?php if (isset($_SESSION['error_amount'])) { ?>
                    <div class="d-flex justify-content-center">
                        <div class="btn btn-danger">
                            <?php
                            echo " *" . $_SESSION['error_amount'] . "* ";
                            unset($_SESSION['error_amount']);
                            ?></div>
                    </div><br>
                <?php } ?>
                <h1>เพิ่มหนังสือ</h1><br>
                <form action="../operation/insert_user.php" method="post" class="form-group" enctype="multipart/form-data">
                    <div class="form-floating">
                        <input type="text" name="id_isbn" class="form-control" pattern="[0-9]{13}" minlength="13" maxlength="13" title="ISBN should contain 13 characters including numbers" <?php if (isset($_GET['id_isbn'])) {
                                                                                                                                                                                                    echo 'value="' . $id_isbn . '"';
                                                                                                                                                                                                } ?>>
                        <br>
                        <label for="id_isbn" style="font-family: Arial;font-size: 18px;">id isbn:</label>
                    </div>
                    <div class="form-floating">
                        <select name="id_typeB" class="form-select">
                            <?php foreach ($typeBooks as $key => $typeBook) : ?>
                                <option value="<?php echo $typeBook['id_typeB']; ?>" <?php if (isset($id_typeB) && $typeBook['id_typeB'] == $id_typeB) echo 'selected'; ?>>
                                    <?php echo $typeBook['typeN']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select><br>
                        <label for="id_typeB" style="font-family: Arial;font-size: 18px;">id typeB:</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" name="bookN" class="form-control" pattern="[a-zA-Z0-9ก-๙-' ]*" <?php if (isset($_GET['bookN'])) {
                                                                                                            echo 'value="' . $bookN . '"';
                                                                                                        } ?>><br>
                        <label for="bookN" style="font-family: Arial;font-size: 18px;">book name:</label>
                    </div>
                    <div>
                        <label for="imgeB" style="font-family: Arial;font-size: 18px;">imge book:</label>
                        <?php if (isset($_GET['image_file'])) {
                            echo '<a style="color:red;">* กรุณาใส่รูปใหม่ *</a>';
                        } ?>
                        <input type="file" name="imgeB" accept="image/png, image/jpeg" class="form-control"><br>
                    </div>
                    <div class="form-floating">
                        <select name="id_publisher" class="form-select">
                            <?php foreach ($idPublishers as $key => $idPublisher) : ?>
                                <option value="<?php echo $idPublisher['id_publisher']; ?>" <?php if (isset($id_publisher) && $idPublisher['id_publisher'] == $id_publisher) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                                    <?php echo $idPublisher['publisherN']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select><br>
                        <label for="id_publisher" style="font-family: Arial;font-size: 18px;">id_publisher:</label>
                    </div>
                    <div class="form-floating">
                        <select name="id_author" class="form-select">
                            <?php foreach ($authorSs as $key => $authorS) : ?>
                                <option value="<?php echo $authorS['id_author']; ?>" <?php if (isset($id_author) && $authorS['id_author'] == $id_author) {
                                                                                            echo 'selected';
                                                                                        } ?>>
                                    <?php echo $authorS['authorFN'] . " " . $authorS['authorLN']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select><br>
                        <label for="id_author" style="font-family: Arial;font-size: 18px;">id_author:</label>
                    </div>
                    <div class="form-floating">

                        <input type="text" name="price" id="price" min="0" class="form-control" <?php if (isset($_GET['price'])) {
                                                                                                    echo 'value="' . $price . '"';
                                                                                                } ?>><br>
                        <label for="price" style="font-family: Arial;font-size: 18px;">price:</label>
                    </div>
                    <div class="form-floating">
                        <input type="number" name="amount" min="0" class="form-control" <?php if (isset($_GET['amount'])) {
                                                                                            echo 'value="' . $amount . '"';
                                                                                        } ?>><br>
                        <label for="amount" style="font-family: Arial;font-size: 18px;">amount:</label>
                    </div>
                    <br>
                    <div class="d-flex justify-content-between">
                        <div>
                            <input type="reset" value="ล้าง" class="btn btn-secondary">
                        </div>
                        <div>
                            <input type="submit" name="back" value="ย้อนกลับ" class="btn btn-warning">
                        </div>
                        <div>
                            <input type="submit" name="insert" value="เพิ่ม" class="btn btn-primary">
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </article>
</body>

</html>