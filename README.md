# Estrutura MVC em PHP

Este projeto é uma estrutura base em PHP seguindo o padrão **MVC (Model-View-Controller)**. Ele foi desenvolvido para fins de estudo e reutilização, servindo como ponto de partida para futuros projetos que precisem de uma arquitetura organizada e escalável.

## 🚀 Objetivo

Fornecer uma estrutura simples, clara e reutilizável para aplicações em PHP, com rotas dinâmicas e separação de responsabilidades entre Models, Views e Controllers.

## 🧩 Estrutura de Pastas

``` bash
mvc/
├── .gitignore
├── .htaccess
├── composer.json
├── composer.lock
├── config.php
├── environment.php
├── public/
│   ├── index.php
├── src/
│   ├── controllers/
│   │   ├── HomeController.php
│   │   ├── errors/
│   │   │   ├── ErrorController.php
│   ├── core/
│   │   ├── Controller.php
│   │   ├── Router.php
│   ├── models/
│   ├── views/
│   │   ├── error/
│   │   │   ├── 404.php
│   │   │   ├── 500.php
│   │   ├── home/
│   │   │   ├── index.php
├── vendor/
│   ├── autoload.php
│   ├── composer/
│   │   ├── autoload_classmap.php
│   │   ├── autoload_psr4.php
│   │   ├── autoload_real.php
│   │   ├── InstalledVersions.php
│   │   ├── installed.php
│   │   ├── installed.json
│   │   └── LICENSE
```

## ⚙️ Como Funciona

### 1. `public/index.php`

É o ponto de entrada da aplicação. Todas as requisições passam por este arquivo, que chama o **Router** responsável por interpretar a URL e direcionar para o controller correto.

### 2. `src/core/Router.php`

Controla as rotas da aplicação. Ele lê o parâmetro `url` enviado via `.htaccess` e define qual Controller e qual método (Action) devem ser executados.  
Exemplo: `/home/index` → Controller: `HomeController` → Método: `index`  
Também suporta parâmetros adicionais: `/home/detalhes/5` → Chama o método `detalhes('5')` dentro do `HomeController`.

### 3. `src/core/Controller.php`

Classe base que pode ser herdada por todos os controllers. Pode conter métodos utilitários (como carregamento de views) e lógica comum entre controladores.

### 4. `src/controllers/`

Contém os **Controllers**, que são responsáveis por tratar as requisições e conectar os **Models** com as **Views**.  
Exemplo: `HomeController.php` controla as páginas principais do sistema.  
`errors/ErrorController.php` controla as páginas de erro (como 404 e 500).

### 5. `src/models/`

Local destinado às regras de negócio e acesso a dados (caso utilize banco de dados ou outro tipo de persistência).  
Por enquanto está vazio, mas pode ser usado em versões futuras.

### 6. `src/views/`

Contém os arquivos de interface (HTML, PHP) exibidos ao usuário.  
Cada controller tem sua própria pasta dentro de `views/`.  
Exemplo:  

- `views/home/index.php` → view da página inicial  

- `views/error/404.php` → view para página não encontrada

### 7. `.htaccess`

Responsável por redirecionar todas as requisições para o `public/index.php`, permitindo **URLs amigáveis** sem necessidade de incluir `.php` nos links.  
Conteúdo:
RewriteEngine ON
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ /mvc/public/index.php?url=$1 [QSA,L]

### 8. `config.php` e `environment.php`

Arquivos de configuração geral do projeto.  
Podem armazenar constantes, variáveis de ambiente, configurações de banco de dados ou parâmetros de inicialização.

### 9. `composer.json`

Utilizado pelo **Composer**, para fazer o download de **autoload** do projeto.  
Certifique-se de rodar o comando abaixo ao clonar o projeto:

``` bash
composer install
```

## 🖥️ Como Utilizar

1. Clone ou copie o projeto para o seu servidor local (ex: `C:\wamp\www\mvc` ou `htdocs/mvc`)  

2. Certifique-se de ter o **Composer** instalado  

3. Rode o comando: `composer install`

4. Inicie o servidor local (ex: **WAMP**, **XAMPP**, **Laragon**, etc.)  

5. Acesse no navegador:  

`http://localhost/mvc/`

## 🧠 Exemplo de Uso

Acesse:
`http://localhost/mvc/`  
Isso carregará o controller `HomeController` e o método `index()` (controller e método padrões), renderizando a view `views/home/index.php`.

Para criar novas páginas:

1. Crie um novo controller dentro de `src/controllers/`  
2. Crie um método público dentro dele (Lembrando que index é o método padrão que é chamado mesmo sem ser digitado na barra de endereço).  
3. Crie a view correspondente dentro de `src/views/nomedocontroller/`
4. Dentro da função chame `$this->view('pastadaview/nomedaview')`
5. Em paginas que precisam que parâmetros sejam chamados pelo link (Ex: Agenda/contato/1) se usa array para que sejam mandados para a view.

``` code
Exemplo:
Class Agenda
{
  //Mostra um contato individualmente pelo id
  public function contato($id){
    $data = ['id' => $id];
    $this->view('agenda/contato', $data);
  }
}
```

Dessa forma, na view você pode chamar diretamente pela chave do array `Id: <?= $id ?>`

## 📚 Objetivo do Projeto

Essa estrutura foi criada com foco em **estudo**, **entendimento da arquitetura MVC** e **reutilização futura**.  
Ela serve como base para desenvolver sistemas maiores e mais complexos, com organização e separação de responsabilidades desde o início.

## 📄 Licença

Este projeto é de **uso livre** para fins de aprendizado, testes e extensão.  
Você pode modificá-lo e utilizá-lo como base para outros projetos.
