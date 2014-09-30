##Intelligent UI Design Framework for Web

![Estado do projeto](https://travis-ci.org/brunabxs/IntelligentUIDesignFramework.svg?branch=master)

#### O que é?
Framework que combina Algoritmo Genético, Web Analytics e Teste A/B (MVT) para gerar, avaliar e encontrar novos designs de interfaces web. O objetivo é tentar aprimorar um já existente, embasado nas métricas de uso do sistema.

#### O que utilizamos?
* [HTML5](http://www.w3schools.com/html/html5_intro.asp) e [CSS3](http://www.w3schools.com/css/css3_intro.asp)
* [Javascript](http://www.w3schools.com/js/), [JQuery](http://jquery.com/) e [JQuery UI](http://jqueryui.com/)
* [Xampp](https://www.apachefriends.org/index.html) que já traz o Apache, o PHP e o MySQL
* [Composer](https://getcomposer.org/)
* [Smarty](http://www.smarty.net/)
* [Cron](http://en.wikipedia.org/wiki/Cron)
* [Piwik](http://piwik.org/)
* [PHPUnit](https://phpunit.de/), [QUnit](http://qunitjs.com/) e [Travis](https://travis-ci.org/)

O projeto foi desenvolvido tanto no Windows, quando no Linux (Manjaro).

#### Do que precisamos?
1. Instale o Xampp
2. Instale o Composer
3. Instale a Piwik
4. Tenha um navegador que aceite HTML5 e CSS3

#### Como utilizamos no Linux?
* Inicie o Apache e o MySQL
```shell
opt/lampp/lampp start
```
* Instale as dependências com o Composer
```shell
php composer.phar install
```
* Mova o conteúdo do projeto para o diretório raiz web
```shell
mv * /opt/lampp/htdocs/
```
_Atenção:_ Não é necessário mover o diretório *test* e os arquivos *composer.json*, *composer.phar* e *composer.lock* nem *phpunit.xml* e *phpunit\_autoload.php*
* Altere as permissões dos arquivos e diretórios
  * Diretórios devem ser __755__
  * Arquivos devem ser __644__
  * Exceções (devem ser __777__)
    * .smarty\_templates
    * .smarty\_templates\_c
    * ./resources

#### Como acessamos os serviços?
No painel de controle você cadastra um novo experimento (algoritmo genético). As gerações do algoritmo genético estão sendo criadas de minuto em minuto e ainda não levam em consideração as métricas da Piwik.
Quando o processo de cadastro for encerrado e o experimento for iniciado, não é possível alterá-lo.
Basta seguir as instruções do tutorial.

- URL: [http://localhost](http://localhost)

A aplicação cliente também deve ser configurada, sendo exibidas durante o processo de cadastro do experimento.
