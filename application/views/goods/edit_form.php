<?php
$title = array(
  'name'  => 'title',
  'id'    => 'title',
  'class' => 'form-control',
  // $rowからtitleの情報を取ってくる/ここには基本情報が入る
  // $row->titleの記述をすることで、mainページで選択した情報を持ってきて、基本情報の中入った状態になる
  'value' => set_value('title', $row->title),
  'placeholder' => 'title',
  'maxlength' => 80,
  'size'  => 20,
);
?>

    <div class="border col-7 mt-5 mx-auto">
      <?php echo heading('データ編集', 2, 'class="mt-4"'); ?>
      <div class="row mt-5">
        <div class="col-md">
          <?php echo form_open_multipart(); ?>
            <div class="form-group">
              <?php echo form_label('タイトル:')?>
              <!-- $titleにarrayを入れて、変数で表示する方法 -->
              <?php echo form_input($title); ?>
              <?php echo form_error($title['name']); ?><?php echo isset($errors[$title['name']])?$errors[$title['name']]:'';?>
            </div>
            <div class="form-group">
              <?php echo form_label('内容:')?>
                <!-- set_valueの'genre'の右側に例えば、 'SF'と入れると、inputの中の基本情報がSFになる -->
                <!-- $row->genreと書くことで、id で取得した情報の中のgenreをinputの中に基本情報として入れておくことが出来る -->
                <?php echo form_dropdown('genre', $options, set_value( 'genre', $row->genre ), 'class= "form-control"'); ?>
                <?php echo form_error('genre'); ?><?php echo isset($errors['genre'])?$errors['genre']:'';?>
            </div>
            <div class="form-group">
              <?php echo form_label('在庫:')?>
              <?php echo form_dropdown('stock', $presences, set_value( 'stock', $row->stock ), 'class= "form-control"'); ?>
              <?php echo form_error('stock'); ?><?php echo isset($errors['stock'])?$errors['stock']:'';?>
            </div>
            <!-- ファイルップロード用の記述。CIは使えないため普通の記述。 -->
            <div id="upload">
              <label for="inputFile">ファイル:</label>
              <div class="custom-file">
                <input type="file" name = "userfile" class="custom-file-input" id="inputFile">
                <!-- nameのuserfileは重要！ここでファイルを取ってくる！ -->
                <label class="custom-file-label" for="inputFile" data-browse="参照">ファイルを選択（ここにドロップすることも出来ます）</label>
              </div>
              </div>
            </div>
        </div>
        <div class="row center-block text-center mt-4 mb-4">
          <div class="col-1">
          </div>
          <div class="col-5 mb-4">
            <!-- 画像が送信できないエラーがでた際、register→uploadに変更して解決 -->
            <?php echo form_submit('upload', '変更する', 'class="btn btn-outline-primary btn-block"'); ?>
          </div>
          <div class="col-5">
            <?php echo anchor('goods/index', '閉じる', 'class="btn btn-outline-secondary btn-block"')?>
          </div>
          </form>
        </div>
  </div>

  <!-- JSクリックした時にファイル表示&&ドラッグドロップでもOK -->
  <!-- 相対パスでフォルダを指定する -->
  <script src="../../js/goods.js"></script>
  <script>
    bsCustomFileInput.init();
  </script>