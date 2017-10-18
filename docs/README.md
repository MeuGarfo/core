Basic\Core
===============

Classe Core




* Class name: Core
* Namespace: Basic





Properties
----------


### $dbCfg

    public mixed $dbCfg





* Visibility: **public**


### $mailCfg

    public mixed $mailCfg





* Visibility: **public**


### $view

    public mixed $view





* Visibility: **public**


Methods
-------


### __construct

    mixed Basic\Core::__construct(array $cfg)

Chamada do sistema



* Visibility: **public**


#### Arguments
* $cfg **array**



### app

    mixed Basic\Core::app(string $className)

Retorna uma instância de uma classe App ou uma mensagem de erro



* Visibility: **public**


#### Arguments
* $className **string**



### arrayToSheet

    boolean Basic\Core::arrayToSheet($sheetData, string $sheetName)

Converte um array para uma planilha .csv, .ods ou . xlsx



* Visibility: **public**


#### Arguments
* $sheetData **mixed**
* $sheetName **string**



### auth

    mixed Basic\Core::auth()

Classe Auth



* Visibility: **private**




### count

    integer Basic\Core::count(string $tableName, array $where)

Conta quantas linhas atendem ao WHERE



* Visibility: **public**


#### Arguments
* $tableName **string**
* $where **array**



### create

    mixed Basic\Core::create(string $tableName, array $data)

Adiciona uma linha na tabela



* Visibility: **public**


#### Arguments
* $tableName **string**
* $data **array**



### db

    object Basic\Core::db()

Classe DB



* Visibility: **private**




### delete

    boolean Basic\Core::delete(string $tableName, array $where)

Apagar linhas na tabela



* Visibility: **public**


#### Arguments
* $tableName **string**
* $where **array**



### dropAll

    boolean Basic\Core::dropAll()

Apaga todas as tabelas do banco de dados



* Visibility: **public**




### firstWord

    string Basic\Core::firstWord(string $phrase)

Retorna a primeira palavra de uma frase



* Visibility: **public**


#### Arguments
* $phrase **string**



### get

    mixed Basic\Core::get(string $url, string $agent, array $cookie)

Baixa um arquivo da internet através do método GET



* Visibility: **public**


#### Arguments
* $url **string**
* $agent **string**
* $cookie **array**



### i18n

    string Basic\Core::i18n(string $key, boolean $print)

Sistema básico de internacionalização através do arquivo /view/i18n.php



* Visibility: **public**


#### Arguments
* $key **string**
* $print **boolean**



### imageAutoOrient

    boolean Basic\Core::imageAutoOrient(string $src, $dstFile)

Corrige a orientação da imagem automáticamente



* Visibility: **public**


#### Arguments
* $src **string**
* $dstFile **mixed**



### imageCrop

    boolean Basic\Core::imageCrop(string $src, string $dstFile, integer $x1, integer $y1, integer $x2, integer $y2)

Recorta uma imagem nas coordenadas especificadas



* Visibility: **public**


#### Arguments
* $src **string**
* $dstFile **string**
* $x1 **integer**
* $y1 **integer**
* $x2 **integer**
* $y2 **integer**



### image

    object Basic\Core::image()

Classe Image



* Visibility: **private**




### imageInfo

    mixed Basic\Core::imageInfo(string $src)

Retorna informações sobre uma imagem



* Visibility: **public**


#### Arguments
* $src **string**



### imageResize

    boolean Basic\Core::imageResize(string $src, string $dstFile, integer $maxWidth, integer $maxHeight)

Redimensiona uma imagem



* Visibility: **public**


#### Arguments
* $src **string**
* $dstFile **string**
* $maxWidth **integer**
* $maxHeight **integer**



### imageThumb

    boolean Basic\Core::imageThumb(string $srr, string $dst, integer $width, integer $height)

Cria uma miniatura da imagem



* Visibility: **public**


