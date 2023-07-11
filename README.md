# chress-1

## dev server

### docker

```
docker-compose up
```

localhost:8000

### tailwind

```
npm run tailwind
```

## deployment

### npm install

```
npm install
```

### autoload
```
composer dump-autoload -o
```

### migrate databases

```
php app/Database/Migrations/migrate.php
```

# DOCS

## root

root level .env = global variables

start from: public -> index.php

redirects to: bootstrap -> bootstrap.php

## bootstrap.php

### requires

autoload.php -> composer autoloader

session.php -> session/cookie manager

env.php -> loads global environment variables

constants.php -> absolute path variables

web.php -> routes

### uses

App\Models\System\App -> constructs the database link and resolves routes, 404 redirect

App\Models\System\Config -> converts global .env to php variables

### logic

constructs an APP, feeds in the ROUTER created by WEB.PHP, feeds in the URI and METHOD, and feeds in the ENV variables