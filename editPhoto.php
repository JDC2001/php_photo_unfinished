<?php
  require_once("dbtools.inc.php");

  //获取登录者账号
  session_start();
  $login_user = $_SESSION["login_user"];

  //建立数据连接
  $link = create_connection();

  if (!isset($_POST["photo_name"]))
  {
    $photo_id = $_GET["photo_id"];

    //获取相册名称及相册的主人
    $sql = "SELECT a.name, a.filename, a.comment, a.album_id, b.name AS album_name,
            b.owner FROM photo a, album b where a.id = $photo_id and b.id = a.album_id";
    $result = execute_sql($link, "album", $sql);
    $row = mysqli_fetch_object($result);
    $album_id = $row->album_id;
    $album_name = $row->album_name;
    $album_owner = $row->owner;
    $photo_name = $row->name;
    $file_name = $row->filename;
    $photo_comment = $row->comment;

    //释放 $result 占用的内存
    mysqli_free_result($result);

    //关闭数据连接
    mysqli_close($link);

    if ($album_owner != $login_user)
    {
      echo "<script type='text/javascript'>";
      echo "alert('您不是照片的主人，无法修改照片名称。')";
      echo "</script>";
    }
  }
  else
  {
    $album_id = $_POST["album_id"];
    $photo_id = $_POST["photo_id"];
    $photo_name = $_POST["photo_name"];
    $photo_comment = $_POST["photo_comment"];

    $sql = "UPDATE photo SET name = '$photo_name', comment = '$photo_comment'
            WHERE id = $photo_id AND EXISTS(SELECT '*' FROM album
            WHERE id = $album_id AND owner = '$login_user')";
    execute_sql($link, "album", $sql);

    //关闭数据连接
    mysqli_close($link);

    header("location:showAlbum.php?album_id=$album_id");
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
      background-image: url(img/bg-6.jpg);
    }
    #hxc{
      width: 150px;
      text-align: center;
      position: absolute;
      top: 50px;
      left: 70%;
      border: 1px solid white;
    }
    a{
      text-decoration: none;
      color: white;
      font-family: comic sans ms;
      font-size: 20px;
    }
    #kk{
      position: absolute;
      top: 30%;
      left: 40%;
      font-family: "等线";
      font-size: 20px;
      color: white;
    }
    #mc{
      width: 300px;
      height: 50px;
      background: none;
      border: 1px solid white;
      text-align: center;
      color: white;
      font-size: 20px;
      margin-bottom: 30px;
    }
    #ms{
      border: 2px solid white;
      height: auto;
      background: none;
      color: white;
      text-align: center;
      font-size: 20px;
      font-family: sans-serif;

    }
    #gx{
      width: 150px;
      text-align: center;
      font-size: 15px;
      background: none;
      color: white;
      border: 1px solid white;
      margin-top: 10px;
    }
    </style>
  </head>
  <body>

    <form action="editPhoto.php" method="post">
      <table align="center" id="kk">
        <tr >
          <td>
            照片名称
          </td>
          <td >
            <input id="mc" type="text" name="photo_name" size="31"
              value="<?php echo $photo_name ?>">
          </td>
        </tr>
        <tr>
          <td>
            照片描述：
          </td>
          <td>
            <textarea id="ms" name="photo_comment" rows="5" cols="25"><?php echo $photo_comment ?></textarea>
            <input type="hidden" name="photo_id" value="<?php echo $photo_id ?>">
            <input type="hidden" name="album_id" value="<?php echo $album_id ?>">
            <br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="gx" type="submit" value="更新" id="btn"
              <?php if ($album_owner != $login_user) echo 'disabled' ?>>
          </td>
        </tr>



      </table>
    </form>
    <br><a href="showAlbum.php?album_id=<?php echo $album_id ?>" id="hxc">
      回 <?php echo $album_name ?> 相册</a>
  </body>
</html>
