<?php
session_start();
require_once 'server.php';

$perPage = 6;

// Check if search value is set
if (isset($_GET['search']) && isset($_GET['search_criteria']) && isset($_GET['sort_order'])) {
    $search_criteria = $_GET['search_criteria'];
    $search = $_GET['search'];
    $sort_order = $_GET['sort_order'];
    if ($search_criteria == "bookN") {
        $stmt = $conn->query("SELECT count(*) FROM book WHERE bookN LIKE '%$search%' ORDER BY bookN $sort_order");
    } elseif ($search_criteria == "publisherN") {
        $stmt = $conn->query("SELECT count(*) FROM book AS b INNER JOIN publisher_name AS pn ON b.id_publisher = pn.id_publisher INNER JOIN author AS au ON b.id_author = au.id_author WHERE pn.publisherN LIKE '%$search%' ORDER BY pn.publisherN $sort_order , CONCAT(au.authorFN,' ',au.authorLN) $sort_order,b.bookN $sort_order");
    } elseif ($search_criteria == "authorName") {
        $stmt = $conn->query("SELECT count(*) FROM book AS b INNER JOIN publisher_name AS pn ON b.id_publisher = pn.id_publisher INNER JOIN author AS au ON b.id_author = au.id_author WHERE CONCAT(au.authorFN,' ',au.authorLN) LIKE '%$search%' ORDER BY CONCAT(au.authorFN,' ',au.authorLN) $sort_order,b.bookN $sort_order");
    } elseif ($search_criteria == "price") {
        $stmt = $conn->query("SELECT count(*) FROM book AS b INNER JOIN publisher_name AS pn ON b.id_publisher = pn.id_publisher INNER JOIN author AS au ON b.id_author = au.id_author WHERE b.price LIKE '%$search%' ORDER BY b.price $sort_order");
    } elseif ($search_criteria == "amount") {
        $stmt = $conn->query("SELECT count(*) FROM book AS b INNER JOIN publisher_name AS pn ON b.id_publisher = pn.id_publisher INNER JOIN author AS au ON b.id_author = au.id_author WHERE b.amount LIKE '%$search%' ORDER BY b.amount $sort_order");
    } else {
        $stmt = $conn->query("SELECT count(*) FROM book AS b INNER JOIN publisher_name AS pn ON b.id_publisher = pn.id_publisher INNER JOIN author AS au ON b.id_author = au.id_author WHERE b.bookN LIKE '%$search%' OR pn.publisherN LIKE '%$search%' OR CONCAT(au.authorFN,' ',au.authorLN) LIKE '%$search%' ORDER BY pn.publisherN $sort_order,au.authorFN $sort_order,b.bookN $sort_order");
    }
    $total_results = $stmt->fetchColumn();
    $total_pages = ceil($total_results / $perPage);
} else {
    // Calculate Total pages
    $stmt = $conn->query('SELECT count(*) FROM book');
    $total_results = $stmt->fetchColumn();
    $total_pages = ceil($total_results / $perPage);
}

// Current page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$starting_limit = ($page - 1) * $perPage;

