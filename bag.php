<?php
error_reporting(0);
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "academix";

// MySQLi bağlantısı oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
  header('Location: error.html');
  exit();
}

// Kullanıcı ID belirleme (Çerez kullanımı)
if (!isset($_COOKIE["user_id"])) {
  $user_id = uniqid('user_', true);
  setcookie("user_id", $user_id, time() + (86400 * 365), "/"); // 1 yıl boyunca geçerli
} else {
  $user_id = $_COOKIE["user_id"];
}

$_SESSION['user_id'] = $user_id;

// Kullanıcı IP adresini al
function getUserIP()
{
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

// Kullanıcı zaten var mı kontrol et
$stmt = $conn->prepare("SELECT * FROM customers WHERE customer_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  $stmt_insert = $conn->prepare("INSERT INTO customers (customer_id, ip_adress) VALUES (?, ?)");
  $stmt_insert->bind_param("ss", $user_id, $user_ip);
  $stmt_insert->execute();
  $stmt_insert->close();
}

// Veritabanı bağlantısını kapat
$stmt->close();
$conn->close();

// PDO ile veritabanı bağlantısı
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

// Varsayılan renk ve boyut
$_SESSION['selectedColor'] = $_SESSION['selectedColor'] ?? 'naturel';
$_SESSION['selectedSize'] = $_SESSION['selectedSize'] ?? 'large';

// POST ile gelen verileri güncelle
if (isset($_POST['selectedColor']) && in_array($_POST['selectedColor'], ['naturel', 'black'])) {
  $_SESSION['selectedColor'] = $_POST['selectedColor'];
}

if (isset($_POST['selectedSize']) && in_array($_POST['selectedSize'], ['large', 'small'])) {
  $_SESSION['selectedSize'] = $_POST['selectedSize'];
}

// ID işlemleri (sayısal olmayan karakterleri temizleme)
if (isset($_POST['selectedID'])) {
  $ID = (int) preg_replace('/\D/', '', $_POST['selectedID']); // Sadece sayısal değerleri al
  $_SESSION['selectedID'] = max(0, $ID); // Negatifse 0 yap
}

// Değerleri değişkenlere ata
$color = $_SESSION['selectedColor'];
$size = $_SESSION['selectedSize'];
$ID = $_SESSION['selectedID'] ?? null;
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
  <link rel="stylesheet" href="css/bag.css">

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

  <div class="container">
    <div class="row mt-5">
      <div class="class col-12">
        <div class="row slider justify-content-center">
          <div class="bag-slider col-12 col-sm-10 col-md-6 col-lg-6">
            <div id="myCarousel" class="carousel">
              <div class="carousel-images">
                <?php

                // LIKE komutu kullanarak sorgu
                $query = "SELECT pictures, product_id FROM bags WHERE product_color LIKE :color AND product_size LIKE :size LIMIT 1";
                $stmt = $pdo->prepare($query);

                // Kullanıcıdan gelen renk ve boyut verisini LIKE ile eşleşmesi için yazıyoruz
                $colorPattern = '%' . $color . '%';  // Kısmi eşleşme için pattern ekleniyor
                $sizePattern = '%' . $size . '%';  // Kısmi eşleşme için pattern ekleniyor

                $stmt->execute(['color' => $colorPattern, 'size' => $sizePattern]);

                // İlk öğeyi al
                $row = $stmt->fetch();
                if ($row) {
                } else {
                  echo '
  <form method="post">
  <div id="popupBox" class="popup-overlay">
      <div class="popup-box">
          <div class="popup-text">This color and size bag is out of stock</div>
          <button class="close-btn" type="submit" name="close_btn">Close</button>
      </div>
  </div>
  </form>
  ';
                }



                if ($ID == 0) {
                  $query = "SELECT pictures, product_id FROM bags WHERE product_color = :color AND product_size = :size LIMIT 1";
                  $stmt = $pdo->prepare($query);
                  $stmt->execute(['color' => $color, 'size' => $size]);

                  $row = $stmt->fetch(); // İlk öğeyi al
                  if ($row) {
                    echo '
        <img id="" class="" src="admin/' . $row['pictures'] . '" alt="">
        ';
                  }
                } else {
                  $query = "SELECT pictures FROM bags WHERE product_id = :ID";
                  $stmt = $pdo->prepare($query);
                  $stmt->execute(['ID' => $ID]);

                  // Satır varsa resmi döndür
                  if ($row = $stmt->fetch()) {
                    echo '
        <img id="" class="" src="admin/' . $row['pictures'] . '" alt="">
        ';
                  } else {
                    // Resim bulunamadığında yapılacak işlemler
                  }
                }
                ?>



              </div>
            </div>


            <div class="end-bags-sm">
              <div class="row mt-5 mb-5 justify-content-start">
                <div class="end-bags col-10">
                  <?php
                  if ($ID == 0) {
                    $query = "SELECT product_end, product_id FROM bags WHERE product_color = :color AND product_size = :size LIMIT 1";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute(['color' => $color, 'size' => $size]);

                    $row = $stmt->fetch(); // İlk öğeyi al
                    if ($row) {
                      echo "Last " . $row['product_end'] . " products from this model";
                    }
                  } else {
                    $query = "SELECT product_end FROM bags WHERE product_id = :ID";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute(['ID' => $ID]);

                    // Satır varsa resmi döndür
                    if ($row = $stmt->fetch()) {
                      echo "Last " . $row['product_end'] . " products from this model";
                    } else {
                      // Resim bulunamadığında yapılacak işlemler
                    }
                  }
                  ?>
                </div>
              </div>
            </div>

          </div>
          <div class="col-12 col-md-6 col-lg-6">
            <div class="bags-header mb-5 mt-2">
              <?php
              if ($ID == 0) {
                $query = "SELECT product_name, product_id FROM bags WHERE product_color = :color AND product_size = :size LIMIT 1";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['color' => $color, 'size' => $size]);

                $row = $stmt->fetch(); // İlk öğeyi al
                if ($row) {
                  echo "" . $row['product_name'] . "";
                }
              } else {
                $query = "SELECT product_name FROM bags WHERE product_id = :ID";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['ID' => $ID]);

                // Satır varsa resmi döndür
                if ($row = $stmt->fetch()) {
                  echo "" . $row['product_name'] . "";
                } else {
                  // Resim bulunamadığında yapılacak işlemler
                }
              }
              ?>
            </div>

            <div class="row justify-content-center">
              <div class="bags-color-select col-10 col-md-9 col-lg-6 mb-5 mb-lg-0">
                <div class="row bag-header mb-2">
                  <div class="bag-header-color col-12 col-lg-10">
                    COLOR <i class="fa-solid fa-droplet"></i>
                  </div>
                </div>


                <div class="bag-color col-10 col-md-12 col-lg-10">
                  <div class="row">
                    <div class="col-6">
                      <img id="naturel" src="image/slider/bags/3804c36a-8f87-4c99-bd1e-0ea54cafe173.jpg" alt="">
                    </div>
                    <div class="col-6">
                      <img id="black" src="image/slider/bags/b886aae5-68dc-4a9c-8c05-84423d5f6209.jpg" alt="">
                    </div>

                  </div>
                </div>
              </div>

              <div class="bags-color-select col-10 col-md-9 col-lg-6 ">
                <div class="row bag-header mb-2">
                  <div class="bag-header-dimenson col-12 col-lg-10 text-lg-end">
                    <i class="fa-solid fa-weight-hanging"></i> SİZE
                  </div>
                </div>
                <div class="bag-dimension col-10 col-md-12 col-lg-10">
                  <div class="row justify-content-end">
                    <div class="col-6">
                      <img id="large" src="image/bags/Kopie van IG Post 1  producten.png" alt="">
                    </div>
                    <div class="col-6">
                      <img id="small" src="image/bags/Kopie van IG Post 1  producten (1).png" alt="">
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="row justify-content-start mt-4">
              <div class="bags-color-select col-12 col-md-12 col-lg-12 mb-5 mb-lg-0">
                <div class="row bag-header mb-2">
                  <div class="bag-header-color col-12 col-lg-10">
                    Models <i class="fa-solid fa-bag-shopping"></i>
                  </div>
                </div>


                <div class="bag-model col-12 col-md-12 col-lg-10">
                  <div class="row">
                    <?php
                    $query = "SELECT pictures,product_id FROM bags WHERE product_color = :color AND product_size = :size";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute(['color' => $color, 'size' => $size]);

                    while ($row = $stmt->fetch()) {
                      echo '
                        <div class="col-4 col-md-4 col-lg-3 mt-2">
                         <img id="model-' . $row['product_id'] . '" class="model" src="admin/' . $row['pictures'] . '" alt="" data-value="' . $row['product_id'] . '">
                    </div>
      ';
                    }
                    ?>

                  </div>
                </div>
              </div>

            </div>

            <div class="end-bags-lg">
              <div class="row mt-5 mb-5 end">
                <div class="end-bags col-10 col-lg-8 col-xl-6">
                  <?php
                  if ($ID == 0) {
                    $query = "SELECT product_end, product_id FROM bags WHERE product_color = :color AND product_size = :size LIMIT 1";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute(['color' => $color, 'size' => $size]);

                    $row = $stmt->fetch(); // İlk öğeyi al
                    if ($row) {
                      echo "Last " . $row['product_end'] . " products from this model";
                    }
                  } else {
                    $query = "SELECT product_end FROM bags WHERE product_id = :ID";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute(['ID' => $ID]);

                    // Satır varsa resmi döndür
                    if ($row = $stmt->fetch()) {
                      echo $row['product_end'] . " products from this model";
                    } else {
                      // Resim bulunamadığında yapılacak işlemler
                    }
                  }
                  ?>
                </div>
              </div>
            </div>


            <div class="price-tag-lg">
              <div class="row price">
                <div class="col-8 cpl-md-8 col-lg-6 col-xl-4 price-tag">
                  <div class="col-12 tag-img">
                    <img src="image/bisiler/tag.png" alt="">
                  </div>
                  <div class="col-12 tag-text text-center">
                    <?php
                    if ($ID == 0) {
                      $query = "SELECT product_price, product_id FROM bags WHERE product_color = :color AND product_size = :size LIMIT 1";
                      $stmt = $pdo->prepare($query);
                      $stmt->execute(['color' => $color, 'size' => $size]);

                      $row = $stmt->fetch(); // İlk öğeyi al
                      if ($row) {
                        echo "€" . $row['product_price'] . "";
                      }
                    } else {
                      $query = "SELECT product_price FROM bags WHERE product_id = :ID";
                      $stmt = $pdo->prepare($query);
                      $stmt->execute(['ID' => $ID]);

                      // Satır varsa resmi döndür
                      if ($row = $stmt->fetch()) {
                        echo "€" . $row['product_price'] . "";
                      } else {
                        // Resim bulunamadığında yapılacak işlemler
                      }
                    }
                    ?>
                  </div>
                </div>

              </div>
            </div>

            <div class="basket-btn-lg">
              <div class="row basket">
                <div class="col-10 col-md-10 col-lg-8 col-xl-6 basket-button text-center mb-5 mt-5 mt-lg-0 ms-md-4">
                  <form id="selectionForm" method="post">
                    <input type="hidden" id="selectedColor" name="selectedColor" value="<?= $color ?>">
                    <input type="hidden" id="selectedSize" name="selectedSize" value="<?= $size ?>">
                    <input type="hidden" id="selectedID" name="selectedID" value="<?= $ID ?>">
                    <button type="submit" id="submitSelection" style="display: none;"></button>
                    <button id="basketbtn" type="submit" name="basket_btn">
                      <i id="basket" class="fa-solid fa-cart-shopping"></i> Add to Cart
                    </button>
                  </form>


                  <?php
                  if (isset($_POST['basket_btn'])) {
                    if ($ID == 0) {
                      echo '
      <form method="post">
      <div id="popupBox" class="popup-overlay">
          <div class="popup-box">
              <div class="popup-text">please select the model</div>
              <button class="close-btn" type="submit" name="close_btn">Close</button>
          </div>
      </div>
      </form>
      ';
                    } else {
                      // Veritabanı bağlantı bilgileri
                      $servername = "localhost";
                      $username = "root";
                      $password = "";
                      $dbname = "academix";

                      try {
                        // PDO ile veritabanına bağlan
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        // Hata modunu ayarla
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $sql = "SELECT pictures, product_end, product_name, product_color, product_size, product_price FROM bags WHERE product_id = :ID";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
                          // Her satırı döngü ile oku
                          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $customerid = $_SESSION['user_id'];
                            $order_pictures = $row["pictures"];
                            $product_end = $row["product_end"];
                            $product_name = $row["product_name"];
                            $productcolor = $row["product_color"];
                            $product_size = $row["product_size"];
                            $product_price = $row["product_price"];

                            // Stok kontrolü
                            if ($product_end == 0) {
                              echo '
                      <form method="post">
                      <div id="popupBox" class="popup-overlay">
                          <div class="popup-box">
                              <div class="popup-text">We are out of stock of this bag.</div>
                              <button class="close-btn" type="submit" name="close_btn">Close</button>
                          </div>
                      </div>
                      </form>
                      ';
                            } else {
                              // Siparişi ekle
                              $sql_insert = "INSERT INTO orders (order_id, customer_id, order_pictures, order_name, order_end, order_color, order_size, order_price) 
                        VALUES ('', :customerid, :order_pictures, :order_name, :order_end, :order_color, :order_size, :order_price)";

                              $stmt_insert = $conn->prepare($sql_insert);
                              $stmt_insert->bindParam(':customerid', $customerid, PDO::PARAM_STR);
                              $stmt_insert->bindParam(':order_pictures', $order_pictures, PDO::PARAM_STR);
                              $stmt_insert->bindParam(':order_name', $product_name, PDO::PARAM_STR);
                              $stmt_insert->bindParam(':order_end', $product_end, PDO::PARAM_INT);
                              $stmt_insert->bindParam(':order_color', $productcolor, PDO::PARAM_STR);
                              $stmt_insert->bindParam(':order_size', $product_size, PDO::PARAM_STR);
                              $stmt_insert->bindParam(':order_price', $product_price, PDO::PARAM_STR);

                              if ($stmt_insert->execute()) {
                                echo '
                          <form method="post">
                          <div id="popupBox" class="popup-overlay">
                              <div class="popup-box">
                                  <div class="popup-text">product added to cart</div>
                                  <button class="close-btn" type="submit" name="close_btn">Close</button>
                              </div>
                          </div>
                          </form>
                          ';
                              } else {
                                echo "Hata: " . $sql_insert . "<br>" . $conn->errorInfo();
                              }
                            }
                          }
                        } else {
                          echo "Sonuç bulunamadı.";
                        }
                      } catch (PDOException $e) {
                        echo "Veritabanı bağlantı hatası: " . $e->getMessage();
                      }

                      // Bağlantıyı kapat
                      $conn = null;
                    }
                  }
                  ?>




                </div>
              </div>
            </div>

          </div>
        </div>
      </div>


      <script src="js/bag.js"></script>
</body>

</html>