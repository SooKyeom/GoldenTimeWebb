<?php
$conn = mysqli_connect("10.1.4.110", "root", "123456", "user" ,3306);
// $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
// echo $hashedPassword;
$sql = "
    INSERT INTO user
    (userID, userPassword, userNAME, userAge)
    VALUES('{$_POST['id']}', '{$_POST['password']}', '{$_POST['name']}', '{$_POST['tel']}'
    );";
echo $sql;
$result = mysqli_query($conn, $sql);


if ($result === false) {
    echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
    echo mysqli_error($conn);
} else {
    ?>
    <script>
        alert("회원가입이 완료되었습니다");
        location.href = "login.php";
    </script>
    <?php
}
?>