// Query to fetch users
if (isset($_GET['search']) && isset($_GET['search_criteria']) && isset($_GET['sort_order'])) {
    $search_criteria = $_GET['search_criteria'];
    $search = $_GET['search'];
    $sort_order = $_GET['sort_order'];
    if ($search_criteria == "bookN") {
        $query = "SELECT  b.id_isbn as idISBN, b.bookN as bookName, b.imgeB as imgeBook, tb.typeN as bookType, pn.publisherN as publisherName, CONCAT(au.authorFN,' ',au.authorLN) as authorName, b.price, b.amount FROM book AS b INNER JOIN type_book AS tb ON b.id_typeB = tb.id_typeB INNER JOIN publisher_name AS pn ON b.id_publisher = pn.id_publisher INNER JOIN author AS au ON b.id_author = au.id_author WHERE  b.bookN LIKE '%$search%' ORDER BY b.bookN $sort_order  LIMIT $starting_limit,$perPage";
    } elseif ($search_criteria == "publisherN") {
        $query = "SELECT  b.id_isbn as idISBN, b.bookN as bookName, b.imgeB as imgeBook, tb.typeN as bookType, pn.publisherN as publisherName, CONCAT(au.authorFN,' ',au.authorLN) as authorName, b.price, b.amount FROM book AS b INNER JOIN type_book AS tb ON b.id_typeB = tb.id_typeB INNER JOIN publisher_name AS pn ON b.id_publisher = pn.id_publisher INNER JOIN author AS au ON b.id_author = au.id_author WHERE  pn.publisherN LIKE '%$search%' ORDER BY pn.publisherN $sort_order , CONCAT(au.authorFN,' ',au.authorLN) $sort_order,b.bookN $sort_order LIMIT $starting_limit,$perPage";
    } elseif ($search_criteria == "authorName") {
        $query = "SELECT  b.id_isbn as idISBN, b.bookN as bookName, b.imgeB as imgeBook, tb.typeN as bookType, pn.publisherN as publisherName, CONCAT(au.authorFN,' ',au.authorLN) as authorName, b.price, b.amount FROM book AS b INNER JOIN type_book AS tb ON b.id_typeB = tb.id_typeB INNER JOIN publisher_name AS pn ON b.id_publisher = pn.id_publisher INNER JOIN author AS au ON b.id_author = au.id_author WHERE  CONCAT(au.authorFN,' ',au.authorLN) LIKE '%$search%' ORDER BY b.bookN $sort_order LIMIT $starting_limit,$perPage";
    } elseif ($search_criteria == "price") {
        $query = "SELECT  b.id_isbn as idISBN, b.bookN as bookName, b.imgeB as imgeBook, tb.typeN as bookType, pn.publisherN as publisherName, CONCAT(au.authorFN,' ',au.authorLN) as authorName, b.price, b.amount FROM book AS b INNER JOIN type_book AS tb ON b.id_typeB = tb.id_typeB INNER JOIN publisher_name AS pn ON b.id_publisher = pn.id_publisher INNER JOIN author AS au ON b.id_author = au.id_author WHERE  b.price LIKE '%$search%' ORDER BY b.price $sort_order , b.bookN $sort_order  LIMIT $starting_limit,$perPage";
    } elseif ($search_criteria == "amount") {
        $query = "SELECT  b.id_isbn as idISBN, b.bookN as bookName, b.imgeB as imgeBook, tb.typeN as bookType, pn.publisherN as publisherName, CONCAT(au.authorFN,' ',au.authorLN) as authorName, b.price, b.amount FROM book AS b INNER JOIN type_book AS tb ON b.id_typeB = tb.id_typeB INNER JOIN publisher_name AS pn ON b.id_publisher = pn.id_publisher INNER JOIN author AS au ON b.id_author = au.id_author WHERE  b.amount LIKE '%$search%' ORDER BY b.amount $sort_order , b.bookN $sort_order  LIMIT $starting_limit,$perPage";
    } else {
        $query = "SELECT b.id_isbn as idISBN, b.bookN as bookName, b.imgeB as imgeBook, tb.typeN as bookType, pn.publisherN as publisherName, CONCAT(au.authorFN,' ',au.authorLN) as authorName, b.price, b.amount FROM book AS b INNER JOIN type_book AS tb ON b.id_typeB = tb.id_typeB INNER JOIN publisher_name AS pn ON b.id_publisher = pn.id_publisher INNER JOIN author AS au ON b.id_author = au.id_author WHERE b.bookN LIKE '%$search%' OR pn.publisherN LIKE '%$search%' OR CONCAT(au.authorFN,' ',au.authorLN) LIKE '%$search%' ORDER BY pn.publisherN $sort_order,au.authorFN $sort_order,b.bookN $sort_order LIMIT $starting_limit,$perPage";
    }
} else {
    $query = "SELECT b.id_isbn as idISBN, b.bookN as bookName, b.imgeB as imgeBook, tb.typeN as bookType, pn.publisherN as publisherName, CONCAT(au.authorFN,' ',au.authorLN) as authorName, b.price, b.amount FROM book AS b INNER JOIN type_book AS tb ON b.id_typeB = tb.id_typeB INNER JOIN publisher_name AS pn ON b.id_publisher = pn.id_publisher INNER JOIN author AS au ON b.id_author = au.id_author ORDER BY b.bookN desc LIMIT $starting_limit,$perPage";
}

