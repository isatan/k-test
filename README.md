# はじめに

このプロジェクトは APIサーバからのレスポンスをデータベースへ格納するデモ・アプリケーションです。


# システム構成

アプリケーションはサーバサイドアプリケーションとして作成しました。
アプリケーションの実行には RestAPI をコールします。

```
[ アプリケーションサーバ ] ─+─ [ APIサーバ ]
                        └─ [ RDBサーバ ]
```

# ソフトウェア構成

- アプリケーションサーバ
    - Apache 2
    - PHP 7.2
    - CakePHP 3.6.0
- RDBサーバ
    - MySQL 5.7.29
- APIサーバ(mockサーバ)
    - node.js 10.0

## APIサーバ(mockサーバ)について

APIサーバは Swagger Editor にてI仕様を定義し Swagger-CodeGenerator にて自動生成しています。

- swagger 定義ファイル
    - /api-mock/swagger.yaml

## 起動方法

各サーバは Docker にてコンテナ定義をしています。ここでは Docker の利用による起動手順を記載します。

### 動作確認環境

- macOS Catalina 10.15.2
- Docker Desktop 2.1.0.5

### 手順

1. 下記ファイルを同一ディレクトリに ".env" というファイル名でコピーします。
    - /app/config/.env.default
1. 同様に下記ファイルを "app.php" と言うファイル名でコピーします。
    - /app/config/.env.default/app.default.php
1. 下記コマンドを実行します。
```bash
cd {プロジェクトルート}
docker-compose up -d

... Docker の構築プロセス ...

docker exec -it k-test-app /bin/sh
composer install

... composer インストールプロセス ...

exit
```

以上で起動完了です。

## 各エンドポイント

以下はローカルマシンからの各エンドポイントです。

- APIサーバ APIリファレンス
    - [http://localhost:8090/docs/](http://localhost:8090/docs/)

- APIサーバ(mockサーバ)
    - [http://localhost:8090/v1/](http://localhost:8090/v1/)

```curl
curl -X POST --header 'Content-Type: application/x-www-form-urlencoded' --header 'Accept: application/json' -d 'image_path=%2Fhogehoge' 'http://localhost:8090/v1/'
```

- アプリケーションサーバAPI
    - [http://localhost:8080/rest/v1/analyse](http://localhost:8080/rest/v1/analyse)

```curl
curl -X POST --header 'Content-Type: application/x-www-form-urlencoded' --header 'Accept: application/json' -d 'image_path=%2Fhogehoge' 'http://localhost:8080/rest/v1/analyse'
```

- MySQLサーバ
    - host
        - localhost
    - port
        - 3306
    - database
        - k-test
    - user name
        - k-test
    - password
        - k-test
    - root password
        - root


## アプリケーションサーバの主な実装ファイル

- /app/src/Controller/AiAnalysisLogController.php

- /app/src/Model/Entity/AiAnalysisLogModel.php

- /app/src/Service/AiAnalysisService.php
