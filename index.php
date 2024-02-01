<?php
@ob_start();
session_start();
if (isset($_POST['proses'])) {
    require 'koneksi.php';

    $user = strip_tags($_POST['user']);
    $pass = strip_tags($_POST['pass']);

    $sql = 'select member.*, login.user, login.pass
				from member inner join login on member.id_member = login.id_member
				where user =? and pass = md5(?)';
    $row = $config->prepare($sql);
    $row->execute(array($user, $pass));
    $jum = $row->rowCount();
    if ($jum > 0) {
        $hasil = $row->fetch();
        $_SESSION['admin'] = $hasil;
        echo '<script>alert("Login Sukses");window.location="kasir.php"</script>';
    } else {
        echo '<script>alert("Login Gagal");history.go(-1);</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>LOGIN</title>
    <link href="assets/login.css" rel="stylesheet">
</head>

<body>
    <div class="kotak_login">
        <h2>
            <p class="tulisan_login">Silahkan Login</p>
        </h2>
        <center>
            <img src="assets/img/logo.jpeg" alt="logo" class="logo" width="130" height="130">
        </center>
        <br>
        <form class="form-login" method="POST">
            <div class="form-group">
                <input type="text" class="form_login" name="user" placeholder="User ID" autofocus>
            </div>
            <div class="form-group">
                <input type="password" class="form_login" name="pass" placeholder="Password">
            </div>
            <button class="tombol_login " name="proses" type="submit">SIGN IN</button>
        </form>
    </div>
</body>

</html>