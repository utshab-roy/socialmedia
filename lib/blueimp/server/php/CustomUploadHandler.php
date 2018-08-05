<?php
session_start();


require('UploadHandler.php');
class CustomUploadHandler extends UploadHandler {
    public function __construct(){
        $new_options = array(
            'upload_dir' => dirname($this->get_server_var('SCRIPT_FILENAME')).'/users/',
            'upload_url' => $this->get_full_url().'/users/'
        );
        parent::__construct($new_options);
    }
    protected function trim_file_name($file_path, $name, $size, $type, $error, $index, $content_range) {
        $name = $_SESSION['user_id'];
        //deleting the previous uploaded file if exists
        if (file_exists('users/'.$name.'.jpeg')) {
            unlink('users/'.$name.'.jpeg');
        }

        $name = str_replace('.', '', $name);
        return $name;
    }
}