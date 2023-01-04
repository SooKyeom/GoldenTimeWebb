<?php
session_start();
//header("Content-Type: text/html; charset=utf-8");
$conn = mysqli_connect("10.1.4.110", "root", "123456", "user", 3306);
$conn->query("set session character_set_connection=utf8;");
$conn->query("set session character_set_results=utf8;");
$conn->query("set session character_set_client=utf8;");
$list_result = mysqli_query($conn, 'SELECT * FROM tb_kid');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>미아 방지 시스템</title>

    <style>
        #sideBar {
            background-color: #6c93f3; width: 200px; min-height: 100vh; position: relative; display: flex; flex-direction: column; padding-right: 0; margin-top: 0; margin-bottom: 0; list-style: none; float: right;
        }
        .sidebar-brand {
            text-decoration: none;
            color: white;
            font-size: 1rem;
            font-weight: 800;
            padding: 1.5rem 1rem;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            z-index: 1;
        }
        .sidebar-divide {
            margin: 0 1rem 1rem;
        }
        .card {
            position: relative; display: flex; flex-direction: column; min-width: 0; word-wrap: break-word; background-color: #fff; background-clip: border-box; border: 1px solid #e3e6f0; border-radius: 0.35rem;
        }
        .card-head {
            padding: 0.75rem 1.25rem; margin-bottom: 0; background-color: #f8f9fc; border-bottom: 1px solid #e3e6f0;
        }
        .card-body {
            flex: 1 1 auto; min-height: 1px; padding: 1.25rem;
        }
        .table {
            border-collapse: collapse;width: 100%;
            height: 100%;
        }
    </style>

</head>
<body>


