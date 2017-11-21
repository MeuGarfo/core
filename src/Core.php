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

class Core
{
    private $dbCfg;
    private $mailCfg;
    private $view;

    public function __construct($cfg=false)
    {
        if ($cfg) {
            $this->dbCfg=@$cfg['mysql'];
            $this->mailCfg=@$cfg['smtp'];
            $this->view=new View();
        }
    }
    public function controller($controllerName='')
    {
        $realControllerName=$this->controllerExists($controllerName);
        if ($realControllerName) {
            require_once $realControllerName;
            $controllerName=pathinfo($realControllerName)['filename'];
            $controllerInstance='App\\Controller\\'.$controllerName;
            return new $controllerInstance($this);
        } else {
            die('controller <b>'.$filename.'</b> not found');
        }
    }
    public function controllerExists($controllerName)
    {
        // pega a lista de controllers
        $controllerDir=ROOT.'app/controller/';
        $controllerList=$this->myScanDir($controllerDir);
        // capitaliza o controller
        $controllerName=ucfirst($controllerName);
        // verifica se tem "s" no final
        if (mb_substr($controllerName, -1)=='s') {
            // remove o s caso ele exista
            $controllerName=mb_substr($controllerName, 0, -1);
        }
        // procura o controllerName
        $key=array_search($controllerName.'.php', $controllerList);
        // verifica se o controller existe
        if ($key) {
            // caso o controller exista retorna o nome real do controller
            return $controllerDir.$controllerList[$key];
        } else {
            // caso o controller não exista retorna false
            return false;
        }
    }
    public function arrayToSheet($sheetData=[], $sheetName='')
    {
        $obj=new Sheet();
        return $obj->toSheet($sheetData, $sheetName);
    }
    private function auth()
    {
        return new Auth($this->dbCfg);
    }
    public function count($tableName='', $where=[])
    {
        return $this->db()->count($tableName, $where);
    }
    public function create($tableName='', $data=[])
    {
        return $this->db()->create($tableName, $data);
    }
    private function db()
    {
        return new DB($this->dbCfg);
    }
    public function delete($tableName='', $where=[])
    {
        return $this->db()->delete($tableName, $where);
    }
    public function dropAll()
    {
        return $this->migration()->dropAll();
    }
    public function firstWord($phrase='')
    {
        return $this->view->firstWord($phrase);
    }
    public function get($url, $agent, $cookie)
    {
        $obj=new Download();
        return $obj->get($url, $agent, $cookie);
    }
    public function i18n($key='', $print=true)
    {
        return $this->view->i18n($key, $print);
    }
    public function imageAutoOrient($src='', $dstFile=false)
    {
        return $this->image()->autoOrient($src, $dstFile);
    }
    public function imageCrop($src, $dstFile, $x1, $y1, $x2, $y2)
    {
        return $this->image()->crop($src, $dstFile, $x1, $y1, $x2, $y2);
    }
    private function image()
    {
        return new Image();
    }
    public function imageInfo($src='')
    {
        return $this->image()->info($src);
    }
    public function imageResize(
        string $src,
        string $dstFile,
        integer $maxWidth,
        integer $maxHeight
    ) {
        return $this->image()->resize($src, $dstFile, $maxWidth, $maxHeight);
    }
    public function imageThumb($srr='', $dst='', $width=1, $height=1)
    {
        return $this->image()->thumb($src, $dst, $width, $height);
    }
    public function isAjax()
    {
        return $this->view->isAjax();
    }
    public function isAuth()
    {
        return $this->auth()->isAuth();
    }
    public function isDev():bool
    {
        $end=@end(explode('.', $_SERVER['SERVER_NAME']));
        if ($end==='dev') {
            return true;
        } else {
            return false;
        }
    }
    public function json($data)
    {
        return $this->view->json($data);
    }
    public function logout()
    {
        return $this->auth()->logout();
    }
    private function mail()
    {
        return new Mail($this->mailCfg);
    }
    public function method()
    {
        return @$_SERVER['REQUEST_METHOD'];
    }
    public function migrateAll()
    {
        return $this->migration()->migrateAll();
    }
    private function migration()
    {
        return new Migration($this->dbCfg);
    }
    public function post($url='', $params=[], $agent='', $cookie=[])
    {
        $obj=new Download();
        return $obj->post($url, $params, $agent, $cookie);
    }
    public function myScanDir(string $dir)
    {
        $ignored = array('.', '..', '.svn', '.htaccess');
        $files = array();
        foreach (scandir($dir) as $file) {
            if (in_array($file, $ignored)) {
                continue;
            }
            $files[$file] = filemtime($dir.$file);
        }
        arsort($files);
        $files = array_keys($files);
        return ($files) ? $files : false;
    }
    public function query(string $sql)
    {
        return $this->db()->query($sql);
    }
    public function read(string $tableName, array $where)
    {
        return $this->db()->read($tableName, $where);
    }
    public function redirect(string $url)
    {
        header("Location: ".$url);
    }
    public function start()
    {
        require_once(ROOT.'config.php');
        $this->dbCfg=@$mysql;
        $this->mailCfg=@$smtp;
        $this->view=new View();
        $segment=$this->segment();
        if (isset($_POST['_method'])) {
            $method=$_POST['_method'];
        } else {
            $method=$this->method();
        }
        switch ($method) {
            case 'POST':
            case 'CREATE':
            case 'create':
            $method='create';
            break;
            case 'PUT':
            case 'UPDATE':
            case 'update':
            $method='update';
            break;
            case 'DELETE':
            case 'delete':
            $method='delete';
            break;
            default:
            $method='read';
            break;
        }
        $controllerName=$segment[0];
        $realControllerName=$this->controllerExists($controllerName);
        if ($controllerName=='/') {
            $this->controller('Home')->$method();
        } elseif ($realControllerName) {
            if (isset($segment[1])) {
                $this->controller($controllerName)->$method($segment[1]);
            } else {
                $this->controller($controllerName)->$method();
            }
        } else {
            $this->controller('Home')->notFound();
        }
    }
    public function segment(integer $key=null)
    {
        if (is_null($key)) {
            return $this->view->segment();
        } else {
            return $this->view->segment($key);
        }
    }
    public function select(string $tableName, $where)
    {
        return $this->db()->select($tableName, $where);
    }
    public function send($toAddress='', $subject='', $html='', $plain=false)
    {
        return $this->mail()->send($toAddress, $subject, $html, $plain);
    }
    public function sheetToArray(string $sheetName)
    {
        $obj=new Sheet();
        return $obj->toArray($sheetName);
    }
    public function signin()
    {
        return $this->auth()->signin();
    }
    public function signup($user=false)
    {
        return $this->auth()->signup($user);
    }
    public function slug(string $text, $set=true)
    {
        if ($set) {
            return str_replace(' ', '_', $text);
        } else {
            return str_replace('_', ' ', $text);
        }
    }
    public function trucateAll()
    {
        return $this->migration()->truncateAll();
    }
    public function update(string $tableName, array $data, array $where)
    {
        return $this->db()->update($tableName, $data, $where);
    }
    public function upload(string $name=null, array $exts=null)
    {
        $Upload=new Upload();
        if (is_null($name) && is_null($exts)) {
            return $Upload;
        } else {
            return $Upload->upload($name, $exts);
        }
    }
    public function view(string $name, $data=null, $print=true)
    {
        $data['b']=$this;
        $name=ROOT.'app/view/'.$name;
        return $this->view->view($name, $data, $print);
    }
}
