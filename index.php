<!doctype html>
<html>
  <head>
    <title>个人相册</title>
    <meta charset="utf-8">
    <script type="text/javascript">
      function DeleteAlbum(album_id)
      {
        if (confirm("请确认是否删除此相册？"))
          location.href = "delAlbum.php?album_id=" + album_id;
      }
    </script>
    <style type="text/css">
    body{
      background-image: url(img/bg-2.jpg);
      margin: 0;
      padding: 0;

    }

    #d{
      font-family: comic sans ms;
      font-size:50px;
      color: white;
      margin-left: 200px;
    }
    a{
      text-decoration: none;
      color: white;
    }
    #ww{
      font-size: 30px;
      font-family: ink free;
      position: absolute;
      top: 70px;
      left: 70%;
    }
    img{
      width: 300px;
      height: 400px;
      margin: 20px;

    }
    #add{
      font-size: 30px;
      font-family: ink free;
      position: absolute;
      top: 70px;
      left: 70%;
    }
    #lout{
      font-size: 30px;
      font-family: ink free;
      position: absolute;
      top: 30px;
      left: 70%;
    }
    #edit{
      font-size: 30px;
      font-family: comic sans ms;
      margin-right: 20px;
    }
    #del{
      font-size: 20px;
      font-family: comic sans ms;
    }

    </style>
    </head>
  <body>

    <div class="body">


    <?php
      require_once("dbtools.inc.php");

      //获取登录者账号及名称
      session_start();
	  if (isset($_SESSION["login_user"]))
	  {
        $login_user = $_SESSION["login_user"];
        $login_name = $_SESSION["login_name"];
	  }

      //建立数据连接
      $link = create_connection();

      //获取所有相册的数据
      $sql = "SELECT id, name, owner FROM album order by name";
      $album_result = execute_sql($link, "album", $sql);

      //获取相册的数目
      $total_album = mysqli_num_rows($album_result);

      echo "<p id='d'> you have $total_album photo albums</p>";
      echo "<table border='0' align='center'>";

      //指定每行显示几个相册
      $album_per_row = 5;

      //显示相册列表
      $i = 1;
      while ($row = mysqli_fetch_assoc($album_result))
      {
      	//获取相册编号、名称及相册的主人
      	$album_id = $row["id"];
      	$album_name = $row["name"];
      	$album_owner = $row["owner"];

      	$sql = "SELECT filename FROM photo WHERE album_id = $album_id";
      	$photo_result = execute_sql($link, "album", $sql);

      	//获取相册的照片数目
      	$total_photo = mysqli_num_rows($photo_result);

      	//照片数目大于 0 就以第一张照片当作相册封面，否则以 None.png 当封面
      	if ($total_photo > 0)
          $cover_photo = mysqli_fetch_object($photo_result)->filename;
      	else
      	  $cover_photo = "None.png";

      	//释放内存
      	mysqli_free_result($photo_result);

        if ($i % $album_per_row == 1)
          echo "<tr align='center' valign='top'>";

        echo "<td width='160px'>
              <a href='showAlbum.php?album_id=$album_id'>
              <img src='./Thumbnail/$cover_photo' style='border-color:Black;border-width:1px'>
              <br>$album_name</a><br>$total_photo Pictures";

        if (isset($login_user) && $album_owner == $login_user)
        {
          echo "<br><a href='editAlbum.php?album_id=$album_id' id='edit'>edit</a>
                <a href='#' onclick='DeleteAlbum($album_id)' id='del'>delete</a>";
        }

        echo "<p></td>";

        if ($i % $album_per_row == 0 || $i == $total_album)
          echo "</tr>";

        $i++;
      }

      echo "</table>" ;

      //释放内存并关闭数据连接
      mysqli_free_result($album_result);
      mysqli_close($link);

      // echo "<hr><p align='center'>";

      //若 isset($login_name) 返回 false，表示用户尚未登录系统
      if (!isset($login_name))
        echo "<a href='logon.php' id='ww'>登录</a>";
      else
      {
        echo "<a href='addAlbum.php' id='add'>add new gallery</a>
              <a href='logout.php' id='lout'>login $login_name out</a>";
      }
    ?>
    </div>
    </p>
  </body>
</html>
