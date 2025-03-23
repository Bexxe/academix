<?php
session_start();
session_unset(); 
session_destroy(); // Tüm oturum verilerini sil
header("Location: index.php"); // Kullanıcıyı ana sayfaya yönlendir
exit();
?>
