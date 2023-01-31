<?php
session_start();
require_once '../server.php';
unset($_SESSION['urole_admin']);
unset($_SESSION['urole_user']);

if (isset($_POST['signin'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        echo "<br>";
        if (empty($username)){
            $_SESSION['error_username'] = 'กรุณากรอก username';
            //header("location: ../home_index.php");
        }else if (!preg_match("/^[a-zA-Z0-9_]*$/",$username)){
            $_SESSION['error_username'] = 'รูปแบบusernameไม่ถูกต้องห้ามมีอักขระพิเศษยกเว้น _ และห้ามใช้ภาษาไทย';
            //header("location: ../home_index.php");
        }
        if (empty($password)){
            $_SESSION['error_password'] = 'กรุณากรอก password';
            //header("location: ../home_index.php");
        }else if (!preg_match("/^[a-zA-Z0-9_]*$/",$password)){
            $_SESSION['error_password'] = 'รูปแบบpasswordไม่ถูกต้องห้ามมีอักขระพิเศษยกเว้น _ และห้ามใช้ภาษาไทย';
            //header("location: ../home_index.php");
        }

        if (isset($_SESSION['error_username']) or isset($_SESSION['error_password'])) {
            header("location: ../home_index.php");
        }
        else{
            try {
                //code...
                $checkUsername = $conn->prepare("SELECT * FROM `user_account` WHERE Username = :username ");//$userName
                $checkUsername->bindParam(":username",$username);
                $checkUsername->execute();
                $row = $checkUsername->fetch(PDO::FETCH_ASSOC);
                if ($checkUsername->rowCount() > 0) {
                    # code...
                    if ($username == $row['Username']) {
                        # code...
                        echo "มีชื่อนี้อยู่ในระบบ <br>";
                        echo implode(", ",$row)."<br>";
                        if ($password==$row['Userpassword']) {
                            # code...
                            echo "รหัสผ่านถูก <br>";
                            if ($row['Username']== "admin") {
                                # code...
                                $_SESSION['urole_admin'] = $row['Username'];
                                echo $row['Username']." ตำแหน่ง admin <br>";
                                //echo '<a href="../admin/ad_index.php"> เข้าสู่ระบบ </a>';
                                header("location: ../admin/ad_index.php");
                            }else{
                                $_SESSION['urole_user'] = $row['Username'];
                                echo $row['Username']." ตำแหน่ง user <br>";
                                //echo '<a href="../user/user_index.php"> เข้าสู่ระบบ </a>';
                                header("location: ../user/user_index.php");
                            }
                        }else{
                            echo "รหัสผ่านไม่ถูก";
                            $_SESSION['error_password'] = 'รหัสผ่านไม่ถูก';
                            header("location: ../home_index.php");
                        }
                    }
                }else {
                    echo "ไม่มีชื่อนี้อยู่ในระบบ";
                    $_SESSION['error_username'] = 'ไม่มีชื่ออยู่ในระบบ';
                    header("location: ../home_index.php");
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>