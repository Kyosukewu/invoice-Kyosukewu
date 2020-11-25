<?php include_once("base.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a1381bb91e.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/style.css">
  <title>統一發票紀錄及對獎系統</title>
</head>

<body>
  <div class="bg">
    <img class="bg1" src="https://i.postimg.cc/WbXLXfFs/bg1.png" alt="">
    <img class="bg2" src="https://i.postimg.cc/9MNNw1DB/bg3.png" alt="">
    <img class="bg3" src="https://i.postimg.cc/hvkypjbz/bg4.png" alt="">
    <img class="bg4" src="https://i.postimg.cc/x8JpvHHV/bg5.png" alt="">
  </div>
  <div class="container">
    <div class="book">
      <?php
      $month = [
        1 => "1-2月",
        2 => "3-4月",
        3 => "5-6月",
        4 => "7-8月",
        5 => "9-10月",
        6 => "11-12月",
      ];
      // $m = ceil(date("m") / 2);
      if (empty($_GET['p'])) {
        $period = ceil(date("m") / 2);
      } else {
        $period = $_GET['p'];
      }

      $leftPage = "main";
      $rightPage = "invoice_list";

      ?>
      <div class="path1">
        <div class="p0 text-light bg-info mb-1"><?= $month[$period]; ?></div>
        <div class="p1 bg-success mb-1"><a href="?in=<?= $leftPage ?>&do=invoice_list">當期發票</a></div>
        <div class="p2 bg-danger mb-1"><a href="?in=add_awards&do=award_numbers">全期對獎</a></div>
        <div class="p3 bg-dark mb-1"><a href="index.php">闔上</a></div>
      </div>
      <div class="path2">
        <div class="p4 bg-primary mb-1"><a href="?in=main&do=<?= $rightPage ?>">輸入發票</a></div>
        <div class="p5 bg-warning mb-1"><a href="?in=add_awards&do=award_numbers">輸入獎號</a></div>
      </div>
      <div class="content">
        <div class="content-l col-12 col-lg-6">
          <div class="card-img-overlay">
            <?php
            if (isset($_GET['in'])) {
              $file = $_GET['in'] . ".php";
              include $file;
            } else {
              include "main.php";
            }
            ?>
          </div>

        </div>
        <div class="content-r col-12 col-lg-6">
          <div class="card-img-overlay">
            <?php
            if (isset($_GET['do'])) {
              $file = $_GET['do'] . ".php";
              include $file;
            } else {
              include "invoice_list.php";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
<?php $_SESSION['err'] = []; ?>
<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
  var toastElList = [].slice.call(document.querySelectorAll('.toast'))
  var toastList = toastElList.map(function(toastEl) {
    return new bootstrap.Toast(toastEl, option)
  })
</script>
<script>
  var myModal = document.getElementById('myModal')
  var myInput = document.getElementById('myInput')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })
</script>