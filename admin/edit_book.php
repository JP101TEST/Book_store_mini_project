<?php
session_start();
require_once '../server.php';
if (!isset($_SESSION['urole_admin'])) {
    header('location: ../home_index.php');
}

if (!isset($_GET['id'])) {
    //header('location: ad_index.php');
    header('location: ad_index.php');
}


// Get the ISBN from the URL
$isbn = $_GET['id'];

// Retrieve the book details from the database using the ISBN
$query = "SELECT * FROM book WHERE id_isbn = '$isbn'";
$book = $conn->query($query)->fetch();

$id_isbn = $book['id_isbn'];
/*2*/
$id_typeB = $book['id_typeB'];
/*3*/
$bookN = $book['bookN'];
/*5*/
$id_publisher = $book['id_publisher'];
/*6*/
$id_author = $book['id_author'];
/*7*/
$price = $book['price'];
/*8*/
$amount = $book['amount'];

$imgeB = $book['imgeB'];


//เลือก row ทั้งหมดจากตาราง type_book
$queryTB = "SELECT * FROM type_book ORDER BY id_typeB";
//เรียกใช้คำสั่ง ->query() 
//ใช้คำสั่ง fetchAll() เพื่อเก็บผลลัพธ์ที่ได้จาก query ไว้ในตัวแปร $typeBooks
$typeBooks = $conn->query($queryTB)->fetchAll();

$queryTB = "SELECT * FROM publisher_name ORDER BY id_publisher";
$idPublishers = $conn->query($queryTB)->fetchAll();
$queryTB = "SELECT * FROM author ORDER BY id_author";
$authorSs = $conn->query($queryTB)->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['urole_admin']; ?></title>
    <link rel="icon" href="../image/book_logo_color.png">
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
            <strong>|EDIT BOOK</strong>
            <div style="text-align: left;">
                <strong style="text-align: center;font-family: arial;color: #ffffff;font-size: 15px;">welcome
                    <?php echo $_SESSION['urole_admin']; ?></strong>
            </div>
        </div>
        <div class="C-header-loging">
            <ul>
                <form>
                    <!-- hello admin-->
                    <!--
                    <a href="ad_index.php" style="text-decoration: none;">
                        <p class="login-button-admin">cancel</p>
                    </a>
                    -->
                </form>
            </ul>
        </div>
    </div>
    <hr>
    <article>
        <div class="d-flex justify-content-center">
            <div class="w-50">
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
                <h1>แก้ไขหนังสือ</h1><br>
                <div class="text-center">
                    <?php echo '<img src="../image/upload/' . $imgeB . '" alt="" height="300px" width="230px" ><br><br>'; ?>
                </div>
                <form action="../operation/edit.php?idISBN=<?php echo $id_isbn; ?>&OImage=<?php echo $imgeB; ?>&OName=<?php echo $bookN; ?>&Oprice=<?php echo $price; ?>&Oamount=<?php echo $amount; ?>" method="post" class="form-group" enctype="multipart/form-data">
                    <div class="form-floating">
                        <input type="text" name="id_isbn" class="form-control" pattern="[0-9]*" minlength="13" maxlength="13" title="ISBN should contain 13 characters including numbers" value="<?php echo $id_isbn; ?>" disabled><br>
                        <label for="id_isbn" style="font-family: Arial;font-size: 18px;">Id isbn:</label>
                    </div>
                    <div class="form-floating">
                        <select name="id_typeB" class="form-select">
                            <?php foreach ($typeBooks as $key => $typeBook) : ?>
                                <option value="<?php echo $typeBook['id_typeB']; ?>" <?php if ($typeBook['id_typeB'] === $id_typeB) echo 'selected'; ?>>
                                    <?php echo $typeBook['typeN']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select><br>
                        <label for="id_typeB" style="font-family: Arial;font-size: 18px;">New type book:</label>
                    </div>

                    <div class="form-floating">
                        <input type="text" name="bookN" class="form-control" pattern="[a-zA-Z0-9ก-๙ ]*" title="Use a-z A-Z 0-9 ก-๙ and - ' only" value="<?php echo $bookN; ?>"><br>
                        <label for="bookN" style="font-family: Arial;font-size: 18px;">New book name:</label>
                    </div>
                    <div>
                        <label for="imgeB" style="font-family: Arial;font-size: 18px;"> New image book:</label>
                        <input type="file" name="imgeB" accept="image/png, image/jpeg" class="form-control"><br>
                    </div>
                    <div class="form-floating">
                        <select name="id_publisher" class="form-select">
                            <?php foreach ($idPublishers as $key => $idPublisher) : ?>
                                <option value="<?php echo $idPublisher['id_publisher']; ?>" <?php if ($idPublisher['id_publisher'] === $id_publisher) echo 'selected'; ?>>
                                    <?php echo $idPublisher['publisherN']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select><br>
                        <label for="id_publisher" style="font-family: Arial;font-size: 18px;"> New publisher:</label>
                    </div>
                    <div class="form-floating">
                        <select name="id_author" class="form-select">
                            <?php foreach ($authorSs as $key => $authorS) : ?>
                                <option value="<?php echo $authorS['id_author']; ?>">
                                    <?php echo $authorS['authorFN'] . " " . $authorS['authorLN']; ?></option>
                            <?php endforeach; ?>
                        </select><br>
                        <label for="id_author" style="font-family: Arial;font-size: 18px;">New author:</label>
                    </div>
                    <div class="form-floating">
                        <input type="number" name="price" min="0" class="form-control" value="<?php echo $price; ?>"><br>
                        <label for="price" style="font-family: Arial;font-size: 18px;">New price:</label>
                    </div>
                    <div class="form-floating">
                        <input type="number" name="amount" min="0" class="form-control" value="<?php echo $amount; ?>"><br>
                        <label for="amount " style="font-family: Arial;font-size: 18px;">New amount:</label>
                    </div>
                    <br>
                    <div class="d-flex justify-content-between">
                        <div>
                            <input type="submit" name="back" value="ย้อนกลับ" class="btn btn-warning">
                        </div>
                        <div>
                            <input type="submit" name="edit" value="แก้ไข" class="btn btn-primary">
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </article>
</body>

</html>