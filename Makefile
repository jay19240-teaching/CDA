dev:
	make -j 2 artisan-serve vuejs
seed:
	cd Cursus-api && php artisan migrate:fresh --seed
artisan-serve:
	cd Cursus-api && php artisan serve
vuejs:
	cd Cursus-spa && npm run dev
test:
	cd Cursus-api && php artisan migrate:fresh --seed
	cd ..
	cd Tests-api && npm run test
init-publish:
	docker context create pokedex-site --docker "host=ssh://root@178.16.129.31"
	docker context use pokedex-site
publish:
	docker context use pokedex-site
	docker-compose down --rmi all --remove-orphans
	docker system prune -a
	docker login https://ghcr.io
	docker compose -f ./docker-stack.yml up -d
publish-data:
    docker exec $(docker ps --filter "name=pokedex-laravel-docker" -q) sh -c "php artisan migrate:fresh --seed"