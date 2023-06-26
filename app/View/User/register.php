<!DOCTYPE html>
<html>

<head>
  <title><?= $model['title'] ?></title>
  <link rel="stylesheet" type="text/css" href="loginstyle.css">
</head>

<body>
  <div class="login">
    <h2 class="login-header">DAFTAR AKUN</h2>
    <form class="login-container" action="/register" method="post">
      <?php if (isset($model['error'])) { ?>
        <center><button class='tombol-biru'><?= $model['error'] ?></button></center>
      <?php } ?>
      <p>
        <input type="text" name="name" placeholder="Nama Lengkap" value="<?= $_POST['name'] ?? "" ?>" required>
      </p>
      <p>
        <input type="email" name="email" placeholder="Email" value="<?= $_POST['email'] ?? "" ?>" required>
      </p>
      <p>
        <input type="text" name="no_hp" placeholder="No HP" value="<?= $_POST['no_hp'] ?? "" ?>" required>
      </p>
      <p>
        <textarea name="address" rows="3" cols="80" placeholder="Alamat" required></textarea>
      </p>
      <hr>
      <p>
        <input type="text" name="username" maxlength="6" placeholder="Username" value="<?= $_POST['username'] ?? "" ?>" required>
      </p>
      <p>
        <input type="password" name="password" maxlength="6" placeholder="Password" required>
      </p>
      <p>
        <input type="submit" name="submit" value="DAFTAR">
      </p>
      <p align="center"><a href="#">kembali</a></p>
      <br>
    </form>

  </div>
</body>

</html>