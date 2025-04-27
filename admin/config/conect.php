<?php
$mysqli = new mysqli("localhost", "root", "", "linhkienmaytinh_mysql");

// Check connection
if ($mysqli->connect_errno) {
  echo "Lỗi kết nối MYSQL " . $mysqli->connect_error;
  exit();
}
