.PHONY: migration
migration:
	docker exec -it php /bin/bash -c "bin/console make:migration"

.PHONY: migrate
migrate:
	docker exec -it php /bin/bash -c "bin/console doctrine:migration:migrate"

.PHONY: load
load:
	docker exec -it php /bin/bash -c "bin/console doctrine:fixtures:load"