<div id="wrapper">
    <div id="sideBar"> <!-- SideBar -->
        <a class="sidebar-brand" href="main.php">
            <div>미아위치확인시스템</div>
        </a>
        <hr class="sidebar-divide">

        <?php
        while ($row = mysqli_fetch_array($list_result)) {
            echo "<a class='sidebar-brand' href=\"?kid={$row['kid_sn']}\"><div>".'GT-00'.$row['kid_sn']."</div></a>";
//            echo "<hr class='sidebar-divide'>";
        }
        $numb = (string) $_SERVER['REQUEST_URI'];
        $num = substr($numb, 14, 2);
        ?>

        <!--        <a class="sidebar-brand">-->
        <!--            <div>gt-001</div>-->
        <!--        </a>-->
        <!--        <a class="sidebar-brand">-->
        <!--            <div>gt-002</div>-->
        <!--        </a>-->
        <!--        <a class="sidebar-brand">-->
        <!--            <div>gt-003</div>-->
        <!--        </a>-->
    </div>
    <ul class="nav justify-content-end">
        <?php
        if (isset($_SESSION['userID'])) {
            echo "{$_SESSION['userID']}님 환영합니다  ";
            ?>
            <button class="nav-item d-flex" style="float: right; margin-right: 20px" onclick="logout()">로그아웃</button>
            <?php
        } else {
            ?>

            <button class="nav-link" style="float: right; margin-right: 20px" onclick="login()">로그인</button>
            <button class="nav-link active" style="float: right; margin-right: 10px" onclick="register()">회원가입</button>


            <?php
        }
        ?>
    </ul>
    <div id="content-wrapper" style="padding-right: 1.5rem;">
        <div style="flex-basis: 0; flex-grow: 1; max-width: 100%;"> <!-- col -->
            <div style="display: flex; flex-wrap: wrap;"> <!-- row -->
                <div style="flex: 0 0 68%; max-width: 68%;">
                    <div class="card" style="margin-bottom: 10px;">
                        <div class="card-head">
                            GPS 위치 확인
                        </div>
                        <div class="card-body" id="map">
                            <!--    지도 넣기    -->

                            <div id="googleMap" style="width: 100%; height: 600px;"></div>

                            <script>
                                function myMap(){
                                    var gps = {lat: 35.8774, lng: 128.736};

                                    var mapOptions = {
                                        center: gps,
                                        zoom:18
                                    };

                                    var map = new google.maps.Map(
                                        document.getElementById("googleMap")
                                        , mapOptions );

                                    var marker = new google.maps.Marker({
                                        position: gps,
                                        map: map,
                                    });
                                }
                            </script>
                            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApykNjXopqxczFpW4EfkZIwMm5y9ms0B8&callback=myMap"></script>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-head">
                            CCTV 화면 확인
                        </div>
                        <div class="card-body">
                            <iframe width="100%" height="600px" src="https://www.youtube.com/embed/GDzBj6gzqHw?autoplay=1&mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <!--                            <iframe width="100%" height="600px" src="https://www.youtube.com/embed/-JhoMGoAfFc?autoplay=1&mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
                        </div>
                    </div>
                </div>
                <!-- <div style="flex: 0 0 2%; max-width: 2%;"> </div> -->
                <div style="width: 10px;"></div>
                <div style="flex: 0 0 30%; max-width: 30%;">
                    <div class="card">
                        <div class="card-head">
                            아동 정보 확인
                        </div>
                        <div class="card-body" style="text-align: center;">
                            <div>
                                place for child's photo <br>
                                <?php
                                $list_result = mysqli_query($conn, 'SELECT * FROM tb_kid');
                                if ($num) {
                                    for ($i = 0; $i < $num; $i++) {
                                        $row = mysqli_fetch_array($list_result);
                                    }
//                                    echo $row['upload'];
                                    /*                                    $src = "D:/xampp/htdocs/images/<?=".$row['image_name']."?>";*/
//                                    Header("Content-type:image/jpeg");
                                    echo $row['kid_nm'];
//                                    echo $row['upload'];
                                } else {
                                    echo "사진 없음";
                                }
                                ?>
                            </div>
                            <table class="table">
                                <tr>
                                    <td>
                                        이름
                                    </td>
                                    <td>
                                        <?php
                                        $list_result = mysqli_query($conn, 'SELECT * FROM tb_kid');
                                        if ($num) {
                                            for ($i = 0; $i < $num; $i++) {
                                                $row = mysqli_fetch_array($list_result);
                                            }
                                            echo $row['kid_nm'];
                                        } else {
                                            echo "아동 이름";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        성별
                                    </td>
                                    <td>
                                        <?php
                                        $list_result = mysqli_query($conn, 'SELECT * FROM tb_kid');
                                        if ($num) {
                                            for ($i = 0; $i < $num; $i++) {
                                                $row = mysqli_fetch_array($list_result);
                                            }
                                            if ($row['kid_gend'] == 'M') {
                                                echo '남자';
                                            } else if ($row['kid_gend'] == 'F') {
                                                echo '여자';
                                            }
                                        } else {
                                            echo "성별";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        생년월일
                                    </td>
                                    <td>
                                        <?php
                                        $list_result = mysqli_query($conn, 'SELECT * FROM tb_kid');
                                        if ($num) {
                                            for ($i = 0; $i < $num; $i++) {
                                                $row = mysqli_fetch_array($list_result);
                                            }
                                            $bday = (string)$row['kid_bir'];
                                            echo substr($bday, 0, 4);
                                            echo "년 ";
                                            echo substr($bday, 5, 2);
                                            echo '월 ';
                                            echo substr($bday, 8, 2);
                                            echo '일';
                                        } else {
                                            echo "생년월일";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        보호자 이름
                                    </td>
                                    <td>
                                        <?php
                                        $list_result = mysqli_query($conn, 'SELECT * FROM tb_kid');
                                        if ($num) {
                                            for ($i = 0; $i < $num; $i++) {
                                                $row = mysqli_fetch_array($list_result);
                                            }
                                            echo $row['kid_guard_nm'];
                                        } else {
                                            echo "보호자 이름";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        보호자 연락처1
                                    </td>
                                    <td>
                                        <?php
                                        $list_result = mysqli_query($conn, 'SELECT * FROM tb_kid');
                                        if ($num) {
                                            for ($i = 0; $i < $num; $i++) {
                                                $row = mysqli_fetch_array($list_result);
                                            }
                                            echo $row['kid_guard_tel1'];
                                        } else {
                                            echo "보호자 연락처1";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        보호자 연락처2
                                    </td>
                                    <td>
                                        <?php
                                        $list_result = mysqli_query($conn, 'SELECT * FROM tb_kid');
                                        if ($num) {
                                            for ($i = 0; $i < $num; $i++) {
                                                $row = mysqli_fetch_array($list_result);
                                            }
                                            if ($row['kid_guard_tel2']) {
                                                echo $row['kid_guard_tel2'];
                                            } else {
                                                echo "없음";
                                            }
                                        } else {
                                            echo "보호자 연락처2";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div style="width: 10px;"></div>
                <!-- <div style="flex: 0 0 2%; max-width: 2%;"> </div> -->
            </div>
        </div>
    </div>
</div>

<script>
    function logout() {
        console.log("hello");
        const data = confirm("로그아웃 하시겠습니까?");
        if (data) {
            location.href = "logoutProcess.php";
        }

    }
    function register() {
        location.href = "signup.php";
    }
    function login() {
        location.href = "login.php";
    }
</script>
</body>
</html>