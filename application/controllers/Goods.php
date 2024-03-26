<?php
// 基本CIではこの記述を入れておく
// 「BASEPATH」がindex.phpで定義されていない場合は直接のアクセスは許可されない。不要なユーザーをフォルダやファイルに入れないようにするための記述
  defined('BASEPATH') OR exit('No direct script access allowed'); 

  class Goods extends CI_Controller {
    public function __construct()
    {
      parent::__construct();
      $this->load->helper(array('form', 'url', 'download'));
      $this->load->vars(array('layout'=>'admin_layout'));
      $this->load->model('goods_model'); 
      $this->load->library('javascript');
    }

    public function index(){
      // ①modelからデータを取るためにgetAllへ移動する
      $data['query'] = $this->goods_model->getAll();
      // ②imagesを加工したデータを取得してくる
      $data["images"] = $this->goods_model->get_images();
      // ③viewにデータを表示するための記述
      $this->load->view('goods/main_form', $data);
    }

    // CSVファイルのダウンロードメソッド(indexの中ではこのメソッドは作らない)
    // 下が作成の例↓
    // $this->load->dbutil();
    // $query = $this->db->query("SELECT * FROM mytable");
    // echo $this->dbutil->csv_from_result($query);
    public function csv_download(){
      //ここでCSVを生成するコードを入れる
      // ①index同様getAllで情報を取得する
      $query = $this->goods_model->getAll();
      // ②データベースユーティリティークラスをロードする
      $this->load->dbutil();
      // ③ヘルパーメソッドdownloadを使用する
      $this->load->helper('download');
      // ④$queryの情報をcsvファイルに変更する
      $data = $this->dbutil->csv_from_result($query);
      // ⑤csvファイルの名前を決める
      $name = 'data.csv';
      // ⑥作成したCSVファイルをダウンロードする
      force_download($name, $data);
}

    public function create(){
      // ②バリデーションの作成
      // titleは <input name="title" />このinputのnameを使う/タイトルは項目名/optionはデータがあるかの確認
      $this->form_validation->set_rules('title', 'タイトル', 'trim|required');
      $this->form_validation->set_rules('genre', '内容', 'trim|required');
      $this->form_validation->set_rules('stock', '在庫', 'trim|required');

      // ③do_uploadにてサイズの設定ができれば、次はバリデーションを使う
      // 「run()」メソッドで「FALSE」が返った場合はエラーメッセージを取得
      if ($this->form_validation->run())
      {
        // ④取得した情報を持って、modelのdo_uploadを行い
        // do_uploadで出来たデータを$image_dateに格納する←重要！！（ここで詰まっていた）
        // これをすると、実際にファイルは保存するが、保存した後にその結果をもらう変数が必要となるので$image_dateに格納する
        $image_data = $this->goods_model->do_upload();
        // echo '<pre>';
        // print_r($image_data);
        // echo '</pre>';
        // exit;

        // ⑤modelに送る用の情報を記述する
        // 複数の情報を１つの配列 $post にする
        $post = array(
          // ⑦ここで配列にKEYを持たせる("title"=>のように)
          // ※配列の名前
          // それがDBのtableの項目になる
          // 「form_validation」もよく使うのでAutoloadに入れておく
          'title' => $this->form_validation->set_value('title'),
          'genre' => $this->form_validation->set_value('genre'),
          'stock' => $this->form_validation->set_value('stock'),
          'images' => $image_data['file_name'],
        );
        // ⑦DBに登録をしていくメソッド(models)
        // 上のデータを$postに配列として代入。モデルの、registerアクションに移動する
        // DBに登録が成功ですか？↓
        if ( $this->goods_model->register($post) )
        {
          //成功
          // ⑧成功ならば、goodsのリスト画面へ遷移
          redirect('goods');
        }
        else
        {
          //失敗
          // ⑧失敗ならmodelsのget_error_messageへ移動
          // その結果を保存した後に、結果を表示するために$errorsに格納する
          $errors = $this->goods_model->get_error_message();
          foreach ($errors as $k => $v) $data['errors'][$k] = $v;
        }
        exit;
      }

      // コントローラーに定義していたものを、configにした際にこちらの記述に変更
      // 設定ファイルから設定項目を読み取るには、次のメソッドを使います
      // $this->config->item('item_name');と記述する
      // にしてるのでViewで$presencesを使うと思いますが
      $data['options'] = $this->config->item('options');
      $data['presences'] = $this->config->item('presences');

      $this->goods_model->get_images();

      // ①createページのviewの読み込み
      // configファイルで定義をした,$dataを使用できる（固定値は基本的にはconfigファイルに入れる）
      $this->load->view('goods/create_form', $data);
    }

    // 削除画面
    public function delete(){
      // ①サーバーから情報を取り出すためのメソッド（$this->input->get）
      // getでidをもらって$dataに格納する
      $data['id'] = $this->input->get('id');
      // ②バリデーションをかけるためのset_rulesを記述
      // ここはhiddenのinputの確認をしている？
      $this->form_validation->set_rules('agree', '確認', 'trim|required');
      // ③バリデーションを発動する
      if ($this->form_validation->run())
      {
        // ④modelsで本当に消すメソッドへ
        if($this->goods_model->delete($data['id']))
        {
          // 成功
          redirect('goods');
        }
        else
        {
          // 失敗
          // ④失敗した場合は開発者側にエラーメッセージが表示される
          $errors = $this->goods_model->get_error_message();
          foreach ($errors as $k => $v) $data['errors'][$k] = $v;
        }
      }
      // モデルのget_by_idで取得したIDが$data['row']に入る
      $data['row'] = $this->goods_model->get_by_id($data['id']);

      // ⑤基準となる情報を再度記述する
      $data['options'] = $this->config->item('options');
      $data['presences'] = $this->config->item('presences');
      
      $this->load->view('goods/delete_form', $data);
    }

    // 編集画面
    public function edit(){
      // ①IDをセグメントで取得する(http//oohashi/1/2←これがセグメント)
      // →http:oohasi/params/dateみたいな感じで,paramsが第一セグメント、dateが第2セグメント
      // 今回のIDは第３セグメントなので、そこのIDを取得する
      // URIルーティング後のパス情報を取得するメソッド
      $data['id'] = $this->uri->segment(3);

      // ここの記述でエラーメッセージが表示される
      $this->form_validation->set_rules('title', 'タイトル', 'trim|required');
      $this->form_validation->set_rules('genre', '内容', 'trim|required');
      $this->form_validation->set_rules('stock', '在庫', 'trim|required');
      $this->form_validation->set_rules('userfile', 'ファイル', 'trim');

      // POSTデータとして「userfile」のデータがあるかどうか確認
      // echo '<pre>';
      // print_r($_POST);
      // print_r($_FILES);
      // echo '</pre>';

      if ($this->form_validation->run())
      { 
        // ②do_uploadでimageの設定を決める→$image_dataに格納
        $image_data = $this->goods_model->do_upload();

        $post = array(
          'title' => $this->form_validation->set_value('title'),
          'genre' => $this->form_validation->set_value('genre'),
          'stock' => $this->form_validation->set_value('stock'),
          'images' => $image_data['file_name'],
          'userfile' => $this->form_validation->set_value('userfile'),
        );
        // ③ここで自分のIDが必要になるため、$data['id']を追記しておく
        if ( $this->goods_model->modify($post, $data['id']) )
        {

          //成功
          redirect('goods');
        }
        else
        {
          //失敗
          $errors = $this->goods_model->get_error_message();
          foreach ($errors as $k => $v) $data['errors'][$k] = $v;
        }
        exit;
      }

      $data['row'] = $this->goods_model->get_by_id($data['id']);
      // echo '<pre>';
      // print_r($data);
      // echo '</pre>';
      // exit;
      $data['options'] = $this->config->item('options');
      $data['presences'] = $this->config->item('presences');

      $this->load->view('goods/edit_form', $data);
      // echo '<pre>';
      // print_r($data);
      // echo '</pre>';
      // exit;
      
    }

  }
