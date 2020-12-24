  <?php echo form_open('goods/delete/?id='.$id); ?>
    <div class="border col-7 mt-5 mx-auto">
      <?php echo heading('削除 内容確認', 1, 'class="delete mt-4"'); ?>
      <p class="text_delete mt-5">こちらの内容を取り消してもよろしいでしょうか？</p>
      <p class="text_delete">よろしれば、「削除する」ボタンを押してください。 </p>
      <div class="border col-12 mt-4">
        <table class="table table-striped mt-3">
          <thead class="thead-dark">
            <tr>
              <th>#</th>
              <th>タイトル</th>
              <th>内容</th>
              <th>ファイル</th>
              <th>在庫状態</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <!-- ①modelsのget_idからデータが送られてきたので、$row->idで送られてきたデータを表示する -->
              <!-- 送られてきたデータは、queryから選ばれた１つのデータになっている -->
              <th scope="row"><?php echo $row->id?></th>
              <!-- ②$rowのtitleの情報だけが欲しければ、$row->titleで出力できる -->
                <td><?php echo $row->title ?></td>
                <!-- ③$optionで定義した内容の中のgenreを出力する -->
                <td><?php echo $options[$row->genre] ?></td>
                <!-- ③imagesを出力する -->
                <td><?php echo $row->images ?></td>
                 <!-- ⑤$optionで定義した内容の中のstockを出力する -->
                <td><?php echo $presences[$row->stock] ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="row center-block text-center mt-5 mb-5">
        <div class="col-6">
          <!-- hiddenのinputを作成。おそらくアラートをつける場合に必要になるもの -->
          <input type="hidden" name="agree" value="1" />
          <?php echo form_submit('delete', '削除', 'class="btn btn-outline-primary btn-block"'); ?>
        </div>
        <div class="col-6">
          <?php echo anchor('goods/index', '取り消す', 'class="btn btn-outline-secondary btn-block"')?>
        </div>
    </div>
  </div>
  </form> 