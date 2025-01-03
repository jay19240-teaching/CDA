dev:
	make -j 2 artisan-serve vuejs
seed:
	cd Cursus-api && php artisan migrate:fresh --seed
artisan-serve:
	cd Cursus-api && php artisan serve
vuejs:
	cd Cursus-spa && npm run dev
init-publish:
	docker context create pokedex-site --docker "host=ssh://root@178.16.129.31"
	docker context use pokedex-site
publish:
	docker context use pokedex-site
	docker-compose down --rmi all --remove-orphans
	docker system prune -a
	docker compose -f ./docker-stack.yml up -d
publish-data:
	docker exec $(shell docker ps --filter "name=^pokedex-laravel-docker" --quiet) bash -c "php artisan migrate:fresh --seed"
	docker exec $(shell docker ps --filter "name=^pokedex-laravel-docker" --quiet) bash -c "chmod -R 755 storage/app/public/"
	docker exec $(shell docker ps --filter "name=^pokedex-laravel-docker" --quiet) bash -c "chown -R www-data:www-data storage/app/public/"