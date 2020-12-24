<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/

// ②Hooksを使うための記述をする
// display_override　＝＞すべての処理が終わって、画面にその結果を表示する前に入れるコードを作成のこと
$hook['display_override'][] = array(
  'class'    => 'HookLayout',
  'function' => 'doLayout',
  'filename' => 'HookLayout.php',
  'filepath' => 'hooks'
  
);
