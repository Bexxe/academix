<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "academix";

// Veritabanı bağlantısını oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı hatası kontrolü
if ($conn->connect_error) {
    header('Location: error.html');
    exit();
}

// Kullanıcının benzersiz kimliği (cookie)
if (!isset($_COOKIE["user_id"])) {
    $user_id = uniqid('user_', true);
    setcookie("user_id", $user_id, time() + (86400 * 365), "/");
} else {
    $user_id = $_COOKIE["user_id"];
}

$_SESSION['user_id'] = $user_id;

// Kullanıcı IP adresini al
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ip_list[0]); // İlk IP'yi al
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

$user_ip = getUserIP();

// Eğer localhost (::1) ise, hata sayfasına yönlendir
if ($user_ip == '::1') {

}

// Kullanıcı daha önce kayıtlı mı?
$sql_check = "SELECT * FROM customers WHERE customer_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $user_id);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows == 0) {
    // Kullanıcı yoksa, ekleyelim
    $sql_insert = "INSERT INTO customers (customer_id, ip_adress) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ss", $user_id, $user_ip);

    if (!$stmt_insert->execute()) {
        header('Location: error.html');
        exit();
    }
}

// Bağlantıyı kapat
$conn->close();
$host = 'localhost';
$db   = 'academix';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="css/style.css">

</head>
<body>
<div class="container">
  <div class="loader-box" id="loader">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="loader-image col-4 col-sm-3 col-md-2 col-lg-2 col-xl-1">
                <img src="image/bisiler/bags.png" alt="">
            </div>
            <div class="ruj-image col-4 col-sm-3 col-md-2 col-lg-2 col-xl-1" id="ruj">
                <img src="image/bisiler/ruj.png" alt="">
            </div>
            <div class="book-image col-4 col-sm-3 col-md-2 col-lg-2 col-xl-1" id="book">
                <img src="image/bisiler/book).png" alt="">
            </div>
            <div class="baget-image col-4 col-sm-3 col-md-2 col-lg-2 col-xl-1" id="baget">
                <img src="image/bisiler/baget.png" alt="">
            </div>
            <div class="pencil-image col-sm-3 col-md-2 col-lg-2 col-4 col-xl-1" id="pencil">
                <img src="image/bisiler/pencil.png" alt="">
            </div>
        </div>
      </div>
    </div>
<div c lass="container-sm-fluid">
<div class="row">
    <div class="col-3 col-lg-1 logo">
        <img src="image/logo/462405421_1052763809588442_5817094361318322125_n.jpg" alt="">
    </div>
    <div class="col-9 col-lg-11">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
              <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <i class="fa-solid fa-bars" style="color: white;"></i>
              </button>
          
              <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                  <div class="sepet me-5 ms-2 mt-2">
                    <a href=""><i class="fa-solid fa-basket-shopping"></i>
                      <div class="nokta">
                        <?php
    $sql = "SELECT COUNT(*) AS toplam FROM orders WHERE customer_id = :user_id";
    $stmt = $pdo->prepare($sql);

    // user_id değişkenini bağla
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // Sorguyu çalıştır
    $stmt->execute();

    // Sonucu al ve yazdır
    $row = $stmt->fetch();
    echo $row['toplam'];
?>
                      </div>
                    </a>
                  </div>
                </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item activ">
                      <a class="nav-link text-black" aria-current="page" href="#">Store <i class="fa-solid fa-bag-shopping"></i></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">
                        About us <i class="fa-solid fa-book"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact <i class="fa-solid fa-phone"></i></a>
                      </li>
  


                  </ul>
                  <form class="d-flex" role="">
                  <div class="sepet me-5 ms-2 mt-2 d-none d-lg-block">
                    <a href="basket.php"><i class="fa-solid fa-basket-shopping"></i>
                      <div class="nokta">
                      <?php
    $sql = "SELECT COUNT(*) AS toplam FROM orders WHERE customer_id = :user_id";
    $stmt = $pdo->prepare($sql);

    // user_id değişkenini bağla
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // Sorguyu çalıştır
    $stmt->execute();

    // Sonucu al ve yazdır
    $row = $stmt->fetch();
    echo $row['toplam'];
?>
                      </div>
                    </a>
                  </div>
                    
                </form>
                
                
                </div>
              </div>
            </div>
          </nav>
          
    </div>
</div>
</div>


<div class="row g-0 justify-content-center bags">
  <div class="bag col-12 col-lg-6 col-xl-4" id="bag">
      <div class="row g-0">
          <div class="bag-img col-12" id="bagimg">  
              <img src="image/slider/bags/3804c36a-8f87-4c99-bd1e-0ea54cafe173.jpg" alt="">
          </div>
          <div class="col-12 bag-text text-center" id="bagtext">
            get more information
           <div class="bag-btn mt-5">
            <a href="bag.php"><button>BUY <i class="fa-solid fa-money-bill-wave"></i></button></a>
           </div>
          </div>
      </div>
  </div>
  <div class="bag col-12 col-lg-6 col-xl-4" id="bag-2">
    <div class="row g-0">
        <div class="bag-img col-12" id="bagimg">
            <img src="image/slider/bags/b886aae5-68dc-4a9c-8c05-84423d5f6209.jpg" alt="">
        </div>
        <div class="col-12 bag-text text-center" id="bagtext-2">
          sajkfopsafsakfpğsafasfpj
         <div class="bag-btn mt-5">
          <a href="bag.php"><button>BUY <i class="fa-solid fa-money-bill-wave"></i></button></a>
         </div>
        </div>
    </div>
</div>
</div>


<div class="row responsive-bags">
  <div class="responsive-bag col-12">
    <div class="respo-bag-img col-12">
      <img src="image/slider/backgraound/IG Post 1  producten (1).png" alt="">
    </div>
<div class="row box" id="box">
      <div class="respo-bag col-12 col-sm-8 col-md-6" id="kahverengiimg">
      <img src="image/slider/bags_png/Ontwerp zonder titel (2).png" alt="">
      <div class="text-center bag-btn-box mt-5">
        <a href=""><button>BUY <i class="fa-solid fa-money-bill-wave"></i></button></a>
       </div>
    </div>
    <div class="respo-bag col-12 col-sm-8 col-md-6" id="siyahimg">
      <img src="image/slider/bags_png/Ontwerp zonder titel.png" alt="">
      <div class="text-center bag-btn-box mt-5">
        <a href=""><button>BUY <i class="fa-solid fa-money-bill-wave"></i></button></a>
       </div>
    </div>
    <div class="respo-bag col-12 col-sm-8 col-md-6" id="beyazimg">
      <img src="image/slider/bags_png/Ontwerp zonder titel (1).png" alt="">
      <div class="text-center bag-btn-box mt-5">
        <a href=""><button>BUY <i class="fa-solid fa-money-bill-wave"></i></button></a>
       </div>
    </div>
</div>
    <div class="next-btn">
      <button type="button" id="nextbtn"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
    <div class="back-btn">
      <button type="button" id="backbtn"><i class="fa-solid fa-chevron-left"></i></button>
    </div>
  </div>
</div>


<script src="js/script.js"></script>
</body>
</html>