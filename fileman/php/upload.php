<?php
/*
  RoxyFileman - web based file manager. Ready to use with CKEditor, TinyMCE. 
  Can be easily integrated with any other WYSIWYG editor or CMS.

  Copyright (C) 2013, RoxyFileman.com - Lyubomir Arsov. All rights reserved.
  For licensing, see LICENSE.txt or http://RoxyFileman.com/license

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

  Contact: Lyubomir Arsov, liubo (at) web-lobby.com
*/
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('UPLOAD');
checkAccess('UPLOAD');


function translit($s) { // добавили транслитерацию (также строка 55)
  $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
  $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z', 
      'и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t',
      'у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya',
      'ъ'=>'','ь'=>''));
  return $s; // возвращаем результат
}

$isAjax = (isset($_POST['method']) && $_POST['method'] == 'ajax');
$path = trim(empty($_POST['d'])?getFilesPath():$_POST['d']);
verifyPath($path);
$res = '';
if(is_dir(fixPath($path))){
  if(!empty($_FILES['files']) && is_array($_FILES['files']['tmp_name'])){
    $errors = $errorsExt = array();
    foreach($_FILES['files']['tmp_name'] as $k=>$v){
      $filename = $_FILES['files']['name'][$k];
      $filename = RoxyFile::MakeUniqueFilename(fixPath($path), $filename);
      $filePath = fixPath($path).'/'.$filename;
      $isUploaded = true;
      if(!RoxyFile::CanUploadFile($filename)){
        $errorsExt[] = $filename;
        $isUploaded = false;
      }
      elseif(!move_uploaded_file($v, translit($filePath))){
         $errors[] = $filename; 
         $isUploaded = false;
      }
      if(is_file($filePath)){
         @chmod ($filePath, octdec(FILEPERMISSIONS));
      }
      if($isUploaded && RoxyFile::IsImage($filename) && (intval(MAX_IMAGE_WIDTH) > 0 || intval(MAX_IMAGE_HEIGHT) > 0)){
        RoxyImage::Resize($filePath, $filePath, intval(MAX_IMAGE_WIDTH), intval(MAX_IMAGE_HEIGHT));
      }
    }
    if($errors && $errorsExt)
      $res = getSuccessRes(t('E_UploadNotAll').' '.t('E_FileExtensionForbidden'));
    elseif($errorsExt)
      $res = getSuccessRes(t('E_FileExtensionForbidden'));
    elseif($errors)
      $res = getSuccessRes(t('E_UploadNotAll'));
    else
      $res = getSuccessRes();
  }
  else
    $res = getErrorRes(t('E_UploadNoFiles'));
}
else
  $res = getErrorRes(t('E_UploadInvalidPath'));

if($isAjax){
  if($errors || $errorsExt)
    $res = getErrorRes(t('E_UploadNotAll'));
  echo $res;
}
else{
  echo '
<script>
parent.fileUploaded('.$res.');
</script>';
}
?>