// Fetch all users for current page
$users = $conn->query($query)->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- css -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="button.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <!-- <header> -->
    <div class="C-header">
        <div class="C-header-logo">
            <img src="image/book_logo.png" alt="book_logo_color.png" height="75px" style="text-align: center;">
        </div>
        <div style="flex-grow: 1;text-align: left;font-family: arial;color: white;;font-size: 50px;">
            <strong>|BOOK STORE</strong>
        </div>
        <div class="C-header-loging">
            <ul>
                <form action="operation/signin.php" method="post">
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit" name="signin" value="login" class="login-button">
                </form>
            </ul>
        </div>
    </div>
    <hr>
    <?php if (isset($_SESSION['error_username']) or isset($_SESSION['error_password'])) { ?>
        <div class="error">

            <?php if (isset($_SESSION['error_username'])) { ?>
                <div>
                    <?php
                    echo " *" . $_SESSION['error_username'] . "* ";
                    unset($_SESSION['error_username']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['error_password'])) { ?>
                <div>
                    <?php
                    echo " *" . $_SESSION['error_password'] . "* ";
                    unset($_SESSION['error_password']);
                    ?>
                </div>
            <?php } ?>

        </div>
        <hr>
    <?php } ?>
    <!-- <nav> -->
    <!--
    <nav>
        <ul class="nav-ul">
            <a>
                <li>all book</li>
            </a>
            <a>
                <li>general</li>
            </a>
            <a>
                <li>comic & manga</li>
            </a>
            <a>
                <li>novel</li>
            </a>
        </ul>
    </nav>
    <hr>
    -->
    <!-- <article> -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" class="form-search">
        <select name="search_criteria" class="form-control">
            <option value="bookN">ชื่อหนังสือ</option>
            <option value="publisherN">ผู้จัดจำหน่าย</option>
            <option value="authorName">ผู้เขียน</option>
            <!--
            <option value="price">ราคา</option>
            -->
            <option value="amount">จำนวน</option>
            <option value="all">ทั้งหมด</option>
        </select>
        <select name="sort_order" class="form-control">
            <option value="asc">น้อย->มาก </option>
            <option value="desc">มาก->น้อย </option>
        </select>
        <input type="text" name="search" class="form-control-form-c" placeholder="Search">
        <input type="submit" class="btn btn-primary" value="Search">
    </form>
    <br>
    <?php if (empty($search)) {
    } else { ?>
        <?php
        $search_c;
        $sort_o;
        if ($search_criteria == "bookN") {
            $search_c = "ชื่อหนังสือ";
        } elseif ($search_criteria == "publisherN") {
            $search_c = "ผู้จัดจำหน่าย";
        } elseif ($search_criteria == "authorName") {
            $search_c = "ผู้เขียน";
        } elseif ($search_criteria == "price") {
            $search_c = "ราคา";
        } else {
            $search_c = "ทั้งหมด";
        }
        if ($sort_order == "asc") {
            $sort_o = "น้อย->มาก";
        } else {
            $sort_o = "มาก->น้อย";
        }
        ?>
        <h3 style="text-align: center;">ค้นหาจาก <?php echo $search_c . " เรียงโดย " . $sort_o . " คำที่ค้นหา \"" . $search . "\""; ?></h3>

    <?php } ?>

    <hr>
    <table class="table text-center">
        <?php if (count($users) > 0) : ?>
            <tr>
                <th>ชื่อหนังสือ</th>
                <th>รูป</th>
                <th>ประเภทหนังสือ</th>
                <th>ผู้จัดจำหน่าย</th>
                <th>ผู้เขียน</th>
                <!--
                <th>ราคา</th>
                <th>จัดการ</th>
                -->
                <th>จำนวน</th>
            </tr>
        <?php endif; ?>
        <?php if (count($users) > 0) : ?>
            <?php foreach ($users as $key => $user) : ?>
                <tr>
                    <td class="align-middle"><?php echo $user['bookName']; ?></td>
                    <td class="align-middle"><img src="image/upload/<?php echo $user['imgeBook']; ?>" alt="" height="200px" width="130px"></td>
                    <td class="align-middle"><?php echo $user['bookType']; ?></td>
                    <td class="align-middle"><?php echo $user['publisherName']; ?></td>
                    <td class="align-middle"><?php echo $user['authorName']; ?></td>
                    <!--
                    <td><?php echo $user['price']; ?></td>
                    -->
                    <td class="align-middle">
                        <div>
                            <?php if ($user['amount'] > 0) {
                                echo $user['amount'];
                            } else {
                                echo '<strong class="text-danger"> หนังสือหมด</strong>';
                            } ?>
                        </div>
                    </td>
                     <!--
                    <td class="align-middle">
                        <div>
                            เมนู
                        </div>
                    </td>
                    -->
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="3"><br>No results found for "<?php echo $search; ?>"</td>
            </tr>
        <?php endif; ?>
    </table>

    <hr>
    <br>
    <?php if ($total_pages > 1) { ?>
        <?php if (isset($_GET['search']) && isset($_GET['search_criteria']) && isset($_GET['sort_order'])) { ?>
            <div class="pagination">
                <ul>
                    <?php if (count($users) > 0) : ?>
                        <li><a href='?page=1&search=<?php echo $search; ?>&search_criteria=<?php echo $search_criteria; ?>&sort_order=<?php echo $sort_order; ?>' class="pagination-link">First</a></li>
                    <?php endif; ?>
                    <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                        <li>
                            <a href='<?php echo "?page=$page&search=$search&search_criteria=$search_criteria&sort_order=$sort_order"; ?>' class="pagination-link">
                                <?php echo $page; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    <?php if (count($users) > 0) : ?>
                        <li><a href='?page=<?php echo $total_pages; ?>&search=<?php echo $search; ?>&search_criteria=<?php echo $search_criteria; ?>&sort_order=<?php echo $sort_order; ?>' class="pagination-link">Last</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php } else { ?>
            <div class="pagination">
                <ul>
                    <?php if (count($users) > 0) : ?>
                        <li><a href='?page=1' class="pagination-link">First</a></li>
                    <?php endif; ?>
                    <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                        <li>
                            <a href='<?php echo "?page=$page"; ?>' class="pagination-link">
                                <?php echo $page; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    <?php if (count($users) > 0) : ?>
                        <li><a href='?page=<?php echo $total_pages; ?>' class="pagination-link">Last</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php } ?>
        <?php if (count($users) > 0) : ?>
            <br>
    <?php endif;
    } ?>
    <hr>
    <article>
        <!--
        <p>Hello World</p>
        <div>
            <div><img src="image/book_in_store/comic/C_01.jpg" alt="" height="250px" width="180px"></div>
            <div><img src="image/book_in_store/general/G_01.jpg" alt="" height="250px" width="180px"></div>
            <div><img src="image/book_in_store/novel/N_01.jpg" alt="" height="250px" width="180px"></div>
        </div>
         -->
    </article>

</body>

</html>