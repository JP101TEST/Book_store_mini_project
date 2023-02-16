<?php
session_start();
require_once '../server.php';
if (!isset($_SESSION['urole_user'])) {
    header('location: ../home_index.php');
}

$perPage = 8;

// Check if search value is set
if (isset($_GET['search']) && isset($_GET['sort_order'])) {
    $search = $_GET['search'];
    $sort_order = $_GET['sort_order'];
    $stmt = $conn->query("SELECT count(*) FROM book WHERE bookN LIKE '%$search%' ORDER BY bookN $sort_order");
    $total_results = $stmt->fetchColumn();
    $total_pages = ceil($total_results / $perPage);
} else {
    // Calculate Total pages
    $stmt = $conn->query('SELECT count(*) FROM book');
    $total_results = $stmt->fetchColumn();
    $total_pages = ceil($total_results / $perPage);
    $search = "";
}

// Current page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$starting_limit = ($page - 1) * $perPage;

// Query to fetch users
if (isset($_GET['search']) && isset($_GET['sort_order'])) {
    $search = $_GET['search'];
    $sort_order = $_GET['sort_order'];
    $query = "SELECT  b.id_isbn as idISBN, b.bookN as bookName, b.imgeB as imgeBook, tb.typeN as bookType, pn.publisherN as publisherName, CONCAT(au.authorFN,' ',au.authorLN) as authorName, b.price, b.amount FROM book AS b INNER JOIN type_book AS tb ON b.id_typeB = tb.id_typeB INNER JOIN publisher_name AS pn ON b.id_publisher = pn.id_publisher INNER JOIN author AS au ON b.id_author = au.id_author WHERE  b.bookN LIKE '%$search%' ORDER BY b.bookN $sort_order  LIMIT $starting_limit,$perPage";
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
    <title><?php echo $_SESSION['urole_user']; ?></title>
    <!-- css -->
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../button.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <!-- <header> -->
    <div class="C-header">
        <div class="C-header-logo">
            <img src="../image/book_logo.png" alt="book_logo_color.png" height="75px" style="text-align: center;">
        </div>
        <div style="flex-grow: 1;text-align: left;font-family: arial;color: white;;font-size: 50px;">
            <strong>|BOOK STORE</strong>
            <div style="text-align: left;">
                <strong style="text-align: center;font-family: arial;color: #ffffff;font-size: 15px;">welcome
                    <?php echo $_SESSION['urole_user']; ?></strong>
            </div>
        </div>
        <div class="C-header-loging">
            <ul>
                <form action="../operation/logout.php" method="post">
                    <!-- hello admin-->
                    <input name="logout" type="submit" value="ออกจากระบบ" class="login-button">
                </form>
            </ul>
        </div>
    </div>
    <hr>
    <!-- <article> -->
    <article>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" class="form-search">
            <select name="sort_order" class="form-control">
            <option value="asc" <?php if ($_GET['sort_order'] == "asc") echo 'selected'; ?> >น้อย->มาก </option>
            <option value="desc" <?php if ($_GET['sort_order'] == "desc") echo 'selected'; ?> >มาก->น้อย </option>
            </select>
            <input type="text" name="search" class="form-control-form-c" placeholder="ชื่อหนังสือ" <?php if ($_GET['search'] != "") echo 'value='.$_GET['search']; ?> >
            <input type="submit" class="btn btn-primary" value="ค้นหา">
        </form>
        <br>
        <?php if (empty($search)) {
        } else { ?>
            <?php
            $sort_o;
            if ($sort_order == "asc") {
                $sort_o = "น้อย->มาก";
            } else {
                $sort_o = "มาก->น้อย";
            }
            ?>
            <h3 style="text-align: center;">ค้นหาชื่อหนังสือ <?php echo " เรียงโดย " . $sort_o . " คำที่ค้นหา \"" . $search . "\""; ?></h3>

        <?php } ?>

        <hr>
        <div class="d-flex flex-wrap justify-content-sm-center">
            <?php if (count($users) > 0) : ?>
                <?php foreach ($users as $key => $user) : ?>
                    <div class="card m-3" style="width: 20rem;padding: 1rem;">
                        <img class="card-img-top" src="../image/upload/<?php echo $user['imgeBook']; ?>" alt="" height="300px" width="100px">
                        <div class="card-body">
                            <a href="../detail_book.php?idISBN=<?php echo $user['idISBN']; ?>&user=<?php echo "true";?>" class="btn btn-primary d-block">
                                <h5 class="card-text text-center overflow-auto" style="font-size: 13px; max-height: 50px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="หนังสือ : <?php echo $user['bookName']; ?>"><?php echo $user['bookName']; ?></h5>
                            </a>
                        </div>
                    </div>
                    <?php if (($key + 1) % 4 == 0) : ?>
                        <div class="w-100"></div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="text-center">No results found for "<?php echo $search; ?>"</div>
            <?php endif; ?>
        </div>

        <hr>
        <br>
        <?php if ($total_pages > 1) { ?>
            <?php if (isset($_GET['search']) && isset($_GET['sort_order'])) { ?>
                <div class="pagination">
                    <ul>
                        <?php if (count($users) > 0) : ?>
                            <li><a href='?page=1&search=<?php echo $search; ?>&sort_order=<?php echo $sort_order; ?>' class="pagination-link">หน้าแรก</a></li>
                        <?php endif; ?>
                        <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                            <li>
                                <a href='<?php echo "?page=$page&search=$search&sort_order=$sort_order"; ?>' class="pagination-link">
                                    <?php echo $page; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        <?php if (count($users) > 0) : ?>
                            <li><a href='?page=<?php echo $total_pages; ?>&search=<?php echo $search; ?>&sort_order=<?php echo $sort_order; ?>' class="pagination-link">หน้าสุดท้าย</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php } else { ?>
                <div class="pagination">
                    <ul>
                        <?php if (count($users) > 0) : ?>
                            <li><a href='?page=1' class="pagination-link">หน้าแรก</a></li>
                        <?php endif; ?>
                        <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                            <li>
                                <a href='<?php echo "?page=$page"; ?>' class="pagination-link">
                                    <?php echo $page; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        <?php if (count($users) > 0) : ?>
                            <li><a href='?page=<?php echo $total_pages; ?>' class="pagination-link">หน้าสุดท้าย</a></li>
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
    </article>

</body>

</html>