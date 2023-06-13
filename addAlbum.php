<?php
  if (isset($_POST["album_name"]))
  {
    require_once("dbtools.inc.php");
    $album_name = $_POST["album_name"];

    //获取登录者账号
    session_start();
    $login_user = $_SESSION["login_user"];

    //建立数据连接
    $link = create_connection();

    //新增相册

    $sql = "SELECT ifnull(max(id), 0) + 1 AS album_id FROM album";
    $result = execute_sql($link, "album", $sql);
    $album_id = mysqli_fetch_object($result)->album_id;

    $sql = "INSERT INTO album(id, name, owner)
      VALUES($album_id, '$album_name', '$login_user')";

    execute_sql($link, "album", $sql);

    //释放内存并关闭数据连接
    mysqli_free_result($result);
    mysqli_close($link);

    header("<location:>showAlbum.php?album_id=$album_id");
  }
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>个人相册</title>
    <style type="text/css" media="screen">
    body{
      margin: 0;
      padding: 0;
      background-image: url(img/bg-4.jpg);
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
    #xcm{
    font-size: 30px;
     color: white;
     margin-top: 5%;
     position: absolute;
     left: 46.5%;
    }
    #kuang{
      width: 650px;
      background: none;
      border: 2px solid white;
      font-size: 30px;
      position: absolute;
      top: 30%;
      left: 32.5%;
    }
    #add{
      width: 200px;
      font-size: 25px;
      background: none;
      border:  3px solid white;
      color: white;
      position: absolute;
      top: 40%;
      left: 45%;
    }
    </style>
  </head>
  <body>

    <form action="addAlbum.php" method="post">
      <table align="center">
        <tr>
          <td id="xcm">
            相册名称
          </td>
          <td>
            <input id="kuang" type="text" name="album_name" size="15">
            <input id="add" type="submit" value="新增">
          </td>
        </tr>
        <tr>
          <td colspan="3" align="center">
            <br><a id="bh" href="index.php">回首页</a>
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
