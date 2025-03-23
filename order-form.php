<?php
ob_start();
session_start();

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/order-form.css">

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
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Enter the code sent to your e-mail address</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">enter the code:</label>
              <input type="text" class="form-control" id="recipient-name">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Send message</button>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"> <!-- Buraya modal-dialog-centered eklendi -->
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Please do not leave empty space</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
              aria-controls="offcanvasNavbar">
              <i class="fa-solid fa-bars" style="color: white;"></i>
            </button>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
              aria-labelledby="offcanvasNavbarLabel">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                  <div class="sepet me-5 ms-2 mt-2">
                    <a href=""><i class="fa-solid fa-basket-shopping"></i></a>
                  </div>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a href="index.html" class="nav-link" aria-current="page" href="#">Store <i class="fa-solid fa-bag-shopping"></i></a>
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
                    <a href="basket.html"><i class="fa-solid fa-basket-shopping"></i></a>
                  </div>

                </form>


              </div>
            </div>
          </div>
        </nav>

      </div>
    </div>
  </div>
  <div class="container">
    <form action="" method="post">
    <div class="row justify-content-center mt-sm-5">
      <div class="col-12 col-sm-8 col-md-8 col-lg-6 form-box">
        <div class="row mt-5 mb-5 justify-content-center">
          <div class="text-box col-5">
            <input type="text" name="name" placeholder="Name">
          </div>
          <div class="text-box col-5">
            <input type="text" name="firstname" placeholder="First Name  ">
          </div>
        </div>
        <div class="row mt-5 mb-5 justify-content-center">
          <div class="text-box col-10">
            <input type="text" name="mail" placeholder="Mail Adress">
          </div>
        </div>
        <div class="row mt-5 mb-5 justify-content-center">
          <div class="text-box col-10">
            <input type="text" name="number" placeholder="Phone Number">
          </div>
        </div>
        <div class="row mt-5 mb-5 justify-content-center">
          <div class="text-box col-5">
            <input type="text" name="city" placeholder="City">
          </div>
          <div class="text-box col-5">
            <input type="text" name="district" placeholder="district">
          </div>
        </div>
        <div class="row mt-5 mb-5 justify-content-center">
          <div class="text-box col-10">
            <textarea name="adress" id="" placeholder="Adress"></textarea>
          </div>
        </div>
        <div class="row mt-5 mb-5 justify-content-center">
          <div class="text-box col-10">
            <input type="text" name="postcode" placeholder="postcode">
          </div>
          
        </div>
        
        <div class="row mb-5 justify-content-center">
          <div class="form-button col-10 text-center">
            <a href="confirim.html"><button type="submit" name="confirim">confirm order</button></a>  
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-4 col-md-4 col-lg-3 mt-0 mt-sm-0">
        <div class="row">
          <div class="col-12 basket-product">
            <div class="scroll-btn">
              <div class="bottom-btn">
                <button id="top"><i class="fa-solid fa-chevron-up"></i></button>
              </div>
              <div class="bottom-btn">
                <button id="bottom"><i class="fa-solid fa-chevron-down"></i></button>
              </div>
            </div>
            <div class="scroll-box">
            <?php
            $sql = "SELECT order_id,order_pictures, order_name, order_end, order_color, order_size, order_price 
            FROM orders 
            WHERE customer_id = :customerid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':customerid', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Sonuçları kontrol et
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch()) {
            echo '
            <div class="row justify-content-center mt-5">
              <div class="product-box col-12 col-sm-10 col-md-8 col-lg-8">
                <div class="row justify-content-center">
                  <div class="basket-product-image col-10">
                     <img src="admin/' . htmlspecialchars($row["order_pictures"]) . '" alt="Ürün Resmi" width="100">
                  </div>
                  <div class="basket-product-text col-12 text-center">
                    €' .htmlspecialchars($row["order_price"]) . '
                  </div>
                </div>
              </div>

            </div>
              ';
              if(isset($_POST["confirim"])){
                $customer_id = $user_id; // Kullanıcı ID'si (Daha önce tanımlanmış olmalı)
                $customer_name = $_POST["name"];
                $customer_firstname = $_POST["firstname"];
                $customer_mail = $_POST["mail"];
                $customer_number = $_POST["number"];
                $customer_city = $_POST["city"];
                $customer_district = $_POST["district"];
                $customer_adress = $_POST["adress"];
                $customer_postacode = $_POST["postcode"];
                
                // Veritabanından çekilen sipariş bilgileri (Daha önce $row değişkeni dolu olmalı)
                $order_pictures = $row["order_pictures"];
                $order_name = $row["order_name"];
                $order_color = $row["order_color"];
                $order_size = $row["order_size"];
                $order_price = $row["order_price"];
        
                $sql = "INSERT INTO confirmed_orders 
                    (customer_id, customer_name, customer_firstname, customer_mail, customer_number, customer_city,customer_distric, customer_adress, customer_postacode, order_pictures, order_name,order_color, order_size, order_price) 
                    VALUES 
                    (:id_customer, :customer_name, :customer_firstname, :customer_mail, :customer_number, :customer_city, :customer_district, :customer_adress, :customer_postacode, :order_pictures, :order_name, :order_color, :order_size, :order_price)";
        
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindParam(':id_customer', $customer_id);
                $stmt->bindParam(':customer_name', $customer_name);
                $stmt->bindParam(':customer_firstname', $customer_firstname);
                $stmt->bindParam(':customer_mail', $customer_mail);
                $stmt->bindParam(':customer_number', $customer_number);
                $stmt->bindParam(':customer_city', $customer_city);
                $stmt->bindParam(':customer_district', $customer_district);
                $stmt->bindParam(':customer_adress', $customer_adress);
                $stmt->bindParam(':customer_postacode', $customer_postacode);
                $stmt->bindParam(':order_pictures', $order_pictures);
                $stmt->bindParam(':order_name', $order_name);
                $stmt->bindParam(':order_color', $order_color);
                $stmt->bindParam(':order_size', $order_size);
                $stmt->bindParam(':order_price', $order_price);
        
                $stmt->execute();
        
                header('Location: confirim.html');
                exit();
                }
              }
        }  else {
          
        }
    

?>
          </div>
        </div>
        </div>
        <div class="row justify-content-center">
        <div class="total-price col-12">
          <div class="total-text col-12 text-center mt-2">
            <?php
    $sql = "SELECT COUNT(*) AS toplam FROM orders WHERE customer_id = :user_id";
    $stmt = $pdo->prepare($sql);

    // user_id değişkenini bağla
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // Sorguyu çalıştır
    $stmt->execute();

    // Sonucu al ve yazdır
    $row = $stmt->fetch();
    echo "items in cart(".$row['toplam'].")";
?>
          </div>
          <div class="total-text col-12 text-center mt-2">
            <?php
    $sql = "SELECT SUM(order_price) AS toplam_fiyat FROM orders WHERE customer_id = :user_id";
    $stmt = $pdo->prepare($sql);

    // user_id değişkenini bağla
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // Sorguyu çalıştır
    $stmt->execute();

    // Sonucu al ve yazdır
    $row = $stmt->fetch();
    echo "total order amount:€" . number_format($row['toplam_fiyat'], 2); // İki ondalık basamak ile göster
?>
          </div>
        </div>
        </div>
      </div>
      </form>
    </div>
  </div>
  <script src="js/order-form.js"></script>
</body>

</html>