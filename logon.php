<?php
  if (isset($_POST["account"]))
  {
    require_once("dbtools.inc.php");

    //获取登录资料
    $login_user = $_POST["account"];
    $login_password = $_POST["password"];

    //建立数据连接
    $link = create_connection();

    //检查账号密码是否正确
    $sql = "SELECT account, name FROM user Where account = '$login_user'
            AND password = '$login_password'";
    $result = execute_sql($link, "album", $sql);

    //若没找到数据，表示账号密码错误
    if (mysqli_num_rows($result) == 0)
    {
      //释放 $result 占用的内存
      mysqli_free_result($result);

      //关闭数据连接
      mysqli_close($link);

      //显示信息要求用户输入正确的账号密码
      echo "<script type='text/javascript'>alert('账号密码错误，请查明后再登录')</script>";
    }
    else     //如果账号密码正确
    {
      //将用户资料加入 Session
      session_start();
      $row = mysqli_fetch_object($result);
      $_SESSION["login_user"] = $row->account;
      $_SESSION["login_name"] = $row->name;

      //释放 $result 占用的内存
      mysqli_free_result($result);

      //关闭数据连接
      mysqli_close($link);

      header("location:index.php");
    }
  }
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>电子相册</title>
    <link rel="stylesheet" href="./css/login-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
  </head>
  <body>

    <form action="logon.php" method="post" name="myForm">
      <!-- <table align="center">
        <tr>
          <td>
            账号：
          </td>
          <td>
            <input type="text" name="account" size="15">
          </td>
        </tr>
        <tr>
          <td>
            密码：
          </td>
          <td>
            <input type="password"name="password" size="15">
          </td>
        </tr>
        <tr>
          <td align="center" colspan="2">
            <input type="submit" value="登录">
            <input type="reset" value="重新填写">
          </td>
        </tr>
      </table> -->
      <div class="login-box">
        <h1>登录</h1>
        <div class="textbox">
          <i class="fas fa-user"></i>
          <input type="text" placeholder="user" name="account">
        </div>
        <div class="textbox">
          <i class="fas fa-lock"></i>
          <input type="password" placeholder="password" name="password">
        </div>
        <input class="btn" type="submit" name="" value="提交">
        <input class="btn" type="submit" name="" value="重新填写">
      </div>
    </form>
  </body>
</html>
