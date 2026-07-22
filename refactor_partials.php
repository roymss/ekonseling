<?php

$dir = 'c:/laragon/www/ekonseling/ekonseling-laravel/resources/views/partials/';
$files = glob($dir . '*.blade.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // session flashdata
    $content = str_replace('$this->session->flashdata', 'session', $content);
    
    // session userdata/username/level
    $content = preg_replace('/\$this->session->([a-zA-Z0-9_]+)/', 'session(\'$1\')', $content);
    
    // $this->uri->segment
    $content = str_replace('$this->uri->segment', 'request()->segment', $content);
    
    // $this->db->query -> DB::select
    $content = str_replace('$this->db->query', '\Illuminate\Support\Facades\DB::select', $content);
    
    // $this->model_utama->view_join_two
    $content = preg_replace('/\$this->model_utama->view_join_two\(\'([a-zA-Z0-9_]+)\',\'([a-zA-Z0-9_]+)\',\'([a-zA-Z0-9_]+)\',\'([a-zA-Z0-9_]+)\',\'([a-zA-Z0-9_]+)\',array\((.*?)\),\'([a-zA-Z0-9_]+)\',\'([a-zA-Z0-9_]+)\',([0-9]+),([0-9]+)\)/', '\Illuminate\Support\Facades\DB::table(\'$1\')->join(\'$2\', \'$1.$4\', \'=\', \'$2.$4\')->join(\'$3\', \'$1.$5\', \'=\', \'$3.$5\')->where([$6])->orderBy(\'$7\', \'$8\')->skip($9)->take($10)->get()', $content);

    // $this->model_utama->view_ordering_limit
    $content = preg_replace('/\$this->model_utama->view_ordering_limit\(\'([a-zA-Z0-9_]+)\',\'([a-zA-Z0-9_]+)\',\'([a-zA-Z0-9_]+)\',([0-9]+),([0-9]+)\)/', '\Illuminate\Support\Facades\DB::table(\'$1\')->orderBy(\'$2\', \'$3\')->skip($4)->take($5)->get()', $content);

    // $this->model_utama->view_where
    $content = preg_replace('/\$this->model_utama->view_where\(\'([a-zA-Z0-9_]+)\',array\((.*?)\)\)/', '\Illuminate\Support\Facades\DB::table(\'$1\')->where([$2])', $content);
    
    // ->num_rows()
    $content = str_replace('->num_rows()', '->count()', $content);
    
    // ->result_array()
    $content = str_replace('->result_array()', '', $content);
    
    // ->row_array()
    $content = str_replace('->row_array()', '->first()', $content);
    
    // Fix object vs array notation since DB::table returns objects
    // We will do a generic replacement of $row['key'] to $row->key for known variables
    $content = preg_replace('/\$([a-zA-Z0-9_]+)\[\'([a-zA-Z0-9_]+)\'\]/', '$$1->$2', $content);

    file_put_contents($file, $content);
    echo "Refactored $file\n";
}
