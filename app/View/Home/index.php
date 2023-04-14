<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Kios Jersey | Pace</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="header">
    <p>Kios Jersey | PACE</p>
  </div>
  <nav>
    <ul>
      <li><a href='?page=beranda'>Beranda</a></li>
      <li><a href='?page=belanja'>Pesanan</a></li>
      <li><a href='?page=profil'>Profil</a></li>
      <li><a href='?page=tentang'>Tentang</a></li>
      <li class='logout'><a href='page/logout.php'>keluar</a></li>
      <li class='login'><a><b>Hey, </b>user malik</a></li>
    </ul>
  </nav>

  <div class="box-title bg-info">
    <p>Beranda / <b>Produk Jualan</b></p>
  </div>
  <div class="box">
    <?php
    require __DIR__ . $view . '.php';
    ?>
  </div>
  <div class="footer">
    <p>copyright by | pace | Repost by <a href="" target="_blank">Framework Id</a></p>
  </div>

</body>

</html>