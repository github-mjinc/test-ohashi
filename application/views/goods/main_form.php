  
  <div class="border col-7 mt-4 mx-auto">
    <!-- ①CSVファイルはリンクanchorで作っていく -->
    <!-- ※goods/csv_downloadを記述することで、csv_downloadコントローラーに移動ができる -->
    <?php echo anchor('goods/csv_download', 'CSVエクスポート', 'class="btn btn-outline-info btn-sm mt-3 mb-2 float-right"'); ?>
      <table class="table table-striped mt-3">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th>タイトル</th>
            <th>内容</th>
            <th>ファイル</th>
            <th>在庫状態</th>
            <th>編集</th>
            <th>削除</th>
          </tr>
        </thead>
        <tbody>
          <!-- ①resultで配列の中の情報を返す -->
          <!-- つまり$queryの配列の中を,resultで表示するという意味になる -->
          <!-- $queryはgetAllで、DBの情報を入れてる配列 -->
          <?php foreach( $query->result() as $row ):?>  
          <tr>
            <!-- ②$row->idでidの情報を取り出してくる（rowは結果を取り出すメソッド） -->
            <th scope="row"><?php echo $row->id?></th>
            <!-- ③rowで配列の中にあるtitleの１番目のデータを取り出してくる -->
              <td><?php echo $row->title?></td>
              <!-- ④rowで配列の中にあるgenreの１番目の情報を取り出してくる -->
              <td><?php echo $row->genre?></td>
              <!-- imageファイルの読み込み、$rowのimagesが空の場合にanchorでimageファイルにアクセス出来るようになる -->
              <td><?php if (!empty($row->images)) echo anchor('images/thumbs/'.$row->images, $row->images, 'target="_blank"')?></td>
              <!-- ⑤rowで配列の中にあるstockの１番目の情報を取り出してくる -->
              <td><?php echo $row->stock?></td>
              <td>
                <?php echo anchor('goods/edit/'.$row->id, '編集', 'class="btn btn-primary"')?>
              </td>
              <td>
                <!-- deleteでidをとってデータを消していくという方法 -->
                <!-- getでidを取得する -->
                <!-- idについて学習する -->
                <?php echo anchor('goods/delete/?id='.$row->id, '削除', 'class="btn btn-primary"')?>
              </td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
            