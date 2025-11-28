up:
	docker compose -f docker/docker-compose.yml up -d && cd web/site && npm i && npm run dev

ps:
	docker compose -f docker/docker-compose.yml ps -a

down:
	docker compose -f docker/docker-compose.yml down

build:
	docker compose -f docker/docker-compose.yml up -d --build

install-laravel:
	docker exec --user=1000:1000 -it sl-php bash -c "cd /var/www && composer create-project laravel/laravel site"

install:
	docker exec --user=1000:1000 -it sl-php bash -c "cd /var/www/site && composer dump-autoload && composer i && cp .env.example .env && php artisan key:generate && php artisan migrate"

migration:
	docker exec --user=1000:1000 -it sl-php bash -c "cd /var/www/site && php artisan make:migration"

migrate:
	docker exec --user=1000:1000 -it sl-php bash -c "cd /var/www/site && php artisan migrate"

test:
	docker exec --user=1000:1000 -it sl-php bash -c "cd /var/www/site && php artisan test"
