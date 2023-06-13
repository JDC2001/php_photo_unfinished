<!doctype html>
<html>
  <head>
  	<title>个人相册</title>
    <meta charset="utf-8">
    <style type="text/css">
      body{
        margin: 0;
        padding: 0;
        background-image: url(img/bg-4.jpg);
      }
      #xcm{
      font-size: 50px;
       font-family: sans-serif;
       color: white;
      }
      a{
        text-decoration: none;
        color: white;
        font-family: comic sans ms;
        font-size: 20px;
      }
      img{
        width: 300px;
        height: 400px;
        margin: 10px;

      }
      #upload{
        width: 150px;
        text-align: center;
        position: absolute;
        top: 50px;
        left: 70%;
        border: 1px solid white;
      }
      #bh{
        width: 150px;
        text-align: center;
        position: absolute;
        top: 50px;
        left: 20%;
        border: 1px solid white;
      }
    </style>
    <script type="text/javascript">
      function DeletePhoto(album_id, photo_id)
      {
        if (confirm("请确认是否删除此照片？"))
          location.href = "delPhoto.php?album_id=" + album_id + "&photo_id=" + photo_id;
      }
    </script>
  </head>
  <body>
    <?php
      require_once("dbtools.inc.php");
      $album_id = $_GET["album_id"];

      //获取登录者的账号
	    $login_user = "";
	    session_start();
	    if (isset($_SESSION["login_user"]))
        $login_user = $_SESSION["login_user"];

      //建立数据连接
      $link = create_connection();

      //获取相册的名称及相册的主人
      $sql = "SELECT name, owner FROM album WHERE id = $album_id";
      $result = execute_sql($link, "album", $sql);
      $row = mysqli_fetch_object($result);
      $album_name = $row->name;
      $album_owner = $row->owner;

      echo "<p align='center' id='xcm'>$album_name</p>";

      //获取相册里所有照片的缩略图
      $sql = "SELECT id, name, filename FROM photo WHERE album_id = $album_id";
      $result = execute_sql($link, "album", $sql);
	    $total_photo = mysqli_num_rows($result);

      echo "<table border='0' align='center'>";

      //指定每行显示几张照片
      $photo_per_row = 5;

      //显示照片缩略图
      $i = 1;
      while ($row = mysqli_fetch_assoc($result))
      {
      	$photo_id = $row["id"];
      	$photo_name = $row["name"];
      	$file_name = $row["filename"];

        if ($i % $photo_per_row == 1)
          echo "<tr align='center'>";

        echo "<td width='160px'><a href='photoDetail.php?album=$album_id&photo=$photo_id'>
              <img src='./Thumbnail/$file_name' style='border-color:Black;border-width:1px'>
              <br>$photo_name</a><br>";

        if ($album_owner == $login_user)
          echo "<br><a href='editPhoto.php?photo_id=$photo_id' id='edit'>编辑</a>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <a href='#' onclick='DeletePhoto($album_id, $photo_id)' id='del'>删除</a>";

        echo "<p></td>";

        if ($i % $photo_per_row == 0 || $i == $total_photo)
          echo "</tr>";

        $i++;
      }

      echo "</table>" ;

      //释放资源并关闭数据连接
      mysqli_free_result($result);
      mysqli_close($link);

      // echo "<hr><p align='center'>";
      if ($album_owner == $login_user)
        echo "<a href='uploadPhoto.php?album_id=$album_id' id='upload'>上传照片</a> ";
    ?>
    <a href='index.php' id='bh'>返回首页</a></p>
  </body>
</html>
