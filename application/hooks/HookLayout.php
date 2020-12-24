<!-- ③Hooksのコントローラー部分の記述 -->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * $this->load->vars(array('layout'=>'default'));
 * $this->load->vars(array('yield'=>FALSE));
 */
class HookLayout
{
    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->yield = $this->ci->load->get_var('yield');
        $this->ci->layout = $this->ci->load->get_var('layout');
        // CIで開発するときに現在のシステムで使ってるメモリやスピードSQLや変数などの環境の情報を確認
        // $this->ci->output->enable_profiler(TRUE);
        $this->ci->output->enable_profiler(TRUE);
    }
    public function doLayout()
    {
        global $OUT;
        $output = $this->ci->output->get_output();
        $output = $this->_set_layout($output);
        $OUT->_display($output);
    }
    private function _set_layout($output)
    {
      $view = NULL;

      $this->ci->yield  = isset($this->ci->yield) ? $this->ci->yield : TRUE;
        switch (true) {
            case isset($this->ci->layout):
                $this->ci->layout = $this->ci->layout;
                break;
            default:
                $this->ci->layout = 'default_layout';
                break;
        }
        if ($this->ci->yield === TRUE)
        {
            if (!preg_match('/(.+).php$/', $this->ci->layout))
            {
                $this->ci->layout .= '.php';
            }
            // 下の２行でlayoutsの場所を指定できる
            $requested = APPPATH . 'layouts';
            $requested .= '/' . $this->ci->layout;
            $layout = $this->ci->load->file($requested, true);
            $view = str_replace("{yield}", $output, $layout);
        }
        else
        {
            $view = $output;
        }
        return $view;
    }
}