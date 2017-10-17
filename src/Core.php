<?php
/**
* Basic
* Micro framework em PHP
*/
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

/**
* Classe core
*/
class Core
{
    public $dbCfg;
    public $mailCfg;
    public $view;
    /**
    * Chamada do sistema
    * @param array $cfg
    */
    public function __construct($cfg=null)
    {
        $this->dbCfg=@$cfg['mysql'];
        $this->mailCfg=@$cfg['smtp'];
        $this->view=new View();
    }
    /**
    * Retorna uma instância de uma classe App ou uma mensagem de erro
    * @param  string $className
    * @return mixed
    */
    public function app($className)
    {
        $filename=ROOT.'app/'.$className.'.php';
        if (file_exists($filename)) {
            require $filename;
            $class='App\\'.$className;
            return new $class($this);
        } else {
            die('app <b>'.$filename.'</b> not found');
        }
    }
    /**
    * Converte um array para uma planilha .csv, .ods ou . xlsx
    * @param  array  $array
    * @param  string $sheetName
    * @return bool
    */
    public function arrayToSheet($sheetData, $sheetName)
    {
        $obj=new Sheet();
        return $obj->toSheet($sheetData, $sheetName);
    }
    /**
    * Classe Auth
    * @return mixed
    */
    private function auth()
    {
        return new Auth($this->dbCfg);
    }
    /**
    * Conta quantas linhas atendem ao WHERE
    * @param  string  $tableName
    * @param  array   $where
    * @return integer
    */
    public function count($tableName, $where)
    {
        return $this->db()->count($tableName, $where);
    }
    /**
    * Adiciona uma linha na tabela
    * @param  string $tableName
    * @param  array  $data
    * @return mixed
    */
    public function create($tableName, $data)
    {
        return $this->db()->create($tableName, $data);
    }
    /**
    * Classe DB
    * @return object
    */
    private function db()
    {
        return new DB($this->dbCfg);
    }
    /**
    * Apagar linhas na tabela
    * @param  string
    * @param  array
    * @return bool
    */
    public function delete($tableName, $where)
    {
        return $this->db()->delete($tableName, $where);
    }
    /**
    * Apaga todas as tabelas do banco de dados
    * @return bool
    */
    public function dropAll()
    {
        return $this->migration()->dropAll();
    }
    /**
    * Retorna a primeira palavra de uma frase
    * @param  string $phrase
    * @return string
    */
    public function firstWord($phrase)
    {
        return $this->view->firstWord($phrase);
    }
    /**
    * Baixa um arquivo da internet através do método GET
    * @param  string $url
    * @param  string $agent
    * @param  array  $cookie
    * @return mixed
    */
    public function get($url, $agent, $cookie)
    {
        $obj=new Download();
        return $obj->get($url, $agent, $cookie);
    }
    /**
    * Sistema básico de internacionalização através do arquivo /view/i18n.php
    * @param  string  $key
    * @param  boolean $print
    * @return string
    */
    public function i18n($key, $print=true)
    {
        return $this->view->i18n($key, $print);
    }
    /**
    * Corrige a orientação da imagem automáticamente
    * @param  string  $src
    * @param  mixed $dst
    * @return bool
    */
    public function imageAutoOrient($src, $dstFile=false)
    {
        return $this->image()->autoOrient($src, $dstFile);
    }
    /**
    * Recorta uma imagem nas coordenadas especificadas
    * @param  string $src
    * @param  string  $dstFile
    * @param  integer $x1
    * @param  integer $y1
    * @param  integer $x2
    * @param  integer $y2
    * @return bool
    */
    public function imageCrop($src, $dstFile, $x1, $y1, $x2, $y2)
    {
        return $this->image()->crop($src, $dstFile, $x1, $y1, $x2, $y2);
    }
    /**
    * Classe Image
    * @return object
    */
    private function image()
    {
        return new Image();
    }
    /**
    * Retorna informações sobre uma imagem
    * @param  string $src
    * @return mixed
    */
    public function imageInfo($src)
    {
        return $this->image()->info($src);
    }
    /**
    * Redimensiona uma imagem
    * @param  string $src
    * @param  string $dstFile
    * @param  integer $maxWidth
    * @param  integer $maxHeight
    * @return bool
    */
    public function imageResize($src, $dstFile, $maxWidth, $maxHeight)
    {
        return $this->image()->resize($src, $dstFile, $maxWidth, $maxHeight);
    }
    /**
    * Cria uma miniatura da imagem
    * @param  string  $srr
    * @param  string  $dst
    * @param  integer $width
    * @param  integer $height
    * @return bool
    */
    public function imageThumb($srr='', $dst='', $width=1, $height=1)
    {
        return $this->image()->thumb($src, $dst, $width, $height);
    }
    /**
    * Retorna true se a conexão for via Ajax e false se não for
    * @return boolean
    */
    public function isAjax()
    {
        return $this->view->isAjax();
    }
    /**
    * Verifica se o usuário está autenticado e retorna os dados dele caso esteja
    * @return boolean
    */
    public function isAuth()
    {
        return $this->auth()->isAuth();
    }
    /**
    * Converte os dados para JSON com header
    * @param  mixed  $data
    * @return string
    */
    public function json($data)
    {
        return $this->view->json($data);
    }
    /**
    * Faz o logout do usuaŕio
    * @return [type]
    */
    public function logout()
    {
        return $this->auth()->logout();
    }
    /**
    * Classe Mail
    * @return object
    */
    private function mail()
    {
        return new Mail($this->mailCfg);
    }
    /**
    * Retorna o método da requisição
    * @return string
    */
    public function method()
    {
        return @$_SERVER['REQUEST_METHOD'];
    }
    /**
    * Migra todas as tabelas plain text de /table
    * @return string
    */
    public function migrateAll()
    {
        return $this->migration()->migrateAll();
    }
    /**
    * Classe Migration
    * @return string
    */
    private function migration()
    {
        return new Migration($this->dbCfg);
    }
    /**
    * Baixa um arquivo de internet através do método POST
    * @param  string $url
    * @param  array  $params
    * @param  string $agent
    * @param  array  $cookie
    * @return mixed
    */
    public function post($url='', $params=[], $agent='', $cookie=[])
    {
        $obj=new Download();
        return $obj->post($url, $params, $agent, $cookie);
    }
    /**
    * Requisição SQL
    * @param  string $sql
    * @return mixed
    */
    public function query(string $sql)
    {
        return $this->db()->query($sql);
    }
    /**
    * Lê uma linha de uma tabela
    * @param  string $tableName
    * @param  array  $where
    * @return [type]
    */
    public function read(string $tableName, array $where)
    {
        return $this->db()->read($tableName, $where);
    }
    /**
    * Redireciona para outra URL
    * @param  string $url
    * @return mixed
    */
    public function redirect(string $url)
    {
        header("Location: ".$url);
    }
    /**
    * Retorna os segmentos da URL
    * @param  integer $key
    * @return mixed
    */
    public function segment($key = null)
    {
        return $this->view->segment($key);
    }
    /**
    * Faz uma requisição SELECT na tabela especificada
    * @param  string $tableName
    * @param  mixed $where
    * @return mixed
    */
    public function select(string $tableName, array $where=null)
    {
        return $this->db()->select($tableName, $where);
    }
    /**
    * Envia uma mensagem de email
    * @param  string  $toAddress
    * @param  string  $subject
    * @param  string  $html
    * @param  mixed $plain
    * @return [type]
    */
    public function send(string $toAddress, string $subject, string $html, $plain=false)
    {
        return $this->mail()->send($toAddress, $subject, $html, $plain);
    }
    /**
    * Converte uma tabela .ods, .csv ou .xlsx para um array
    * @param  string $sheetName
    * @return mixed
    */
    public function sheetToArray(string $sheetName)
    {
        $obj=new Sheet();
        return $obj->toArray($sheetName);
    }
    /**
    * Autentica o usuário baseado nas variáveis $_POST
    * @return mixed
    */
    public function signin()
    {
        return $this->auth()->signin();
    }
    /**
    * Cadastra de usuário baseado nas variáveis $_POST e no parâmetro $user
    * @param  array $user
    * @return mixed
    */
    public function signup($user=false)
    {
        return $this->auth()->signup($user);
    }
    /**
    * Adiciona ou remove underlines de uma string
    * @param  string  $text
    * @param  boolean $set
    * @return string
    */
    public function slug(string $text, $set=true)
    {
        if ($set) {
            return str_replace(' ', '_', $text);
        } else {
            return str_replace('_', ' ', $text);
        }
    }
    /**
    * Apaga todos os dados de todas as tabelas
    * @return mixed
    */
    public function trucateAll()
    {
        return $this->migration()->truncateAll();
    }
    /**
    * Atualiza dados na tabela
    * @param  string $tableName
    * @param  array  $data
    * @param  array  $where
    * @return bool
    */
    public function update(string $tableName, array $data, array $where)
    {
        return $this->db()->update($tableName, $data, $where);
    }
    /**
    * Processa o upload de um arquivo
    * @param  string $name
    * @param  array  $exts
    * @return array
    */
    public function upload(string $name, array $exts)
    {
        $Upload=new Upload();
        return $Upload->upload($name, $exts);
    }
    /**
    * Retorna uma /view
    * @param  string  $name
    * @param  mixed  $data
    * @param  boolean $print
    * @return string
    */
    public function view(string $name, $data=null, $print=true)
    {
        $data['b']=$this;
        return $this->view->view($name, $data, $print);
    }
}
