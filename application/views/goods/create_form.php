<?php
// php echo form_input('type="text", placeholder="title", class="form-control"');
// でも良いがoptionの項目が多くなるので、ページの一番上に定義しておく
$title = array(
  'name'  => 'title',
  'id'    => 'title',
  'class' => 'form-control',
  'value' => set_value('title'),
  'placeholder' => 'title',
  'maxlength' => 80,
  'size'  => 20,
);
?>

    <div class="border col-7 mt-5 mx-auto">
      <?php echo heading('データ登録', 2, 'class="mt-4"'); ?>
      <div class="row mt-5">
        <div class="col-md">
          <?php echo form_open_multipart(); ?>
            <div class="form-group">
              <?php echo form_label('タイトル:')?>
              <!-- ①上で定義した$titleがinputの属性に代入される -->
              <?php echo form_input($title); ?>
              <!-- ②下は個別のエラーメッセージを記述する（暗記する） -->
              <!-- isset関数は値がセットされているかどうかを判断するもの。セットされていなければ処理はしない。 -->
              <!-- isset関数は、変数に値がセットされていて、かつNULLでないときに、TRUEを戻り値として返します。 -->
              <?php echo form_error($title['name']); ?><?php echo isset($errors[$title['name']])?$errors[$title['name']]:'';?>
            </div>
            <div class="form-group">
              <?php echo form_label('内容:')?>
              <!-- ③おそらく$配列名で入力すれば大丈夫.$options -->
              <!-- ※configで設定したものを扱っている -->
              <!-- ※form_errorっていうのがバリデーションからのエラーのメッセージ -->
              <!-- ※errorsはバリデーションからではなくて開発者が何か確認するときに使っているエラーになります。 -->
              <!-- php echo 'まず、バリデーションのエラーを表示' php echo （開発者からのエラーがありますか？）?'あれば表示する':'なかったらNULL' -->
              <?php echo form_dropdown('genre', $options, set_value( 'genre' ), 'class= "form-control"'); ?>
              <?php echo form_error('genre'); ?><?php echo isset($errors['genre'])?$errors['genre']:'';?>
            </div>
            <div class="form-group">
              <?php echo form_label('在庫:')?>
              <!-- ③おそらく$配列名で入力すれば大丈夫.$presences -->
              <!-- ※configで設定したものを扱っている -->
              <!-- php echo form_dropdown('stock', $this->config->item('presences'), set_value( 'stock' ), 'class= "form-control"');  
                コントローラーに記述せずにこれでもできる-->
              <?php echo form_dropdown('stock', $presences, set_value( 'stock' ), 'class= "form-control"'); ?>
              <?php echo form_error('stock'); ?><?php echo isset($errors['stock'])?$errors['stock']:'';?>
            </div>
            <div id="upload">
              <label for="inputFile">ファイル:</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name = "userfile" class="custom-file-input" id="inputFile">
                  <!-- nameのuserfileは重要！ここでファイルを取ってくる！ -->
                  <label class="custom-file-label" for="inputFile" data-browse="参照">ファイルを選択（ここにドロップすることも出来ます）</label>
                </div>
                <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary input-group-text" id="inputFileReset">取消</button>
                </div>
                </div>
              </div>
              </div>
            </div>
            <div class="row center-block text-center mt-4 mb-4">
              <div class="col-1">
              </div>
              <div class="col-5 mb-4">
                <?php echo form_submit('upload', '登録する', 'class="btn btn-outline-primary btn-block"'); ?>
              </div>
              <div class="col-5">
                <?php echo anchor('goods/index', '閉じる', 'class="btn btn-outline-secondary btn-block"')?>
              </div>
              </form>
            </div>
      </div>
 
       <!-- JSクリックした時にファイル表示&&ドラッグドロップでもOK -->
       <!-- 相対パスでファイルを指定する　CDN外部ファイルの読み込みでの記述は極力避ける -->
  <script src="../../js/goods.js"></script>
  <script>
    bsCustomFileInput.init();
    document.getElementById('inputFileReset').addEventListener('click', function() {
    var elem = document.getElementById('inputFile');
    elem.value = '';
    elem.dispatchEvent(new Event('change'));
  });
  </script>