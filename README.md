##Intelligent UI Design Framework for Web

![Estado do projeto](https://travis-ci.org/brunabxs/PHPGeneticAlgorithm.svg?branch=master)

#### O que é?
Framework que combina Algoritmo Genético, Web Analytics e Teste A/B (MVT) para gerar, avaliar e encontrar novos designs de interfaces web. O objetivo é tentar aprimorar um já existente, embasado nas métricas de uso do sistema.

#### O que utilizamos?
* [HTML5](http://www.w3schools.com/html/html5_intro.asp) e [CSS3](http://www.w3schools.com/css/css3_intro.asp)
* [Javascript](http://www.w3schools.com/js/), [JQuery](http://jquery.com/) e [JQuery UI](http://jqueryui.com/)
* [Xampp](https://www.apachefriends.org/index.html) que já traz o Apache, o PHP e o MySQL 
* [Smarty](http://www.smarty.net/)
* [Cron](http://en.wikipedia.org/wiki/Cron)
* [Piwik](http://piwik.org/)
* [PHPUnit](https://phpunit.de/), [QUnit](http://qunitjs.com/) e [Travis](https://travis-ci.org/)
* [NodeJS](http://nodejs.org/)
  * [restify](https://www.npmjs.org/package/restify)

O projeto foi desenvolvido tanto no Windows, quando no Linux (Manjaro).

#### Do que precisamos?
O projeto está dividido em servidor (./server) e cliente (./client) e cada um apresenta características e demanda ferramentas diferentes.

O servidor é o framework em si. Nele, o Algoritmo Genético, a ferramenta de Web Analytics e Teste A/B são executados.
Já o cliente representa uma aplicação web qualquer que deseja utilizar os serviços deste framework.

##### Servidor
1. Instale o Xampp
2. Instale o Smarty
3. Instale a Piwik
4. Tenha um navegador que aceite HTML5 e CSS3
5. Instale o PHPUnit para rodar os testes

##### Cliente
1. Instale o NodeJS com o restify

### Como utilizamos?
Para iniciar os serviços no Linux

##### Servidor
* Inicie o Apache e o MySQL
```shell
opt/lampp/lampp start
```
* Mova o conteúdo de ./server para o diretório raiz web
```shell
mv ./server/* /opt/lampp/htdocs/
```
* Altere as permissões dos arquivos e diretórios
  * Diretórios devem ser __755__
  * Arquivos devem ser __644__
  * Exceções (devem ser __777__)
    * ./public/smarty_templates
    * ./public/smarty_templates_c
    * ./resources

##### Cliente
1. Inicie o servidor
```shell
cd ./client
node server.js
```

### Como acessamos os serviços?
No painel de controle do servidor você cadastra um novo experimento (algoritmo genético). As gerações do algoritmo genético estão sendo criadas de minuto em minuto e ainda não levam em consideração as métricas da Piwik.
Quando o processo de cadastro for encerrado e o experimento for iniciado, não é possível alterá-lo.
Basta seguir as instruções do tutorial.

- URL: [http://localhost/public](http://localhost/public)

O cliente também deve ser configurado. No entanto, todas as configurações necessárias são exibidas durante o processo de cadastro do experimento.

- URL: [http://localhost:1337/index.html](http://localhost:1337/index.html)
