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
}
?>