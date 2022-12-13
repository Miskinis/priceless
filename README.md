# Priceless
* Priceless is a price tracking platform that uses xpath for data crawling.
* Translations are done statically.
* Site tries to display price change history.
* Price gets crawled daily (auto).

# Dependencies
* Ubuntu OS.
* Docker engine.

# Run
* `git clone https://github.com/Miskinis/priceless.git`
* `cd microblog`
* `sudo chown -R $USER:www-data .`
* `sudo find . -type f -exec chmod 664 {} \;`
* `sudo find . -type d -exec chmod 775 {} \;`
* `sudo chgrp -R www-data storage bootstrap/cache`
* `sudo chmod -R ug+rwx storage bootstrap/cache`
* ```
  docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
    ```
* `sail build --no-cache`
* `alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'`
* `sail up -d`
* `sail npm install && sail npm run build && sail npm run dev`
* `sail artisan migrate --seed`
