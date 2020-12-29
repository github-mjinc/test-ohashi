<?php echo doctype("html5"); ?>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- shirinkに関しては、JS用の記述で書いているのであとで調べる -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>oohashi-test</title>
    <!-- BootstrapのCSS読み込み -->
    <link rel="stylesheet" href="<?php echo base_url()?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>css/style.css">
    <!-- JS用の記述 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- BootstrapのJS読み込み -->
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
      <!-- 下の記述で、他のファイルをここに代入できる -->
    {yield}
      </div>
    </body>
  </html>