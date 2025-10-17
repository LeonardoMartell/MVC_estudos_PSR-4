# Estrutura MVC em PHP (Projeto atualizado)

Este repositório contém uma estrutura base em **MVC (Model-View-Controller)** em PHP puro.  
O projeto foi organizado para estudos e reutilização — com roteamento, controllers, views e suporte a autoload via Composer.

---

## Visão geral rápida

- Ponto de entrada público: `public/index.php`  
- Roteamento via `src/core/Router.php` (lê o parâmetro `url` e direciona para o controller/action correspondente)  
- Controllers em `src/controllers/` (inclui `HomeController.php` e controller de erros)  
- Views em `src/views/` (tem views para `home` e páginas de erro 404/500)  
- Core da aplicação em `src/core/` (`Controller.php`, `Router.php`)
- Dependências/autoload gerenciados por Composer (`composer.json`, `vendor/` presente)

---

## Estrutura de arquivos (resumida)

``` bash
mvc/  
│   .gitignore
│   .htaccess
│   composer.json
│   composer.lock
│   README.md
│
├───public
│       index.php
│
├───src
│   ├───config
│   │       config.php
│   │       configModelo.php
│   │
│   ├───controllers
│   │   │   HomeController.php
│   │   │
│   │   └───errors
│   │           ErrorController.php
│   │
│   ├───core
│   │       Controller.php
│   │       Database.php
│   │       functions.php
│   │       Model.php
│   │       Router.php
│   │
│   ├───models
│   └───views
│       ├───error
│       │       404.php
│       │       500.php
│       │
│       └───home
│               index.php
│
└───vendor
```

---

## Como o roteador funciona (conceito aplicado neste projeto)

1. O `.htaccess` (se habilitado no Apache) redireciona requisições para `public/index.php` preenchendo `?url=...`.  
2. O `Router` (em `src/core/Router.php`) lê `$_GET['url']` (ou usa rota padrão `home/index`), explode por `/` e mapeia:  
   - segmento 0 → controller (ex: `home` → `HomeController`)  
   - segmento 1 → action/método (ex: `index`)  
   - segmentos 2+ → parâmetros que são passados para o método via `call_user_func_array`.  
3. O controller instanciado executa a lógica necessária e carrega a view correspondente (incluindo templates se aplicável).  
4. Páginas de erro (404/500) são tratadas por `ErrorController` e exibidas em `src/views/error/`.

---

## Instruções de instalação e execução (local)

1. Coloque o projeto na pasta do seu servidor local (ex.: `C:\wamp64\www\mvc` ou `htdocs/mvc`).  
2. Certifique-se que o Apache tem `mod_rewrite` habilitado (se você usar `.htaccess`).  
3. Composer:
   - Se o `vendor/` não existir no seu clone local, rode:

     ```bash
     composer install
     ```

   - Se o `composer.json` foi alterado ou apenas para garantir autoload:

     ```bash
     composer dump-autoload
     ```

4. Configure o **document root** do servidor para apontar para a pasta `public/` (recomendado) ou use o servidor embutido do PHP para testes:

   ```bash
   php -S localhost:8000 -t public
   ```

5. Abra o navegador e acesse:

   ``` URL
   http://localhost/mvc/
   ```

   (ou `http://localhost:8000` se usar o servidor embutido apontando para `public`)

---

## Rotas de exemplo

- `/home/index` → `HomeController::index()`  
- `/home` → (por padrão) `HomeController::index()`  
- `/home/contato/Leo/84999999` → `HomeController::contato('Leo', '84999999')` (exemplo de método com parâmetros)

---

## Arquivos de configuração

- `src/config/config.php` contêm as variáveis necessárias para conexão ao banco de dados.
  - Verifique e ajuste valores como `host`, `user` e `pass`
  - O projeto virá com o arquivo `configModelo.php`. Que é apenas um modelo de como deve ser o arquivo `config.php` original.
  - Crie um novo arquivo chamado `config.php` na mesma pasta usando o modelo como base, ou renomeie `configModelo.php` e apague o comentário no codigo para usar as variáveis de ambiente.

---

## Classe Database

- A classe `Database` é a classe responsável por conectar e consultar o banco de dados.
- O método `connect` é responsável pela conexão ao banco de dados.
  - Altere os dados de conexão no arquivo `config.php` na pasta `src/config`.
- Os models que fazem esta conexão ao banco de dados herdam a classe abstrata `Model` que fica em `src/core`.
  - A classe abstrata `Model` faz a conexão automatica ao banco de dados através de `db`.
  - Classe que herdará a classe abstrata `Model` faz essa conexão usando `$this->db`.
  - Ex: `$this->db->query()` invoca o método query da classe `Database`.
