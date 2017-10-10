<?php
namespace Basic;

use Basic\Auth;
use Basic\DB;
use Basic\Download;
use Basic\Image;
use Basic\Mail;
use Basic\Migration;
use Basic\Sheet;
use Basic\Upload;
use Basic\View;

class Basic{
    var $db_cfg;
    var $view;
    function __construct($cfg=null){
        $this->db_cfg=@$cfg['mysql'];
        $this->mail_cfg=@$cfg['smtp'];
        $this->view=new View();
    }
    function app($name){
        $filename=ROOT.'app/'.$name.'.php';
        if(file_exists($filename)){
            require $filename;
            $class='App\\'.$name;
            return new $class($this);
        }else{
            die('app <b>'.$filename.'</b> not found');
        }
    }
    function array_to_sheet($array,$sheet_name){
        $obj=new Sheet();
        return $obj->to_sheet($array,$sheet_name);
    }
    function auth(){
        return new Auth($this->db_cfg);
    }
    function count($table,$where){
        return $this->db()->count($table,$where);
    }
    function create($table,$data){
        return $this->db()->create($table,$data);
    }
    function db(){
        return new DB($this->db_cfg);
    }
    function delete($table, $where){
        return $this->db()->delete($table, $where);
    }
    function drop_all(){
        return $this->migration()->drop_all();
    }
    function first_word($str){
        return $this->view->first_word($str);
    }
    function get($url,$agent,$cookie){
        $obj=new Download();
        return $obj->get($url,$agent,$cookie);
    }
    function i18n($key,$print=true){
        return $this->view->i18n($key,$print);
    }
    function image_auto_orient($src,$dst=false){
        return $this->image()->auto_orient($src,$dst);
    }
    function image_crop($src,$dst,$x1,$y1,$x2,$y2){
        return $this->image($src);
    }
    function image(){
        return new Image();
    }
    function image_info($src){
        return $this->image()->info($src);
    }
    function image_resize($src,$dst,$max_width,$max_height){
        return $this->image()->resize($src,$dst,$max_width,$max_height);
    }
    function image_thumb($src,$dst,$width,$height){
        return $this->image()->thumb($src,$dst,$width,$height);
    }
    function is_ajax(){
        return $this->view->is_ajax();
    }
    function is_auth(){
        return $this->auth()->is_auth();
    }
    function json($data){
        return $this->view->json($data);
    }
    function logout(){
        return $this>auth()->logout();
    }
    function mail(){
        return new Mail($this->mail_cfg);
    }
    function method(){
        return @$_SERVER['REQUEST_METHOD'];
    }
    function migrate_all(){
        return $this->migration()->migrate_all();
    }
    function migration(){
        return new Migration($this->db_cfg);
    }
    function post($url,$params,$agent,$cookie){
        $obj=new Download();
        return $obj->post($url,$params,$agent,$cookie);
    }
    function query($sql){
        return $this->db()->query($sql);
    }
    function read($table,$where){
        return $this->db()->read($table,$where);
    }
    function redirect($url){
        header("Location: ".$url);
    }
    function select($table,$where=null){
        return $this->db()->select($table,$where);
    }
    function sheet_to_array($sheet_name){
        $obj=new Sheet();
        return $obj->to_array($sheet_name);
    }
    function send($to,$subject,$html,$plain=false){
        return $this->mail()->send($to,$subject,$html,$plain);
    }
    function signin(){
        return $this->auth()->signin();
    }
    function signup($user=false){
        return $this->auth()->signup($user);
    }
    function trucate_all(){
        return $this->migration()->truncate_all();
    }
    function update($table, $data, $where){
        return $this->db()->update($table, $data, $where);
    }
    function upload($name,$exts){
        $Upload=new Upload();
        return $Upload->upload($name,$exts);
    }
    function view($name,$data=null,$print=true){
        $data['b']=$this;
        return $this->view->view($name,$data,$print);
    }
}
