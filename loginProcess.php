<?php
$conn = mysqli_connect("10.1.4.110", "root", "123456", "user", 3306);
//아이디 비교와 비밀번호 비교가 필요한 시점이다.
// 1차로 DB에서 비밀번호를 가져온다
// 평문의 비밀번호와 암호화된 비밀번호를 비교해서 검증한다.
$userID = $_POST['id'];
$userPass = $_POST['password'];
// 이게 입력한 아이디와 비밀번호

// DB 정보 가져오기
$sql = "SELECT * FROM user WHERE userID ='{$userID}'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);
// $hashedPassword = $row['userPass'];
$userPassword = $row['userPassword'];
$row['id'];

foreach($row as $key => $r){
    echo "{$key} : {$r} <br>";
}
// echo $row['id'];
// DB 정보를 가져왔으니
// 비밀번호 검증 로직을 실행하면 된다.
// $passwordResult = password_verify($userPass, $userPassword);
// password_verify는 우측에 hash 값만 받는다


if ($userPass == $userPassword) {
    // 로그인 성공
    // 세션에 id 저장
    session_start();
    $_SESSION['userID'] = $row['userID'];
    print_r($_SESSION);
    echo $_SESSION['userID'];

    ?>
    <script>
        alert("로그인에 성공하였습니다.")
        location.href = "main.php";
    </script>
    <?php
} else {
    // 로그인 실패
    ?>
    <script>
        alert("로그인에 실패하였습니다");
        location.href = "login.php";
    </script>
    <?php
}
?>