#### Arguments
* $srr **string**
* $dst **string**
* $width **integer**
* $height **integer**



### isAjax

    boolean Basic\Core::isAjax()

Retorna true se a conexão for via Ajax e false se não for



* Visibility: **public**




### isAuth

    boolean Basic\Core::isAuth()

Verifica se o usuário está autenticado e retorna os dados dele caso esteja



* Visibility: **public**




### json

    string Basic\Core::json(mixed $data)

Converte os dados para JSON com header



* Visibility: **public**


#### Arguments
* $data **mixed**



### logout

    \Basic\[type] Basic\Core::logout()

Faz o logout do usuaŕio



* Visibility: **public**




### mail

    object Basic\Core::mail()

Classe Mail



* Visibility: **private**




### method

    string Basic\Core::method()

Retorna o método da requisição



* Visibility: **public**




### migrateAll

    string Basic\Core::migrateAll()

Migra todas as tabelas plain text de /table



* Visibility: **public**




### migration

    string Basic\Core::migration()

Classe Migration



* Visibility: **private**




### post

    mixed Basic\Core::post(string $url, array $params, string $agent, array $cookie)

Baixa um arquivo de internet através do método POST



* Visibility: **public**


#### Arguments
* $url **string**
* $params **array**
* $agent **string**
* $cookie **array**



### query

    mixed Basic\Core::query(string $sql)

Requisição SQL



* Visibility: **public**


#### Arguments
* $sql **string**



### read

    mixed Basic\Core::read(string $tableName, array $where)

Lê uma linha de uma tabela



* Visibility: **public**


#### Arguments
* $tableName **string**
* $where **array**



### redirect

    mixed Basic\Core::redirect(string $url)

Redireciona para outra URL



* Visibility: **public**


#### Arguments
* $url **string**



### segment

    mixed Basic\Core::segment(integer $key)

Retorna os segmentos da URL



* Visibility: **public**


#### Arguments
* $key **integer**



### select

    mixed Basic\Core::select(string $tableName, mixed $where)

Faz uma requisição SELECT na tabela especificada



* Visibility: **public**


#### Arguments
* $tableName **string**
* $where **mixed**



### send

    \Basic\[type] Basic\Core::send(string $toAddress, string $subject, string $html, mixed $plain)

Envia uma mensagem de email



* Visibility: **public**


#### Arguments
* $toAddress **string**
* $subject **string**
* $html **string**
* $plain **mixed**



### sheetToArray

    mixed Basic\Core::sheetToArray(string $sheetName)

Converte uma tabela .ods, .csv ou .xlsx para um array



* Visibility: **public**


#### Arguments
* $sheetName **string**



### signin

    mixed Basic\Core::signin()

Autentica o usuário baseado nas variáveis $_POST



* Visibility: **public**




### signup

    mixed Basic\Core::signup(array $user)

Cadastra de usuário baseado nas variáveis $_POST e no parâmetro $user



* Visibility: **public**


#### Arguments
* $user **array**



### slug

    string Basic\Core::slug(string $text, boolean $set)

Adiciona ou remove underlines de uma string



* Visibility: **public**


#### Arguments
* $text **string**
* $set **boolean**



### trucateAll

    mixed Basic\Core::trucateAll()

Apaga todos os dados de todas as tabelas



* Visibility: **public**




### update

    boolean Basic\Core::update(string $tableName, array $data, array $where)

Atualiza dados na tabela



* Visibility: **public**


#### Arguments
* $tableName **string**
* $data **array**
* $where **array**



### upload

    array Basic\Core::upload(string $name, array $exts)

Processa o upload de um arquivo



* Visibility: **public**


#### Arguments
* $name **string**
* $exts **array**



### view

    string Basic\Core::view(string $name, mixed $data, boolean $print)

Retorna uma /view



* Visibility: **public**


#### Arguments
* $name **string**
* $data **mixed**
* $print **boolean**