- O método `query()` é o método mais básico de consulta. Ele apenas invoca método `prepare` da biblioteca `PDO` do PHP.
  - Os parâmetros são enviados diretamente em `execute()` que já é invocado no método.
  - Ex: na classe `User` para criar um novo usuário pode-se usar o método `query()`, e o exemplo mostra como passar os parâmetros.

    - ``` PHP
      public function createUser($nome, $telefone){
         //Os parâmetros da consulta devem ser enviados como um array como no exemplo abaixo
         $params = [':nome' => $nome, ':telefone' => $telefone];

         //O método terá como seu primeiro parâmetro a sua consulta
         //O segundo parâmetro do método devem ser os parâmetros da consulta
         $this->db->query('INSERT INTO usuarios (nome, telefone) VALUES (:nome, :telefone)', $params);
      }
      ```

- O método `fetch()` faz a consulta e retorna o primeiro resultado desta mesma consulta.
  - É recomendado utilizá-lo para retornar um valor em específico no banco de dados.
  - Usa-se o método da mesma forma que no método `query()`.
  - EX: `$resultado = $this->db->fetch($consulta, $parametros)`.

- O método `fetchAll()` faz a consulta ao banco e retorna todos os valores encontrados na consulta.
  - É recomendado utilizá-lo, por exemplo, para listar os itens consultados.
  - Usa-se o método da mesma forma que no método `query()`.
  - EX: `$resultado = $this->db->fetchAll($consulta, $parametros)`.

- O método `execute()` faz a consulta ao banco de dados e retorna o numero de linhas afetadas.
  - Recomenda-se utilizar para saber se alguma linha do banco de dados foi afetada para fazer a consulta.
  - Usa-se o método da mesma forma que no método `query()`.
  - EX: `$resultado = $this->db->execute($consulta, $parametros)`.

---

## Adicionando um novo controller

1. Na pasta `src/controllers/` crie um novo arquivo em que o nome do arquivo seja o nome da classe seguido de controller em pascalcase com a extensão .php ex: `ExemploController.php`

2. O método padrão da classe deve ser `index()`. É o primeiro método chamado quando se acessa um determinado controller.
   - Acessando a URL `/agenda/`, a classe chamada será `Agenda` e automaticamente o método chamado sera `index()`.
   - Apenas se eu acessar `/agenda/contato/` é que o método `contato()`, se existir, será chamado.

---

## Trabalhando com métodos no controller

- O método padrão chamado quando a classe é chamada é o `index()`. O método `index()` é chamado mesmo sem ser chamado no link.
- O método `view(caminho-da-view, dados)` da superclasse `Controller` é quem carregará a view. Ex: `$this->view('agenda/contato')`.
- O parametro dados do método view é opcional e é responsavel por carregar informações dinamicas para o view. Ele deve receber um array

   ``` code
   public function contato($nome){
      $dados = ['nomeContato' => $nome];
      $this->view('agenda/contato', $dados);
   }
   ```

- Na view esses dados serão chamados pela chave do array passado no controller

   ``` code
      <h2>Olá, <?= $nome ?></h2>
   ```

---

## Trabalhando com models

- Na pasta `src/models` crie um novo arquivo com o mesmo nome da nova classe.
- Essa classe deve herdar a classe `Model` que fica na pasta `Core`.
- Herdando a classe `Model` use `$this->db` para fazer consultas ao banco de dados. A propria classe `Model` faz essa conexão automática.
- Exemplo de uso:

  ``` PHP
  <?php
  namespace App\models;
  use App\core\Model;

  class User extends Model
  {
    //Cria um noivo usuario no banco de dados
    public function createUser($nome){
      $params = [':nome' => $nome];
      $this->db->query('INSERT INTO usuario (nome) VALUES (:nome)', $params);
    }
  }
  ```

---

## Criando um novo view

- As views devem ser criadas na pasta `src/views`.
- De preferencia devem ser criadas pastas para cada controller diferente trabalhado.
  - Ex: para `HomeController` existe o caminho `src/views/home`.
- Os dados são passados para views em um array mas dentro da view se usa o nome da chave como variavel do dado.
  - Ex: em `HomeController` os dados são passados como `$data = ['nome' => 'john']`
  - Na view se usa `<?= $nome ?>` para retornar o valor da variavel
- Caso esteja usando o método `fetchAll()` para retornar todos os dados de um banco de dados, use `$viewData` na view para receber estes dados.

---

## Testes e verificação

- Teste a rota base (`/home/index`) e uma rota com parâmetros.  
- Force um 404 para confirmar `src/views/error/404.php`.  
- Verifique o log do Apache / PHP-FPM caso algo não funcione (erros de classe não encontrada normalmente indicam problema de autoload ou path incorreto).

---

## Contato / Autor

Meu email é (`leonardoalvesaraujo@hotmail.com`)

---

## Licença

Este projeto é de uso livre para fins de aprendizado, testes e extensão.
Você pode modificá-lo e utilizá-lo como base para outros projetos.
