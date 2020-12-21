<?php echo doctype("html5"); ?>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>oohashi-test</title>
    <!-- BootstrapのCSS読み込み -->
    <link rel="stylesheet" href="<?php echo base_url()?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>css/style.css">
    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- BootstrapのJS読み込み -->
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
    {yield}
      </div>
    </body>
  </html>