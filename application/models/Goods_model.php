  <?php
  // CI_Modelを継承して、User_modelを作成
  class Goods_model extends CI_Model
  {
  private $goods= 'goods';
  // エラーメッセージを入れる箱arrayを作成
  private $error = array();
  var $gallery_path;
  var $gallery_path_url;
  
  public function __construct()
  {
    parent::__construct();
    $this->gallery_path = realpath("./images/");
    $this->gallery_path_url = base_url(). "./images/";
  }

  // アップロードするファイルの設定を行う
  function do_upload(){
    // ①$config、でデータの保存方法を定義する
    $config = array(
      // ファイルのアップロード制限
      "allowed_types"=>"jpg|jpeg|gif|png",
      // ファイルのアップロード先を決める
      "upload_path"=>$this->gallery_path,
      // 3MB以上の画像は受け付けない
      "max_size" => 3000
    );

    // ②第2引数で条件を受け取ることができる(uploadの情報に$configの追加情報を増やしてlibraryに格納する)
    $this->load->library("upload", $config);
    // ③create_formで入力された情報に$configで追加したuploadを、アップロードするメソッド（追加された設定を反映できる）
    $this->upload->do_upload();
    
    // ④アップロードしたファイルについての情報を配列で返すメソッド/$this->upload->data()
    // 今回は、$this->upload->dataの情報を、$image_dateに格納している
    // ※この配列をprint_rで確認ができる
    $image_data = $this->upload->data();
  
    // ⑤再度設定項目を$configにて追加
    $config = array(
      // 処理する元の画像ファイルパスを絶対パス、または、ドキュメントルートからの相対パスで指定します。
      // ※今回は、full_pathなので、絶対パスで指定をしている
      // [source_image] => /Applications/MAMP/htdocs/oohashi-test/images/camp.jpg
    "source_image"=> $image_data["full_path"],
    // 出力対象の画像ファイル名/パスをセットします。この設定項目は、画像のコピーを作成するときに使います。
    // パスは、URLではなく、サーバの相対、または、絶対パスを指定する必要があります。
    // [new_image] => /Applications/MAMP/htdocs/oohashi-test/images/thumbs
    "new_image" =>$this->gallery_path . "/thumbs",
    // リサイズされるときや、固定の値を指定したとき、もとの画像のアスペクト比を維持するかどうかを指定する
    "maintain_ratio"=>true,
    // 横幅
    "width"=>150,
    // 縦幅
    "height"=>100
  );
  
  // ⑥イメージライブラリは次のように引数をとります。
  // 先ほどまでに設定をした画像を,image_libとして、ライブラリに読み込む
  // 引数はライブラリ読み込み前に定義しておきます。
  $this->load->library("image_lib", $config);
  // ⑦configで新たに設定した画像のサイズ等にリサイズする記述
  $this->image_lib->resize();
 
  // ⑧ここまでで、データの保存を行ったので、最後にコントローラーreturnするデータを記述する
  // かなり重要！ここで詰まっていた。
  return $image_data;
  }
  
  function get_images(){
    // ①scandirでは、指定したパスのディレクトリの内容を配列で取得できる
    // 指定されたパスのファイルとディレクトリのリストを取得する
    // 今回はthumbsのフォルダのリストを取り出してきている
    $files = scandir($this->gallery_path);
  
    // ②array_diffでは配列の差分を計算
//     Array
// (
//     [0] => .
//     [1] => ..
//     [2] => camp.jpg
//     [3] => camp1.jpg
//     [4] => camp2.jpg
//     [5] => camp3.jpg
//     [6] => camp4.jpg
//     [7] => camp5.jpg
//     [8] => camp6.jpg
// )
    $files=array_diff($files, array("thumbs"));
  
    // ④まずはarrayを実行
    $images = array();

    // 実行済のarrayにforeachで値を挿入していく
    foreach($files as $file){
      $images[]= array(
  
        // URLバージョンのギャラリーパスを利用
        "url" =>$this->gallery_path_url . $file,
        "thumb_url" =>$this->gallery_path_url."thumbs/".$file
      );
    }
    return $images;
  }

  // DBのテーブルから情報を取り出すメソッド
  public function getAll()
  {
    // ①DBにてデータを取り出すコマンドを使う
    // $this->db->getでselect * テーブルと同じで全データの取得
    // 取得した後は、結果を表示するために変数に代入する
  $query = $this->db->get($this->goods);
  // ②modelにいるので、コントローラーで使うためにreturnで値を戻してくる
  return $query;
  }

  // DBに情報を保存するメソッド
  // ここの$dataについては、情報に名前をつけただけなので名前はなんでも良い
  // コントローラーの$postが突然$dataに変わっているが、名前を分かりやすくしただけなので大丈夫
  public function register($data=NULL)
  {
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    // exit;
    // ①配列もしくはオブジェクトでメソッドにデータを渡せる
    // この場合は、$dataをgoodsテーブルにinsertするという意味になる。
    // 重複するが、$dataの名前はなんでも良い(コントローラーでは$postになっているが気にしない)
    if ( !$this->db->insert($this->goods, $data) )
    {
      // ②開発者側へのエラーメッセージを作成
      // 上でメッセージを入れる箱$errorを作ったのでその中に開発者側のメッセージを格納する記述
      $this->error = array('title' => '失敗しました。');
      return NULL;
    }
    // ③成功したらTRUEを返す（正常にデータが入ったということ）
    // コントローラーでif文の中にいるのでreturn trueが使える
    return TRUE;
  }

  // idを取得するメソッド
  // $idの中身だけがないという意味(変数自体は存在する)
  // 今回は$idの中身だけがないということにしておく
  public function get_by_id($id=NULL)
  {
    // ①idとnullは同じですか？つまりIDはありますか？なければNULLを返す
    // ※先にIDの中身があるかどうかの記述をしておく
    if ( $id == NULL ) return NULL;
    // ②dbでIDを確認する
    // $this->db->whereで特定のデータを探す
    // 今回は取ってきた$idのidを取得している
    // この記述をしないと全てのデータを$this->db->getで取ってしまうため、絶対必要！
    $this->db->where('id', $id); 
    // ③$this->db->get(テーブル名でテーブル内の全レコードを取り出すことができる)
    // 今回は$idのidを取得しているのでそちらを取り出している。
    // 上の記述がなければ全てのデータを取ってきてしまう
    // select from文を生成する（データの取得）
    // 今回は、取り出したデータを$queryに代入している
    $query = $this->db->get($this->goods);
    // ④$queryの結果(row)をコントローラーに返す
    // $query->row()は単一のデータのみを返すメソッド
    // 全てのデータの場合はresult_array()
    // このメソッドを使わなければ配列の中の１つのデータを取り出すことになる
    // データを単体で取り出す場合にrow()を使う（詳しくはソンモさんの動画で確認）
    // 配列の中のデータではなく、データのみで取得できる
    #return $queryにすると全てのデータを取得することになる
    return $query->row();
  }

  // 実際に修正をする
  public function modify( $data=NULL, $id=NULL )
  {
    // ①片方でもデータがなければ、NULLを返すという記述
    // ||は"or"と同じ意味/&は&&で記述する
    if ( !$data || !$id ) return NULL;

    // ②$this->db->update()分/データの更新を行う
    // この２つの文章はセットで使う（クエリビルダクラス）
    // replaceも使うが基本はupdateを使う
    $this->db->where('id', $id);
    // ③updateしたデータを$dataに入れて、returnでコントローラーに返す
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    // exit;
    return $this->db->update($this->goods, $data);
  }

  // データベースから削除するメソッド
  public function delete($id=NULL)
  {
    // ①もしIDが無かったらNULLを返す
    // IDの中に何もないですか？という意味!$id
    if (!$id) return NULL;

    // 実際に削除
    // ②$this->db->where"name",$idでdbの中のデータを選択できる
    // 選択したら消すという流れ
    $this->db->where('id', $id);
    // ③DBコマンドdeleteでテーブルから削除する
    // $this->db->where('id', $id);
    // $this->db->delete('mytable');　これはセットで使う！（クエリビルダクラス）
    // この２つを記述するとIDを削除するということになる
    // $this->db->deleteコマンドは、データベースコマンドDELETE FROM mytableを生成する
    return $this->db->delete($this->goods);
  }

  /**
   * Get error message.
   * @return  string
   */
  public function get_error_message()
  {
    return $this->error;
  }



}