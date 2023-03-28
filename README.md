### Passo a passo
Clone Repositório
```sh
[Projeto API Message Extension](https://github.com/MarioGalvaoWoohoo/apiMessageExtensionGauge.git)
```
```sh
cd apiMessageExtensionGauge/
```


Remova o versionamento, caso queira
```sh
rm -rf .git/
```


Crie o Arquivo .env
```sh
cp .env.example .env
```


Atualize as variáveis de ambiente do arquivo .env
```dosini
APP_NAME="API Backend - Mensagem da extensão Gauge"
APP_URL=http://localhost:8180

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=api-message
DB_USERNAME=api-message
DB_PASSWORD=


```


Suba os containers do projeto
```sh
docker-compose up -d
```


Acessar o container
```sh
docker-compose exec app-gauge-message bash
```


Instalar as dependências do projeto
```sh
composer install
```


Gerar a key do projeto Laravel
```sh
php artisan key:generate
```


Acesse o projeto
[http://localhost:8180](http://localhost:8180)
