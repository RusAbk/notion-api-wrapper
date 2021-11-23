<?php
class Notion{
    private $key;
    private $auth_h;
    private $version_h = 'Notion-Version: 2021-08-16';


    private $curl;


    private function curl_get($url, $headers = []){
        curl_setopt($this->curl, CURLOPT_POST, false);

        array_push($headers, $this->auth_h, $this->version_h);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->curl, CURLOPT_URL, $url);

        return curl_exec($this->curl);
    }
    private function curl_post($url, $data = [], $headers = []){
        array_push($headers, $this->auth_h, $this->version_h);
        
        $post_data = http_build_query($data);
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        return curl_exec($this->curl);
    }

    function __construct($key){
        $this->key = $key;
        $this->auth_h = 'Authorization: Bearer ' . $this->key;

        $this->curl = curl_init();

        // curl settings ===============
        // return result as a string instead of put it to response
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        // save error information to stderr
        curl_setopt($this->curl, CURLOPT_VERBOSE, 1);
    }

    function get_db_info($id){
        return $this->curl_get('https://api.notion.com/v1/databases/' . $id, []);
    }
    function get_db_info_arr($id){
        return json_decode($this->get_db_info($id));
    }
    
    function get_db_items($id, $options = []){
        return $this->curl_post('https://api.notion.com/v1/databases/' . $id . '/query', $options);
    }
    function get_db_items_arr($id, $options = []){
        return json_decode($this->get_db_items($id, $options));
    }
}
?>