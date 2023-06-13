<?php
  require_once("dbtools.inc.php");

  //获取登录者账号
  session_start();
  $login_user = $_SESSION["login_user"];

  //建立数据连接
  $link = create_connection();

  if (!isset($_POST["album_id"]))
  {
    $album_id = $_GET["album_id"];

    //获取相册名称及相册所有者的账号
    $sql = "SELECT name, owner FROM album where id = $album_id";
    $result = execute_sql($link, "album", $sql);
    $row = mysqli_fetch_object($result);
    $album_name = $row->name;
    $album_owner = $row->owner;

    //释放 $result 占用的内存
    mysqli_free_result($result);

    //关闭数据连接
    mysqli_close($link);

    if ($album_owner != $login_user)
    {
      echo "<script type='text/javascript'>";
      echo "alert('您不是相册的主人，无法修改相册名称。$album_owner');";
      echo "</script>";
    }
  }
  else
  {
    $album_id = $_POST["album_id"];
    $album_name = $_POST["album_name"];
    $sql = "UPDATE album SET name = '$album_name'
            WHERE id = $album_id AND owner = '$login_user'";
    execute_sql($link, "album", $sql);

    //关闭数据连接
    mysqli_close($link);

    header("location:index.php");
  }
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>电子相册</title>
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
      color: white;
      text-align: center;
      font-size: 30px;
      position: absolute;
      top: 30%;
      left: 32.5%;
    }
    #gx{
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

    <form action="editAlbum.php" method="post">
      <table align="center">
        <tr>
          <td id="xcm">
            相册名称
          </td>
          <td>
            <input id="kuang" type="text" name="album_name" size="15"
              value="<?php echo $album_name ?>">
            <input type="hidden" name="album_id" value="<?php echo $album_id ?>">
            <input id="gx" type="submit" value="更新"
              <?php if ($album_owner != $login_user) echo 'disabled' ?>>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <br><a id="bh" href="index.php">回首页</a>
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
