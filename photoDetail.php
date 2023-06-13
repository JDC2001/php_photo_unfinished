<!doctype html>
<html>
  <head>
    <title>相册</title>
    <meta charset="utf-8">
    <style type="text/css" media="screen">
      body{
        margin: 0;
        padding: 0;
        background-image: url(img/bg-7.jpg);
      }
      #xcm{
      font-size: 50px;
       color: white;
      }
      a{
        text-decoration: none;
        color: white;
        font-family: comic sans ms;
        font-size: 20px;
      }
      #bh{
        width: 150px;
        text-align: center;
        position: absolute;
        top: 50px;
        left: 20%;
        border: 1px solid white;
      }
      #hxc{
        width: 150px;
        text-align: center;
        position: absolute;
        top: 50px;
        left: 70%;
        border: 1px solid white;
      }
    </style>
  </head>
  <body>
    <?php
      require_once("dbtools.inc.php");
      $album_id = $_GET["album"];
      $photo_id = $_GET["photo"];

      //建立数据连接
      $link = create_connection();

      //获取并显示相册名称
      $sql = "SELECT name FROM album WHERE id = $album_id";
      $result = execute_sql($link, "album", $sql);
      $album_name = mysqli_fetch_object($result)->name;
      echo "<p align='center' id='xcm'>$album_name</p>";

      //获取并显示照片数据
      $sql = "SELECT filename, comment FROM photo WHERE id = $photo_id";
      $result = execute_sql($link, "album", $sql);
      $row = mysqli_fetch_object($result);
      $file_name = $row->filename;
      $comment = $row->comment;
      echo "<p align='center'><img src='./Photo/$file_name'
            style='border-style:solid;border-width:1px'></p>";
      echo "<p align='center'>$comment</p>";

      //获取并建立照片导览数据
      $sql = "SELECT a.id, a.filename FROM (SELECT id, filename FROM photo
              WHERE album_id = $album_id AND (id <= $photo_id)
              ORDER BY id desc) a ORDER BY a.id";
      $result = execute_sql($link, "album", $sql);

      echo "<br><p align='center'>";
      while ($row = mysqli_fetch_assoc($result))
      {
      	if ($row["id"] == $photo_id)
      	{
      	  echo "<img src='./Thumbnail/" . $row["filename"] .
      	       "' style='border-style:solid;border-color: Red;border-width:2px'>　";
      	}
      	else
      	{
      	  echo "<a href='photoDetail.php?album=$album_id&photo=" . $row["id"] .
      	       "'><img src='./Thumbnail/" . $row["filename"] .
      	       "' style='border-style:solid;border-color:Black;border-width:1px'></a>　";
      	}
      }

      $sql = "SELECT id, filename FROM photo WHERE album_id = $album_id AND (id > $photo_id)
              ORDER BY id";
      $result = execute_sql($link, "album", $sql);
      while ($row = mysqli_fetch_assoc($result))
      {
      	echo "<a href='photoDetail.php?album=$album_id&photo=" . $row["id"] .
      	     "'><img src='./Thumbnail/" . $row["filename"] .
      	     "' style='border-style:solid;border-color:Black;border-width:1px'></a>　";
      }
      echo "</p>";

      //释放内存
      mysqli_free_result($result);
	  //关闭数据连接
      mysqli_close($link);
    ?>
    <p align="center">
      <a href="index.php" id='bh'>回首页</a>
      <a id="hxc" href="showAlbum.php?album_id=<?php echo $album_id ?>">回 <?php echo $album_name ?> 相册
    </p>
  </body>
</html>
