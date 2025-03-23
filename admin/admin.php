<?php
ob_start();
// MySQL veritabanı bağlantı bilgileri
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "academix";

// Veritabanı bağlantısı
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_POST["closebtn"])){
    header("Refresh: 0");


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
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <nav class="navbar navbar-dark fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel"><img
                            src="../image/logo/462405421_1052763809588442_5817094361318322125_n.jpg" alt=""></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link text-black" aria-current="page" href="#"><i class="fa-solid fa-user"></i>
                                account</a>
                        </li>
                        <li class="nav-item activ">
                            <a class="nav-link text-black" href="#"><i class="fa-solid fa-bag-shopping"></i>
                                products</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <div class="container">
        <div class="row justify-content-center bags">
            <div class="bags-box col-12 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                <div class="bags-image">
                    <img src="../image/bags/Kopie van IG Post 1  producten.png" alt="">
                </div>

            </div>
            <div class="bags-task col-12 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                <form action="" method="post">
                    <div class="bags-pictures">
                        <div class="row">
                            <?php
                            try {
                                // Database connection (PDO)
                                $pdo = new PDO("mysql:host=localhost;dbname=academix", "root", "");
                                // Set error mode
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                // SQL Query
                                $sql = "SELECT product_id, pictures FROM bags WHERE product_color = 'naturel' AND product_size = 'large'";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();

                                // Fetch the data
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($result) {
                                    foreach ($result as $row) {
                                        echo '<div class="pictures col-4 mt-3">';
                                        echo '<button name="imagebtn" id="btn-' . $row["product_id"] . '" type="submit  " class="btn-image"><img src="'. $row["pictures"].'" alt="" class="img-thumb"></button>';
                                        echo '<input type="checkbox" name="onay" value="' . $row["product_id"] . '" id="checkbox-' . $row["product_id"] . '" style="display:none;">';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "No data found.";
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }

                            // Close connection
                            $pdo = null;
                            ?>


                        </div>
                    </div>
                </form>
                <div class="bags-header mt-3">
                    <div class="row">
                        <form id="myForm" action="" method="post" enctype="multipart/form-data">
                            <?php
                            if (isset($_POST['onay'])) {
                                try {
                                    // Database connection (PDO)
                                    $pdo = new PDO("mysql:host=localhost;dbname=academix", "root", "");
                                    // Set error mode
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    // SQL Query
                                    $product_id = $_POST["onay"];
                                    $sql = "SELECT product_id, pictures,product_end,product_name,product_price FROM bags WHERE product_id = $product_id";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();

                                    // Fetch the data
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if ($result) {
                                        foreach ($result as $row) {
                                            echo '
                                            
                            <input type="file" name="imageNL" id="image" accept="image/*"><br>
                            <input type="hidden" name="productid" value="' . $row["product_id"] . '">
                            <label for="">Bag description:</label><br>
                            <textarea id="commenttextNL" name="commenttextNL">' . $row["product_name"] . '</textarea><br>
                            <label for="">left Bags:</label><br>
                            <input name="endtextboxNL" id="endtextboxNL" type="text" value="' . $row["product_end"] . '"><br>
                            <label for="">Price:</label><br>
                            <input name="pricetextboxNL" id="pricetextboxNL" type="text" value="' . $row["product_price"] . '"><br>
                                            
                                            
                                            ';
                                        }
                                    } else {
                                        echo "No data found.";
                                    }
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }

                                // Close connection
                                $pdo = null;
                            } else {
                                echo '
                                            
                                <input type="file" name="imageNL" id="image" accept="image/*"><br>
                                <label for="">Bags comment:</label><br>
                                <textarea name="commenttextNL" id="commenttextNL"></textarea><br>
                                <label for="">End Bags:</label><br>
                                <input name="endtextboxNL" type="text" id="endtextboxNL"><br>
                                <label for="">Price:</label><br>
                                <input name="pricetextboxNL" type="text" id="pricetextboxNL"><br>
                                                
                                                
                                                ';
                            }
                            ?>
                            <div class="bags-btn">
                                <div class="row">
                                    <div class="btn col-4 mt-3">
                                    <button name="addbtnNL" type="submit" class="btn btn-primary" id="submitBtn" disabled>Add</button>

                                        <?php
                                        if (isset($_POST['addbtnNL'])) {
                                            // Formdan gelen verileri alıyoruz
                                            $commenttextNL = $_POST['commenttextNL'];  // Metin verisi
                                            $endtextboxNL = $_POST['endtextboxNL'];
                                            $pricetextboxNL = $_POST['pricetextboxNL'];  // Metin verisi
                                            $image = $_FILES['imageNL'];  // Resim dosyası

                                            // Resim yükleme işlemi
                                            $target_dir = "image/products/";  // Resimlerin kaydedileceği dizin
                                            $target_file = $target_dir . basename($image["name"]);
                                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                                            // Resim dosyasının geçerli olup olmadığını kontrol et
                                            $check = getimagesize($image["tmp_name"]);
                                            if ($check !== false) {
                                                // Dosya türü kontrolü
                                                if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "gif") {
                                                    // Resmi yükle
                                                    if (move_uploaded_file($image["tmp_name"], $target_file)) {
                                                    } else {
                                                        echo "An error occurred while loading the image.<br>";
                                                    }
                                                } else {
                                                    echo "You can only upload JPG, JPEG, PNG or GIF files.<br>";
                                                }
                                            } else {
                                                echo "You must select a valid image file.<br>";
                                            }

                                            // Veritabanına veri ekleme
                                            $sql = "INSERT INTO bags (pictures, product_end, product_name, product_color, product_size, product_price) 
                                            VALUES ('$target_file', '$endtextboxNL', '$commenttextNL', 'naturel', 'large', '$pricetextboxNL')";

                                            if ($conn->query($sql) === TRUE) {
                                                echo '
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">The newly added bag has been added successfully.</h1>
                                                  
                                                  </div>
                                                  <div class="modal-footer">
                                                     <button type="submit" name="closebtn" class="btn btn-secondary">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            
                                            ';
                                                 // Çıkış yaparak daha fazla işlem yapılmasını engeller
                                            } else {
                                                echo "Hata: " . $sql . "<br>" . $conn->error;
                                            }
                                        }
                                        ?>


                                    </div>
                                    <div class="btn col-4 mt-3">
                                        <button name="updatebtnNL" type="submit" class="btn btn-success">Update</button>
                                        <?php
                                        if (isset($_POST['updatebtnNL'])) {
                                            // Formdan gelen verileri alıyoruz
                                            $commenttextNL = $_POST['commenttextNL'];  // Metin verisi
                                            $endtextboxNL = $_POST['endtextboxNL'];
                                            $pricetextboxNL = $_POST['pricetextboxNL'];  // Metin verisi
                                            $image = $_FILES['imageNL'];  // Resim dosyası
                                            $target_file = '';  // Varsayılan olarak boş bırakıyoruz

                                            // Eğer dosya yüklenmişse, dosyayı kontrol et
                                            if ($image['error'] == 0) {
                                                $target_dir = "image/products/";  // Resimlerin kaydedileceği dizin
                                                $target_file = $target_dir . basename($image["name"]);
                                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                                                // Resim dosyasının geçerli olup olmadığını kontrol et
                                                $check = getimagesize($image["tmp_name"]);
                                                if ($check !== false) {
                                                    // Dosya türü kontrolü
                                                    if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "gif") {
                                                        // Resmi yükle
                                                        if (!move_uploaded_file($image["tmp_name"], $target_file)) {
                                                            echo "Resim yüklenirken bir hata oluştu.<br>";
                                                            exit();
                                                        }
                                                    } else {
                                                        echo "Yalnızca JPG, JPEG, PNG veya GIF dosyalarını yükleyebilirsiniz.<br>";
                                                        exit();
                                                    }
                                                } else {
                                                    echo "Geçerli bir resim dosyası seçmelisiniz.<br>";
                                                    exit();
                                                }
                                            }

                                            // Veritabanına veri ekleme
                                            $product_id2 = $_POST["productid"];

                                            // Dosya yolu yalnızca dosya yüklendiyse eklenir
                                            $sql = "UPDATE bags 
            SET product_end = '$endtextboxNL', 
                product_name = '$commenttextNL', 
                product_price = '$pricetextboxNL'";

                                            // Eğer dosya yüklendiyse, resim yolu da eklenir
                                            if (!empty($target_file)) {
                                                $sql .= ", pictures = '$target_file'";
                                            }

                                            $sql .= " WHERE product_id = $product_id2";

                                            if ($conn->query($sql) === TRUE) {
                                                echo '
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">The bags information has been successfully updated.</h1>
                                                  
                                                  </div>
                                                  <div class="modal-footer">
                                                     <button type="submit" name="closebtn" class="btn btn-secondary">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            
                                            ';
                                            } else {
                                                echo "Hata: " . $sql . "<br>" . $conn->error;
                                            }
                                        }
                                        ?>



                                    </div>
                                    
                                    <div class="btn col-4 mt-3">
                                        <button name="deletebtnNL" type="submit" class="btn btn-danger">Delete</button>
                                        <?php
                                        if (isset($_POST['deletebtnNL'])) {
                                            // Silinecek ürünün ID'sini alıyoruz
                                            $product_id = $_POST["productid"];

                                            // Ürünün resim yolunu veritabanından al
                                            $sql3 = "SELECT pictures FROM bags WHERE product_id = ?";
                                            $stmt = $conn->prepare($sql3);
                                            $stmt->bind_param("i", $product_id);
                                            $stmt->execute();
                                            $stmt->bind_result($product_image);
                                            $stmt->fetch();
                                            $stmt->close();

                                            // Resim dosyasını sil
                                            if ($product_image && file_exists($product_image)) {
                                                if (!unlink($product_image)) {
                                                    echo "Resim dosyası silinirken bir hata oluştu.";
                                                    exit();
                                                }
                                            }

                                            // Ürünü veritabanından sil
                                            $sql = "DELETE FROM bags WHERE product_id = ?";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bind_param("i", $product_id);
                                            if ($stmt->execute()) {
                                                echo '
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">bag deleted successfully.</h1>
                                                  
                                                  </div>
                                                  <div class="modal-footer">
                                                     <button type="submit" name="closebtn" class="btn btn-secondary">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            
                                            ';
                                            } else {
                                                echo "Ürün silinirken bir hata oluştu.";
                                            }
                                            $stmt->close();

                                            // Bağlantıyı kapat
                                            $conn->close();
                                        }
                                        ?>


                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center bags mt-5">
            <div class="bags-box col-12 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                <div class="bags-image">
                    <img src="../image/bags/Kopie van IG Post 1  producten (1).png" alt="">
                </div>

            </div>
            <div class="bags-task col-12 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                <form action="" method="post">
                    <div class="bags-pictures">
                        <div class="row">
                            <?php
                            try {
                                // Database connection (PDO)
                                $pdo = new PDO("mysql:host=localhost;dbname=academix", "root", "");
                                // Set error mode
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                // SQL Query
                                $sql = "SELECT product_id, pictures FROM bags WHERE product_color = 'naturel' AND product_size = 'small'";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();

                                // Fetch the data
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($result) {
                                    foreach ($result as $row) {
                                        echo '<div class="pictures col-4 mt-3">';
                                        echo '<button name="imagebtn" id="btn-' . $row["product_id"] . '" type="submit  " class="btn-image"><img src="'. $row["pictures"].'" alt="" class="img-thumb"></button>';
                                        echo '<input type="checkbox" name="onayNS" value="' . $row["product_id"] . '" id="checkbox-' . $row["product_id"] . '" style="display:none;">';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "No data found.";
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }

                            // Close connection
                            $pdo = null;
                            ?>


                        </div>
                    </div>
                </form>
                <div class="bags-header mt-3">
                    <div class="row">
                        <form id="myFormNS" action="" method="post" enctype="multipart/form-data">
                            <?php
                            if (isset($_POST['onayNS'])) {
                                try {
                                    // Database connection (PDO)
                                    $pdo = new PDO("mysql:host=localhost;dbname=academix", "root", "");
                                    // Set error mode
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    // SQL Query
                                    $product_id = $_POST["onayNS"];
                                    $sql = "SELECT product_id, pictures,product_end,product_name,product_price FROM bags WHERE product_id = $product_id";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();

                                    // Fetch the data
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if ($result) {
                                        foreach ($result as $row) {
                                            echo '
                                            
                            <input type="file" name="imageNS" id="imageNS" accept="image/*"><br>
                            <input type="hidden" name="productidNS" value="' . $row["product_id"] . '">
                            <label for="">Bag description:</label><br>
                            <textarea id="commenttextNS" name="commenttextNS">' . $row["product_name"] . '</textarea><br>
                            <label for="">left Bags:</label><br>
                            <input name="endtextboxNS" id="endtextboxNS" type="text" value="' . $row["product_end"] . '"><br>
                            <label for="">Price:</label><br>
                            <input name="pricetextboxNS" id="pricetextboxNS" type="text" value="' . $row["product_price"] . '"><br>
                                            
                                            
                                            ';
                                        }
                                    } else {
                                        echo "No data found.";
                                    }
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }

                                // Close connection
                                $pdo = null;
                            } else {
                                echo '
                                            
                                <input type="file" name="imageNS" id="imageNS" accept="image/*"><br>
                                <label for="">Bags comment:</label><br>
                                <textarea name="commenttextNS" id="commenttextNS"></textarea><br>
                                <label for="">End Bags:</label><br>
                                <input name="endtextboxNS" type="text" id="endtextboxNS"><br>
                                <label for="">Price:</label><br>
                                <input name="pricetextboxNS" type="text" id="pricetextboxNS"><br>
                                                
                                                
                                                ';
                            }
                            ?>
                            <div class="bags-btn">
                                <div class="row">
                                    <div class="btn col-4 mt-3">
                                    <button name="addbtnNS" type="submit" class="btn btn-primary" id="submitBtnNS" disabled>Add</button>

                                        <?php
                                        if (isset($_POST['addbtnNS'])) {
                                            // Formdan gelen verileri alıyoruz
                                            $commenttextNL = $_POST['commenttextNS'];  // Metin verisi
                                            $endtextboxNL = $_POST['endtextboxNS'];
                                            $pricetextboxNL = $_POST['pricetextboxNS'];  // Metin verisi
                                            $image = $_FILES['imageNS'];  // Resim dosyası

                                            // Resim yükleme işlemi
                                            $target_dir = "image/products/";  // Resimlerin kaydedileceği dizin
                                            $target_file = $target_dir . basename($image["name"]);
                                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                                            // Resim dosyasının geçerli olup olmadığını kontrol et
                                            $check = getimagesize($image["tmp_name"]);
                                            if ($check !== false) {
                                                // Dosya türü kontrolü
                                                if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "gif") {
                                                    // Resmi yükle
                                                    if (move_uploaded_file($image["tmp_name"], $target_file)) {
                                                    } else {
                                                        echo "An error occurred while loading the image.<br>";
                                                    }
                                                } else {
                                                    echo "You can only upload JPG, JPEG, PNG or GIF files.<br>";
                                                }
                                            } else {
                                                echo "You must select a valid image file.<br>";
                                            }

                                            // Veritabanına veri ekleme
                                            $sql = "INSERT INTO bags (pictures, product_end, product_name, product_color, product_size, product_price) 
                                            VALUES ('$target_file', '$endtextboxNL', '$commenttextNL', 'naturel', 'small', '$pricetextboxNL')";

                                            if ($conn->query($sql) === TRUE) {
                                                echo '
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">The newly added bag has been added successfully.</h1>
                                                  
                                                  </div>
                                                  <div class="modal-footer">
                                                     <button type="submit" name="closebtn" class="btn btn-secondary">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            
                                            ';
                                                 // Çıkış yaparak daha fazla işlem yapılmasını engeller
                                            } else {
                                                echo "Hata: " . $sql . "<br>" . $conn->error;
                                            }
                                        }
                                        ?>


                                    </div>
                                    <div class="btn col-4 mt-3">
                                        <button name="updatebtnNS" type="submit" class="btn btn-success">Update</button>
                                        <?php
                                        if (isset($_POST['updatebtnNS'])) {
                                            // Formdan gelen verileri alıyoruz
                                            $commenttextNS = $_POST['commenttextNS'];  // Metin verisi
                                            $endtextboxNS = $_POST['endtextboxNS'];
                                            $pricetextboxNS = $_POST['pricetextboxNS'];  // Metin verisi
                                            $imageNS = $_FILES['imageNS'];  // Resim dosyası
                                            $target_file = '';  // Varsayılan olarak boş bırakıyoruz

                                            // Eğer dosya yüklenmişse, dosyayı kontrol et
                                            if ($imageNS['error'] == 0) {
                                                $target_dir = "image/products/";  // Resimlerin kaydedileceği dizin
                                                $target_file = $target_dir . basename($imageNS["name"]);
                                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                                                // Resim dosyasının geçerli olup olmadığını kontrol et
                                                $check = getimagesize($imageNS["tmp_name"]);
                                                if ($check !== false) {
                                                    // Dosya türü kontrolü
                                                    if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "gif") {
                                                        // Resmi yükle
                                                        if (!move_uploaded_file($imageNS["tmp_name"], $target_file)) {
                                                            echo "Resim yüklenirken bir hata oluştu.<br>";
                                                            exit();
                                                        }
                                                    } else {
                                                        echo "Yalnızca JPG, JPEG, PNG veya GIF dosyalarını yükleyebilirsiniz.<br>";
                                                        exit();
                                                    }
                                                } else {
                                                    echo "Geçerli bir resim dosyası seçmelisiniz.<br>";
                                                    exit();
                                                }
                                            }

                                            // Veritabanına veri ekleme
                                            $product_id2 = $_POST["productidNS"];

                                            // Dosya yolu yalnızca dosya yüklendiyse eklenir
                                            $sql = "UPDATE bags 
            SET product_end = '$endtextboxNS', 
                product_name = '$commenttextNS', 
                product_price = '$pricetextboxNS'";

                                            // Eğer dosya yüklendiyse, resim yolu da eklenir
                                            if (!empty($target_file)) {
                                                $sql .= ", pictures = '$target_file'";
                                            }

                                            $sql .= " WHERE product_id = $product_id2";

                                            if ($conn->query($sql) === TRUE) {
                                                echo '
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">The bags information has been successfully updated.</h1>
                                                  
                                                  </div>
                                                  <div class="modal-footer">
                                                     <button type="submit" name="closebtn" class="btn btn-secondary">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            
                                            ';
                                            } else {
                                                echo "Hata: " . $sql . "<br>" . $conn->error;
                                            }
                                        }
                                        ?>



                                    </div>
                                    
                                    <div class="btn col-4 mt-3">
                                        <button name="deletebtnNS" type="submit" class="btn btn-danger">Delete</button>
                                        <?php
                                        if (isset($_POST['deletebtnNS'])) {
                                            // Silinecek ürünün ID'sini alıyoruz
                                            $product_id = $_POST["productidNS"];

                                            // Ürünün resim yolunu veritabanından al
                                            $sql3 = "SELECT pictures FROM bags WHERE product_id = ?";
                                            $stmt = $conn->prepare($sql3);
                                            $stmt->bind_param("i", $product_id);
                                            $stmt->execute();
                                            $stmt->bind_result($product_image);
                                            $stmt->fetch();
                                            $stmt->close();

                                            // Resim dosyasını sil
                                            if ($product_image && file_exists($product_image)) {
                                                if (!unlink($product_image)) {
                                                    echo "Resim dosyası silinirken bir hata oluştu.";
                                                    exit();
                                                }
                                            }

                                            // Ürünü veritabanından sil
                                            $sql = "DELETE FROM bags WHERE product_id = ?";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bind_param("i", $product_id);
                                            if ($stmt->execute()) {
                                                echo '
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">bag deleted successfully.</h1>
                                                  
                                                  </div>
                                                  <div class="modal-footer">
                                                     <button type="submit" name="closebtn" class="btn btn-secondary">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            
                                            ';
                                            } else {
                                                echo "Ürün silinirken bir hata oluştu.";
                                            }
                                            $stmt->close();

                                            // Bağlantıyı kapat
                                            $conn->close();
                                        }
                                        ?>


                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>



        <div class="row justify-content-center bags mt-5">
            <div class="bags-box col-12 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                <div class="bags-image">
                    <img src="../image/bags/Kopie van IG Post 1  producten (2).png" alt="">
                </div>

            </div>
            <div class="bags-task col-12 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                <form action="" method="post">
                    <div class="bags-pictures">
                        <div class="row">
                            <?php
                            try {
                                // Database connection (PDO)
                                $pdo = new PDO("mysql:host=localhost;dbname=academix", "root", "");
                                // Set error mode
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                // SQL Query
                                $sql = "SELECT product_id, pictures FROM bags WHERE product_color = 'black' AND product_size = 'large'";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();

                                // Fetch the data
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($result) {
                                    foreach ($result as $row) {
                                        echo '<div class="pictures col-4 mt-3">';
                                        echo '<button name="imagebtn" id="btn-' . $row["product_id"] . '" type="submit  " class="btn-image"><img src="' . $row["pictures"].'" alt="" class="img-thumb"></button>';
                                        echo '<input type="checkbox" name="onayBL" value="' . $row["product_id"] . '" id="checkbox-' . $row["product_id"] . '" style="display:none;">';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "No data found.";
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }

                            // Close connection
                            $pdo = null;
                            ?>


                        </div>
                    </div>
                </form>
                <div class="bags-header mt-3">
                    <div class="row">
                        <form id="myFormBL" action="" method="post" enctype="multipart/form-data">
                            <?php
                            if (isset($_POST['onayBL'])) {
                                try {
                                    // Database connection (PDO)
                                    $pdo = new PDO("mysql:host=localhost;dbname=academix", "root", "");
                                    // Set error mode
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    // SQL Query
                                    $product_id = $_POST["onayBL"];
                                    $sql = "SELECT product_id, pictures,product_end,product_name,product_price FROM bags WHERE product_id = $product_id";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();

                                    // Fetch the data
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if ($result) {
                                        foreach ($result as $row) {
                                            echo '
                                            
                            <input type="file" name="imageBL" id="imageBL" accept="image/*"><br>
                            <input type="hidden" name="productidBL" value="' . $row["product_id"] . '">
                            <label for="">Bag description:</label><br>
                            <textarea id="commenttextBL" name="commenttextBL">' . $row["product_name"] . '</textarea><br>
                            <label for="">left Bags:</label><br>
                            <input name="endtextboxBL" id="endtextboxBL" type="text" value="' . $row["product_end"] . '"><br>
                            <label for="">Price:</label><br>
                            <input name="pricetextboxBL" id="pricetextboxBL" type="text" value="' . $row["product_price"] . '"><br>
                                            
                                            
                                            ';
                                        }
                                    } else {
                                        echo "No data found.";
                                    }
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }

                                // Close connection
                                $pdo = null;
                            } else {
                                echo '
                                            
                                <input type="file" name="imageBL" id="imageBL" accept="image/*"><br>
                                <label for="">Bags comment:</label><br>
                                <textarea name="commenttextBL" id="commenttextBL"></textarea><br>
                                <label for="">End Bags:</label><br>
                                <input name="endtextboxBL" type="text" id="endtextboxBL"><br>
                                <label for="">Price:</label><br>
                                <input name="pricetextboxBL" type="text" id="pricetextboxBL"><br>
                                                
                                                
                                                ';
                            }
                            ?>
                            <div class="bags-btn">
                                <div class="row">
                                    <div class="btn col-4 mt-3">
                                    <button name="addbtnBL" type="submit" class="btn btn-primary" id="submitBtnBL" disabled>Add</button>

                                        <?php
                                        if (isset($_POST['addbtnBL'])) {
                                            // Formdan gelen verileri alıyoruz
                                            $commenttextBL = $_POST['commenttextBL'];  // Metin verisi
                                            $endtextboxBL = $_POST['endtextboxBL'];
                                            $pricetextboxBL = $_POST['pricetextboxBL'];  // Metin verisi
                                            $image = $_FILES['imageBL'];  // Resim dosyası

                                            // Resim yükleme işlemi
                                            $target_dir = "image/products/";  // Resimlerin kaydedileceği dizin
                                            $target_file = $target_dir . basename($image["name"]);
                                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                                            // Resim dosyasının geçerli olup olmadığını kontrol et
                                            $check = getimagesize($image["tmp_name"]);
                                            if ($check !== false) {
                                                // Dosya türü kontrolü
                                                if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "gif") {
                                                    // Resmi yükle
                                                    if (move_uploaded_file($image["tmp_name"], $target_file)) {
                                                    } else {
                                                        echo "An error occurred while loading the image.<br>";
                                                    }
                                                } else {
                                                    echo "You can only upload JPG, JPEG, PNG or GIF files.<br>";
                                                }
                                            } else {
                                                echo "You must select a valid image file.<br>";
                                            }

                                            // Veritabanına veri ekleme
                                            $sql = "INSERT INTO bags (pictures, product_end, product_name, product_color, product_size, product_price) 
                                            VALUES ('$target_file', '$endtextboxBL', '$commenttextBL', 'black', 'large', '$pricetextboxBL')";

                                            if ($conn->query($sql) === TRUE) {
                                                echo '
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">The newly added bag has been added successfully.</h1>
                                                  
                                                  </div>
                                                  <div class="modal-footer">
                                                     <button type="submit" name="closebtn" class="btn btn-secondary">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            
                                            ';
                                                 // Çıkış yaparak daha fazla işlem yapılmasını engeller
                                            } else {
                                                echo "Hata: " . $sql . "<br>" . $conn->error;
                                            }
                                        }
                                        ?>


                                    </div>
                                    <div class="btn col-4 mt-3">
                                        <button name="updatebtnBL" type="submit" class="btn btn-success">Update</button>
                                        <?php
                                        if (isset($_POST['updatebtnBL'])) {
                                            // Formdan gelen verileri alıyoruz
                                            $commenttextBL = $_POST['commenttextBL'];  // Metin verisi
                                            $endtextboxBL = $_POST['endtextboxBL'];
                                            $pricetextboxBL = $_POST['pricetextboxBL'];  // Metin verisi
                                            $imageBL = $_FILES['imageBL'];  // Resim dosyası
                                            $target_file = '';  // Varsayılan olarak boş bırakıyoruz

                                            // Eğer dosya yüklenmişse, dosyayı kontrol et
                                            if ($imageBL['error'] == 0) {
                                                $target_dir = "image/products/";  // Resimlerin kaydedileceği dizin
                                                $target_file = $target_dir . basename($imageBL["name"]);
                                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                                                // Resim dosyasının geçerli olup olmadığını kontrol et
                                                $check = getimagesize($imageBL["tmp_name"]);
                                                if ($check !== false) {
                                                    // Dosya türü kontrolü
                                                    if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "gif") {
                                                        // Resmi yükle
                                                        if (!move_uploaded_file($imageBL["tmp_name"], $target_file)) {
                                                            echo "Resim yüklenirken bir hata oluştu.<br>";
                                                            exit();
                                                        }
                                                    } else {
                                                        echo "Yalnızca JPG, JPEG, PNG veya GIF dosyalarını yükleyebilirsiniz.<br>";
                                                        exit();
                                                    }
                                                } else {
                                                    echo "Geçerli bir resim dosyası seçmelisiniz.<br>";
                                                    exit();
                                                }
                                            }

                                            // Veritabanına veri ekleme
                                            $product_id2 = $_POST["productidBL"];

                                            // Dosya yolu yalnızca dosya yüklendiyse eklenir
                                            $sql = "UPDATE bags 
            SET product_end = '$endtextboxBL', 
                product_name = '$commenttextBL', 
                product_price = '$pricetextboxBL'";

                                            // Eğer dosya yüklendiyse, resim yolu da eklenir
                                            if (!empty($target_file)) {
                                                $sql .= ", pictures = '$target_file'";
                                            }

                                            $sql .= " WHERE product_id = $product_id2";

                                            if ($conn->query($sql) === TRUE) {
                                                echo '
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">The bags information has been successfully updated.</h1>
                                                  
                                                  </div>
                                                  <div class="modal-footer">
                                                     <button type="submit" name="closebtn" class="btn btn-secondary">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            
                                            ';
                                            } else {
                                                echo "Hata: " . $sql . "<br>" . $conn->error;
                                            }
                                        }
                                        ?>



                                    </div>
                                    
                                    <div class="btn col-4 mt-3">
                                        <button name="deletebtnBL" type="submit" class="btn btn-danger">Delete</button>
                                        <?php
                                        if (isset($_POST['deletebtnBL'])) {
                                            // Silinecek ürünün ID'sini alıyoruz
                                            $product_id = $_POST["productidBL"];

                                            // Ürünün resim yolunu veritabanından al
                                            $sql3 = "SELECT pictures FROM bags WHERE product_id = ?";
                                            $stmt = $conn->prepare($sql3);
                                            $stmt->bind_param("i", $product_id);
                                            $stmt->execute();
                                            $stmt->bind_result($product_image);
                                            $stmt->fetch();
                                            $stmt->close();

                                            // Resim dosyasını sil
                                            if ($product_image && file_exists($product_image)) {
                                                if (!unlink($product_image)) {
                                                    echo "Resim dosyası silinirken bir hata oluştu.";
                                                    exit();
                                                }
                                            }

                                            // Ürünü veritabanından sil
                                            $sql = "DELETE FROM bags WHERE product_id = ?";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bind_param("i", $product_id);
                                            if ($stmt->execute()) {
                                                echo '
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">bag deleted successfully.</h1>
                                                  
                                                  </div>
                                                  <div class="modal-footer">
                                                     <button type="submit" name="closebtn" class="btn btn-secondary">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            
                                            ';
                                            } else {
                                                echo "Ürün silinirken bir hata oluştu.";
                                            }
                                            $stmt->close();

                                            // Bağlantıyı kapat
                                            $conn->close();
                                        }
                                        ?>


                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        


        <div class="row justify-content-center bags mt-5">
            <div class="bags-box col-12 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                <div class="bags-image">
                    <img src="../image/bags/Kopie van IG Post 1  producten (3).png" alt="">
                </div>

            </div>
            <div class="bags-task col-12 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                <form action="" method="post">
                    <div class="bags-pictures">
                        <div class="row">
                            <?php
                            try {
                                // Database connection (PDO)
                                $pdo = new PDO("mysql:host=localhost;dbname=academix", "root", "");
                                // Set error mode
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                // SQL Query
                                $sql = "SELECT product_id, pictures FROM bags WHERE product_color = 'black' AND product_size = 'small'";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();

                                // Fetch the data
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($result) {
                                    foreach ($result as $row) {
                                        echo '<div class="pictures col-4 mt-3">';
                                        echo '<button name="imagebtn" id="btn-' . $row["product_id"] . '" type="submit  " class="btn-image"><img src="'. $row["pictures"].'" alt="" class="img-thumb"></button>';
                                        echo '<input type="checkbox" name="onayBS" value="' . $row["product_id"] . '" id="checkbox-' . $row["product_id"] . '" style="display:none;">';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "No data found.";
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }

                            // Close connection
                            $pdo = null;
                            ?>


                        </div>
                    </div>
                </form>
                <div class="bags-header mt-3">
                    <div class="row">
                        <form id="myFormBS" action="" method="post" enctype="multipart/form-data">
                            <?php
                            if (isset($_POST['onayBS'])) {
                                try {
                                    // Database connection (PDO)
                                    $pdo = new PDO("mysql:host=localhost;dbname=academix", "root", "");
                                    // Set error mode
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    // SQL Query
                                    $product_id = $_POST["onayBS"];
                                    $sql = "SELECT product_id, pictures,product_end,product_name,product_price FROM bags WHERE product_id = $product_id";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();

                                    // Fetch the data
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if ($result) {
                                        foreach ($result as $row) {
                                            echo '
                                            
                            <input type="file" name="imageBS" id="imageBS" accept="image/*"><br>
                            <input type="hidden" name="productidBS" value="' . $row["product_id"] . '">
                            <label for="">Bag description:</label><br>
                            <textarea id="commenttextBS" name="commenttextBS">' . $row["product_name"] . '</textarea><br>
                            <label for="">left Bags:</label><br>
                            <input name="endtextboxBS" id="endtextboxBS" type="text" value="' . $row["product_end"] . '"><br>
                            <label for="">Price:</label><br>
                            <input name="pricetextboxBS" id="pricetextboxBS" type="text" value="' . $row["product_price"] . '"><br>
                                            
                                            
                                            ';
                                        }
                                    } else {
                                        echo "No data found.";
                                    }
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }

                                // Close connection
                                $pdo = null;
                            } else {
                                echo '
                                            
                                <input type="file" name="imageBS" id="imageBS" accept="image/*"><br>
                                <label for="">Bags comment:</label><br>
                                <textarea name="commenttextBS" id="commenttextBS"></textarea><br>
                                <label for="">End Bags:</label><br>
                                <input name="endtextboxBS" type="text" id="endtextboxBS"><br>
                                <label for="">Price:</label><br>
                                <input name="pricetextboxBS" type="text" id="pricetextboxBS"><br>
                                                
                                                
                                                ';
                            }
                            ?>
                            <div class="bags-btn">
                                <div class="row">
                                    <div class="btn col-4 mt-3">
                                    <button name="addbtnBS" type="submit" class="btn btn-primary" id="submitBtnBS" disabled>Add</button>

                                        <?php
                                        if (isset($_POST['addbtnBS'])) {
                                            // Formdan gelen verileri alıyoruz
                                            $commenttextBS = $_POST['commenttextBS'];  // Metin verisi
                                            $endtextboxBS = $_POST['endtextboxBS'];
                                            $pricetextboxBS = $_POST['pricetextboxBS'];  // Metin verisi
                                            $image = $_FILES['imageBS'];  // Resim dosyası

                                            // Resim yükleme işlemi
                                            $target_dir = "image/products/";  // Resimlerin kaydedileceği dizin
                                            $target_file = $target_dir . basename($image["name"]);
                                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                                            // Resim dosyasının geçerli olup olmadığını kontrol et
                                            $check = getimagesize($image["tmp_name"]);
                                            if ($check !== false) {
                                                // Dosya türü kontrolü
                                                if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "gif") {
                                                    // Resmi yükle
                                                    if (move_uploaded_file($image["tmp_name"], $target_file)) {
                                                    } else {
                                                        echo "An error occurred while loading the image.<br>";
                                                    }
                                                } else {
                                                    echo "You can only upload JPG, JPEG, PNG or GIF files.<br>";
                                                }
                                            } else {
                                                echo "You must select a valid image file.<br>";
                                            }

                                            // Veritabanına veri ekleme
                                            $sql = "INSERT INTO bags (pictures, product_end, product_name, product_color, product_size, product_price) 
                                            VALUES ('$target_file', '$endtextboxBS', '$commenttextBS', 'black', 'small', '$pricetextboxBS')";

                                            if ($conn->query($sql) === TRUE) {
                                                echo '
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">The newly added bag has been added successfully.</h1>
                                                  
                                                  </div>
                                                  <div class="modal-footer">
                                                     <button type="submit" name="closebtn" class="btn btn-secondary">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            
                                            ';
                                                 // Çıkış yaparak daha fazla işlem yapılmasını engeller
                                            } else {
                                                echo "Hata: " . $sql . "<br>" . $conn->error;
                                            }
                                        }
                                        ?>

                                    </div>
                                    <div class="btn col-4 mt-3">
                                        <button name="updatebtnBS" type="submit" class="btn btn-success">Update</button>
                                        <?php
                                        if (isset($_POST['updatebtnBS'])) {
                                            // Formdan gelen verileri alıyoruz
                                            $commenttextBS = $_POST['commenttextBS'];  // Metin verisi
                                            $endtextboxBS = $_POST['endtextboxBS'];
                                            $pricetextboxBS = $_POST['pricetextboxBS'];  // Metin verisi
                                            $imageBS = $_FILES['imageBS'];  // Resim dosyası
                                            $target_file = '';  // Varsayılan olarak boş bırakıyoruz

                                            // Eğer dosya yüklenmişse, dosyayı kontrol et
                                            if ($imageBS['error'] == 0) {
                                                $target_dir = "image/products/";  // Resimlerin kaydedileceği dizin
                                                $target_file = $target_dir . basename($imageBS["name"]);
                                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                                                // Resim dosyasının geçerli olup olmadığını kontrol et
                                                $check = getimagesize($imageBS["tmp_name"]);
                                                if ($check !== false) {
                                                    // Dosya türü kontrolü
                                                    if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "gif") {
                                                        // Resmi yükle
                                                        if (!move_uploaded_file($imageBS["tmp_name"], $target_file)) {
                                                            echo "Resim yüklenirken bir hata oluştu.<br>";
                                                            exit();
                                                        }
                                                    } else {
                                                        echo "Yalnızca JPG, JPEG, PNG veya GIF dosyalarını yükleyebilirsiniz.<br>";
                                                        exit();
                                                    }
                                                } else {
                                                    echo "Geçerli bir resim dosyası seçmelisiniz.<br>";
                                                    exit();
                                                }
                                            }

                                            // Veritabanına veri ekleme
                                            $product_id2 = $_POST["productidBS"];

                                            // Dosya yolu yalnızca dosya yüklendiyse eklenir
                                            $sql = "UPDATE bags 
            SET product_end = '$endtextboxBS', 
                product_name = '$commenttextBS', 
                product_price = '$pricetextboxBS'";

                                            // Eğer dosya yüklendiyse, resim yolu da eklenir
                                            if (!empty($target_file)) {
                                                $sql .= ", pictures = '$target_file'";
                                            }

                                            $sql .= " WHERE product_id = $product_id2";

                                            if ($conn->query($sql) === TRUE) {
                                                echo '
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">The bags information has been successfully updated.</h1>
                                                  
                                                  </div>
                                                  <div class="modal-footer">
                                                     <button type="submit" name="closebtn" class="btn btn-secondary">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            
                                            ';
                                            } else {
                                                echo "Hata: " . $sql . "<br>" . $conn->error;
                                            }
                                        }
                                        ?>



                                    </div>
                                    
                                    <div class="btn col-4 mt-3">
                                        <button name="deletebtnBS" type="submit" class="btn btn-danger">Delete</button>
                                        <?php
                                        if (isset($_POST['deletebtnBS'])) {
                                            // Silinecek ürünün ID'sini alıyoruz
                                            $product_id = $_POST["productidBS"];

                                            // Ürünün resim yolunu veritabanından al
                                            $sql3 = "SELECT pictures FROM bags WHERE product_id = ?";
                                            $stmt = $conn->prepare($sql3);
                                            $stmt->bind_param("i", $product_id);
                                            $stmt->execute();
                                            $stmt->bind_result($product_image);
                                            $stmt->fetch();
                                            $stmt->close();

                                            // Resim dosyasını sil
                                            if ($product_image && file_exists($product_image)) {
                                                if (!unlink($product_image)) {
                                                    echo "Resim dosyası silinirken bir hata oluştu.";
                                                    exit();
                                                }
                                            }

                                            $sql = "DELETE FROM bags WHERE product_id = ?";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bind_param("i", $product_id);
                                            if ($stmt->execute()) {
                                                echo '
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">bag deleted successfully.</h1>
                                                  
                                                  </div>
                                                  <div class="modal-footer">
                                                     <button type="submit" name="closebtn" class="btn btn-secondary">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            
                                            ';
                                            } else {
                                                echo "Ürün silinirken bir hata oluştu.";
                                            }
                                            $stmt->close();

                                            // Bağlantıyı kapat
                                            $conn->close();
                                        }
                                        ?>


                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>




        
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/admin.js"></script>
</body>
</html>