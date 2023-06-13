<?php
  require_once("dbtools.inc.php");
  
  $album_id = $_GET["album_id"];
  $photo_id = $_GET["photo_id"];
  
  //获取登录者账号
  session_start();
  $login_user = $_SESSION["login_user"];
  
  //建立数据连接
  $link = create_connection();
  
  //删除存储在硬盘的照片
  $sql = "SELECT filename FROM photo WHERE id = $photo_id
          AND EXISTS(SELECT '*' FROM album WHERE id = $album_id AND owner = '$login_user')";
  $result = execute_sql($link, "album", $sql);
  
  $file_name = mysqli_fetch_object($result)->filename;
  $photo_path = realpath("./Photo/$file_name");
  $thumbnail_path = realpath("./Thumbnail/$file_name");
  
  if (file_exists($photo_path))
    unlink($photo_path);
      
  if (file_exists($thumbnail_path))
    unlink($thumbnail_path);
  
  //删除存储在数据库的照片信息
  $sql = "DELETE FROM photo WHERE id = $photo_id
          AND EXISTS(SELECT '*' FROM album WHERE id = $album_id AND owner = '$login_user')";
  execute_sql($link, "album", $sql);
 	
  //释放内存并关闭数据连接
  mysqli_free_result($result);
  mysqli_close($link);
  
  header("location:showAlbum.php?album_id=$album_id");
?>