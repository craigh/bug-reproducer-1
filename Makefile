up:
	composer install
	docker-compose up --build -d
	symfony console doctrine:schema:create
	symfony console doctrine:fixtures:load -n
	symfony server:start -d

down:
	symfony server:stop
	symfony console doctrine:schema:drop --force
	docker-compose down

reload:
	symfony console doctrine:schema:drop --force
	symfony console doctrine:schema:create
	symfony console doctrine:fixtures:load -n

load:
	symfony console doctrine:fixtures:load -n
