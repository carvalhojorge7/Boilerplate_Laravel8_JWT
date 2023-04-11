# Laravel 8 Boilerplate com JWT

Este projeto é um boilerplate básico para o Laravel 8 com o JWT já implementado e uma tabela de usuários com um seeder padrão que contém o usuário admin@admin.com.br e senha 12345678.

## Removendo o Git

Se você clonou este repositório e deseja remover o vínculo do Git, siga os seguintes passos:

1. Abra o terminal ou prompt de comando no diretório do repositório que você clonou.

2. Execute o seguinte comando para remover o diretório .git:

`rm -rf .git`

3. Verifique se o diretório .git foi removido executando o comando `ls -a` (no Linux ou macOS) ou `dir /ah` (no Windows). O diretório .git não deve mais estar presente.

## Configurando o Projeto

Depois de remover o vinculo com o Git como descrito acima, você poderá vincular um novo git normalmente para iniciar o seu projeto.
Configure o arquivo .ENV na pasta raiz do projeto para adicionar o seu banco de dados.

Depois de inicializar um novo Git e configurar o .ENV, você pode executar os seguintes comandos:

`composer update`

`composer install`

`php artisan jwt:secret`

`php artisan migrate`

`php artisan DB:seed`

-----------------------------
Obrigado por utilizar este boilerplate do Laravel 8 com JWT! Esperamos que tenha sido útil para você começar seu próximo projeto. Se tiver alguma dúvida ou problema, não hesite em entrar em contato.

Boa sorte com seu projeto! :)
-----------------------------

