dev:
	make -j 2 artisan-serve vuejs
artisan-serve:
	cd Cursus-api && php artisan serve
vuejs:
	cd Cursus-spa && npm run dev
init-publish:
	docker context create pokedex-site --docker "host=ssh://root@178.16.129.31"
	docker context use pokedex-site
	docker swarm init
publish:
	docker context use pokedex-site
	docker stack deploy -c ./docker-compose.yml pokedex
	docker exec $(shell docker ps --filter "name=^pokedex_laravel-docker" --quiet) bash -c "php artisan migrate"
	docker exec $(shell docker ps --filter "name=^pokedex_laravel-docker" --quiet) bash -c "php artisan db:seed"