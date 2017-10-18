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
* Classe Core
*/
class Core
{
    /**
    * Dados do servidor SQL
    * @var array $dbCfg
    */
    private $dbCfg;
    /**
    * Dados do servidor SMTP
    * @var array $mailCfg
    */
    private $mailCfg;
    /**
    * Instância da classe View
    * @var object $view
    */
    private $view;
    /**
    * Chamada do sistema
    * @param array $cfg         Dados do servidor SMTP e SQL
    */
    public function __construct($cfg=null)
    {
        $this->dbCfg=@$cfg['mysql'];
        $this->mailCfg=@$cfg['smtp'];
        $this->view=new View();
    }
    /**
    * Retorna uma instância de uma classe App ou uma mensagem de erro
    * @param  string $className Nome da classe App
    * @return mixed             Instância da class App ou mensagem de erro
    */
    public function app($className=''):mixed
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
    * @param  array  $sheetData Dados da planilha
    * @param  string $sheetName Nome do arquivo com extensão
    * @return bool              Retorna true ou false
    */
    public function arrayToSheet($sheetData=[], $sheetName=''):bool
    {
        $obj=new Sheet();
        return $obj->toSheet($sheetData, $sheetName);
    }
    /**
    * Classe Auth
    * @return object Retorna instância da classe Auth
    */
    private function auth():object
    {
        return new Auth($this->dbCfg);
    }
    /**
    * Conta quantas linhas atendem ao WHERE
    * @param  string $tableName Nome da tabela
    * @param  array  $where     Dados WHERE
    * @return integer           Retorna um valor inteiro
    */
    public function count($tableName='', $where=[]):integer
    {
        return $this->db()->count($tableName, $where);
    }
    /**
    * Adiciona uma linha na tabela
    * @param  string $tableName Nome da tabela
    * @param  array  $data      Dados a serem adicionado
    * @return mixed             Inteiro com o ID da linha ou false
    */
    public function create($tableName='', $data=[]):mixed
    {
        return $this->db()->create($tableName, $data);
    }
    /**
    * Classe DB
    * @return object Retorna uma instância da classe DB
    */
    private function db():object
    {
        return new DB($this->dbCfg);
    }
    /**
    * Apagar linhas na tabela
    * @param  string $tableName Nome da tabela
    * @param  array  $where     Dados WHERE
    * @return bool              Retorna true ou false
    */
    public function delete($tableName='', $where=[]):bool
    {
        return $this->db()->delete($tableName, $where);
    }
    /**
    * Apaga todas as tabelas do banco de dados
    * @return mixed Resposta para CLI
    */
    public function dropAll():mixed
    {
        return $this->migration()->dropAll();
    }
    /**
    * Retorna a primeira palavra de uma frase
    * @param  string $phrase Frase com duas ou mais palavras
    * @return string         Primeira palavra da frase
    */
    public function firstWord($phrase=''):string
    {
        return $this->view->firstWord($phrase);
    }
    /**
    * Baixa um arquivo da internet através do método GET
    * @param  [type] $url    URL do pedido
    * @param  [type] $agent  User Agent do pedido
    * @param  [type] $cookie Cookies do pedido
    * @return mixed          Resposta RAW
    */
    public function get($url, $agent, $cookie):mixed
    {
        $obj=new Download();
        return $obj->get($url, $agent, $cookie);
    }
    /**
    * Sistema básico de internacionalização através do arquivo /view/i18n.php
    * @param  string  $key   Nome da chave de tradução
    * @param  boolean $print Printar ou não a resposta
    * @return mixed          Retorna uma string ou uma resposta printada
    */
    public function i18n($key='', $print=true):mixed
    {
        return $this->view->i18n($key, $print);
    }
    /**
    * Corrige a orientação da imagem automáticamente
    * @param  string  $src     Nome do arquivo de origem
    * @param  boolean $dstFile Nome do arquivo de destinho
    * @return bool             Retorna true ou false
    */
    public function imageAutoOrient($src='', $dstFile=false):bool
    {
        return $this->image()->autoOrient($src, $dstFile);
    }
    /**
    * Recorta uma imagem nas coordenadas especificadas
    * @param  [type] $src     Nome do arquivo de origem
    * @param  [type] $dstFile Nome do arquivo de destinho
    * @param  [type] $x1      Coordenada X1
    * @param  [type] $y1      Coordenada Y1
    * @param  [type] $x2      Coordenada X2
    * @param  [type] $y2      Coordenada Y2
    * @return bool            Retorna true ou false
    */
    public function imageCrop($src, $dstFile, $x1, $y1, $x2, $y2):bool
    {
        return $this->image()->crop($src, $dstFile, $x1, $y1, $x2, $y2);
    }
    /**
    * Classe Image
    * @return object Retorna uma instância da classe Image
    */
    private function image():object
    {
        return new Image();
    }
    /**
    * Retorna informações sobre uma imagem
    * @param  string $src Nome do arquivo de origem
    * @return mixed       Retorna os dados ou false
    */
    public function imageInfo($src=''):mixed
    {
        return $this->image()->info($src);
    }
    /**
    * Redimensiona uma imagem
    * @param  [type] $src       Arquivo de origem
    * @param  [type] $dstFile   Arquivo de destino
    * @param  [type] $maxWidth  Largura máxima
    * @param  [type] $maxHeight Altura máxima
    * @return bool              Retorna true ou false
    */
    public function imageResize($src='', $dstFile='', $maxWidth=1, $maxHeight=1):bool
    {
        return $this->image()->resize($src, $dstFile, $maxWidth, $maxHeight);
    }
    /**
    * Cria uma miniatura da imagem
    * @param  string  $srr    Arquivo de origem
    * @param  string  $dst    Arquivo de destino
    * @param  integer $width  Largura da miniatura
    * @param  integer $height Altura da miniatura
    * @return bool            Retorna true ou false
    */
    public function imageThumb($srr='', $dst='', $width=1, $height=1):bool
    {
        return $this->image()->thumb($src, $dst, $width, $height);
    }
    /**
    * Retorna true se a conexão for via Ajax e false se não for
    * @return bool Retorna true ou false
    */
    public function isAjax():bool
    {
        return $this->view->isAjax();
    }
    /**
    * Verifica se o usuário está autenticado
    * @return mixed Retorna os dados dele caso esteja ou retorna false
    */
    public function isAuth():mixed
    {
        return $this->auth()->isAuth();
    }
    /**
    * Converte os dados para JSON com header
    * @param  mixed $data Dados a serem convertidos
    * @return mixed       String com header HTTP setado para JSON
    */
    public function json($data):mixed
    {
        return $this->view->json($data);
    }
    /**
    * Faz o logout do usuaŕio
    * @return bool Retorna true ou false
    */
    public function logout():bool
    {
        return $this->auth()->logout();
    }
    /**
    * Classe Mail
    * @return object Retorna uma instância da classe Mail
    */
    private function mail():object
    {
        return new Mail($this->mailCfg);
    }
    /**
    * Retorna o método da requisição
    * @return string Retorna o méxodo da requisição web
    */
    public function method():string
    {
        return @$_SERVER['REQUEST_METHOD'];
    }
    /**
    * Migra todas as tabelas plain text de /table
    * @return mixed Resposta para CLI
    */
    public function migrateAll():mixed
    {
        return $this->migration()->migrateAll();
    }
    /**
    * Classe Migration
    * @return mixed resposta para CLI
    */
    private function migration():mixed
    {
        return new Migration($this->dbCfg);
    }
    /**
    * Baixa um arquivo de internet através do método POST
    * @param  string $url    URL do pedido
    * @param  array  $params Parâmetros do pedido
    * @param  string $agent  User Agent do pedido
    * @param  array  $cookie Cookies do pedido
    * @return mixed          Resposta RAW
    */
    public function post($url='', $params=[], $agent='', $cookie=[]):mixed
    {
        $obj=new Download();
        return $obj->post($url, $params, $agent, $cookie);
    }
    /**
    * Requisição SQL
    * @param  string $sql Requisição em SQL
    * @return mixed       Resposta em PHP
    */
    public function query(string $sql):mixed
    {
        return $this->db()->query($sql);
    }
    /**
    * Lê uma linha de uma tabela
    * @param  string $tableName Nome da tabela
    * @param  array  $where     Dados do WHERE
    * @return mixed             Dados da linha ou false
    */
    public function read(string $tableName, array $where):mixed
    {
        return $this->db()->read($tableName, $where);
    }
    /**
    * Redireciona para outra URL
    * @param  string $url URL de destino
    * @return mixed       Header HTTP de redirecionamento
    */
    public function redirect(string $url):mixed
    {
        header("Location: ".$url);
    }
    /**
    * Retorna os segmentos da URL
    * @param  mixed $key  Parte da URL
    * @return mixed       Retorna uma ou mais partes da URL
    */
    public function segment($key):mixed
    {
        return $this->view->segment($key);
    }
    /**
    *  Faz uma requisição SELECT na tabela especificada
    * @param  string $tableName Nome da tabela
    * @param  mixed  $where     Dados WHERE
    * @return mixed             Retorna os dados ou false
    */
    public function select(string $tableName, $where):mixed
    {
        return $this->db()->select($tableName, $where);
    }
    /**
    * Envia uma mensagem de email
    * @param  string  $toAddress Endereço do destinatário
    * @param  string  $subject   Assunto
    * @param  string  $html      HTML
    * @param  mixed   $plain     PlainText
    * @return bool               Retorna true ou false
    */
    public function send($toAddress='', $subject='', $html='', $plain=false):bool
    {
        return $this->mail()->send($toAddress, $subject, $html, $plain);
    }
    /**
    * Converte uma planilha .ods, .csv ou .xlsx para um array
    * @param  string $sheetName Nome da planilha
    * @return array             Dados da planilha
    */
    public function sheetToArray(string $sheetName):array
    {
        $obj=new Sheet();
        return $obj->toArray($sheetName);
    }
    /**
    * Autentica o usuário baseado nas variáveis $_POST
    * @return mixed Dados do usuário ou mensagens de erro
    */
    public function signin():mixed
    {
        return $this->auth()->signin();
    }
    /**
    * Cadastra de usuário baseado nas variáveis $_POST e no parâmetro $user
    * @param  boolean $user Dados do usuário
    * @return mixed         Faz o signin criando o token de autenticação
    */
    public function signup($user=false):mixed
    {
        return $this->auth()->signup($user);
    }
    /**
    * Adiciona ou remove underlines de uma string
    * @param  string  $text Dados de entrada
    * @param  boolean $set  Adicionar ou remover underlines
    * @return string        Dados de saída
    */
    public function slug(string $text, $set=true):string
    {
        if ($set) {
            return str_replace(' ', '_', $text);
        } else {
            return str_replace('_', ' ', $text);
        }
    }
    /**
    * Apaga todos os dados de todas as tabelas
    * @return mixed Resposta no modo CLI
    */
    public function trucateAll():mixed
    {
        return $this->migration()->truncateAll();
    }
    /**
    * Atualiza dados na tabela
    * @param  string $tableName Nome da tabela
    * @param  array  $data      Dados a serem atualizado
    * @param  array  $where     Dados WHERE
    * @return bool              Retorna true ou false
    */
    public function update(string $tableName, array $data, array $where):bool
    {
        return $this->db()->update($tableName, $data, $where);
    }
    /**
    * Processa o upload de um arquivo
    * @param  string $name Nome do campo $_FILE
    * @param  array  $exts Lista de extensões permitidas
    * @return array        Dados do arquivo ou mensagens de erro
    */
    public function upload(string $name, array $exts):array
    {
        $Upload=new Upload();
        return $Upload->upload($name, $exts);
    }
    /**
    * Retorna uma view
    * @param  string  $name  Nome da view
    * @param  mixed   $data  Variáveis
    * @param  boolean $print Printar
    * @return mixed          View printada ou string contendo a view
    */
    public function view(string $name, $data, $print=true):mixed
    {
        $data['b']=$this;
        return $this->view->view($name, $data, $print);
    }
}
