<?php
ob_start();
session_start();

// Veritabanı bağlantı bilgileri
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
    // PDO bağlantısını oluştur
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
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

// Kullanıcının ID'sini oturuma kaydet
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

// Eğer localhost (::1) ise, hata sayfasına yönlendir (isteğe bağlı)
if ($user_ip == '::1') {
    // header('Location: error.html');
    // exit();
}

// Kullanıcı daha önce kayıtlı mı?
$sql_check = "SELECT COUNT(*) FROM customers WHERE customer_id = :customer_id";
$stmt_check = $pdo->prepare($sql_check);
$stmt_check->bindParam(':customer_id', $user_id, PDO::PARAM_STR);
$stmt_check->execute();
$user_exists = $stmt_check->fetchColumn();

if (!$user_exists) {
    // Kullanıcı yoksa, ekleyelim
    $sql_insert = "INSERT INTO customers (customer_id, ip_adress) VALUES (:customer_id, :ip_adress)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->bindParam(':customer_id', $user_id, PDO::PARAM_STR);
    $stmt_insert->bindParam(':ip_adress', $user_ip, PDO::PARAM_STR);
    if (!$stmt_insert->execute()) {
        header('Location: error.html');
        exit();
    }
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
    <link rel="stylesheet" href="css/basket-none.css">
    
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
                          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">                   <div class="sepet me-5 ms-2 mt-2">
                            <a href=""><i class="fa-solid fa-basket-shopping"></i><div class="nokta">                            <?php
    $sql = "SELECT COUNT(*) AS toplam FROM orders WHERE customer_id = :user_id";
    $stmt = $pdo->prepare($sql);

    // user_id değişkenini bağla
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // Sorguyu çalıştır
    $stmt->execute();

    // Sonucu al ve yazdır
    $row = $stmt->fetch();
    echo $row['toplam'];
?></div></a>
                           </div></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                              <a class="nav-link" aria-current="page" href="index.php">Store <i class="fa-solid fa-bag-shopping"></i></a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#">About us <i class="fa-solid fa-book"></i></a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#">Contact <i class="fa-solid fa-phone"></i></a>
                            </li>
                          </ul>
                          
                          <form class="d-flex" role="">
                            <div class="sepet me-5 ms-2 mt-2 d-none d-lg-block">
                                <a href=""><i class="fa-solid fa-basket-shopping"></i><div class="nokta">
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
                                </div></a>
                            </div>
                        </form>
                        
                        
                        </div>
                      </div>
                    </div>
                  </nav>
                  
            </div>
        </div>
        </div>
        ç<div class="container">
            <div class="row">
                <div class="basket-box col-12">
                    <div class="basket-product col-12">
<div class="row">
    <div class="visual col-5 col-lg-2 text-center">
        <div class="visual-image">  
            <i class="fa-solid fa-weight-hanging"></i>
        </div>
    </div>
    <div class="product-text col-7 col-lg-7 d-flex justify-content-center align-items-center">
        Tthere are no items in the basket
    </div>
    <div class="look-btn col-12 col-lg-3 mt-5 mt-lg-0 d-flex justify-content-center align-items-center">
       <a href="index.php"><button id="lookbtn">browse the bags <i id="eyes" class="fa-solid fa-face-smile-beam"></i></i><i id="face" class="fa-solid fa-face-grin-stars"></i></button>
       </div></a>
</div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="total-price-box col-12">
                <div class="summary-text col-12 text-center">order summary</div>
                <div class="cizgi col-12 my-4"></div>
                <div class="row">
                    <div class="total-order col-5">number of products in cart:</div>
                    <div class="total-order col-2 text-center">0</div>
                </div>
                <div class="cizgi col-12 my-4"></div>
                <div class="row mb-4 mb-md-0">
                    <div class="total-order col-5">
                        total order amount:</div>
                    <div class="total-order col-2 text-center">€0</div>
                </div>
                </div>
                <div class="row me-lg-5 confirim">
                  <div class="confirm-order-btn col-12">
                    <a href="#"><button>confirm order <i class="fa-solid fa-clipboard-check"></i></button></a>
                  </div>
                 </div>
            </div>
        </div>
        <script src="js/basket-none.js"></script>
</body>
</html>