# laravel-restful-api-skeleton 后端开发 api 骨架
`这是 for restful api`

- use [laravel 5.4](https://laravel.com/docs/5.4) framework

### naming

- psr4 please.
- 此專案變數命名為 lowerCamelCase. (跟 laravel 一樣)

### local server up

為了 docker 部署方便，storage/ 獨立於專案外。(會在 ../${REPO名称}.storage )。

```sh
# run test server stacks
./run.test.stacks.sh

# command line util
./cmd.sh list
```

### test

- ../${REPO名称}.storage folder must be exist.
    * ./run.phpunit.sh 测试 all
    * ./run.phpunit.sh ./tests/Route/ 测试 指定目录 或 档案
    * ./run.phpunit.sh ./tests/Route/v1.0/industry testPut 测试 指定 case

### deploy

- copy storage/* to ${APP_NAME}.storage (APP_NAME: 指的是 .env 设定的 APP_NAME)
- copy .env.example to `.env`
- modify `.env` everything currectly.
    + APP_NAME => 设定为 GIT REPO 名称
    + generate the api key (length must 32) to .env APP_KEY
        * docker exec ${DOCKER_SERVER_NAME} php artisan key:generate
- `docker exec ${DOCKER_SERVER_NAME} composer install --no-dev`

### 更改 laravel 的部份

- enterpoint: mv public/index.php to ./index.php, mv public/.htaccess to ./.htaccess
    * (方便部署, 这样不需要更改 nginx 预设目录, 但需要设定 exclude file rules 如下)

```txt
.git
.env

composer.lock
/vendor/

*.sh
*.md
*.txt
*.log
*.doc
*.docx
```

- 更改结构部份:
```text
.
├── app
│   ├── Exceptions
│   │   ├── Error.php: 定义的 Error (e.g. 通用 error code)
│   │   └── Handler.php: 将 render 改为 json
│   ├── Http
│   │   ├── Middleware
│   │   │    └── LogRoute.php: 增加 route log in storage_path() . '/route'
│   │   └── Kernel.php: middleware 增加 \Barryvdh\Cors\HandleCors::class
│   ├── Model
│   │   ├── Table/* 这里 放 Db table model
│   │   └── DateTime.php 自定义 DateTime model, use carbon
│   └── Providers
│       ├── AppServiceProvider.php: $this->app->useStoragePath(config('app.storage_path')); 为部署 更改 storage 目录, 预设为 ../${APP_NAME}.storage
│       └── RouteServiceProvider.php: 增加 api 版号 规则 & debug route
├── config
│   ├── app.php: add storage_path, 为部署 更改 storage 目录, 预设为 ../${APP_NAME}.storage
│   │   timezone / locale / fallback_locale 增加 env to 设定 APP_TIMEZONE / APP_LOCALE / APP_FALLBACK_LOCALE
│   └── cors.php: add \Barryvdh\Cors\ServiceProvider default config
├── routers
│   ├── api.public.php: public route
│   ├── api.v1.0.php: v1.0 api route (有新增版号时，自行建立)
│   └── debug.php: default debug route, env !== 'production' 时，启用

```

- 内建 composer packages
    * composer require nesbot/carbon
    * composer require symfony/psr-http-message-bridge
    * composer require zendframework/zend-diactoros
    * composer require barryvdh/laravel-cors

- database/migrations/
    * user_table & password_resets_table 为 laravel default 没用到的话可以删了

### GFW issue composer 若在墙内，可设定 repo.packagist
```sh
composer config repo.packagist composer https://packagist.phpcomposer.com
```

##### TODO
- [ ] api authorization (internal service, 暂时未做 若有需求时再做 可写简单的 middleware & config 处理) 
