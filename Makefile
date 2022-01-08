#color
# Parameters
SHELL         = bash
# Misc
.DEFAULT_GOAL = help
.PHONY       =  # Not needed here, but you can put your all your targets to be sure
                # there is no name conflict between your files and your targets.
SYMFONY_BIN   = symfony

SYMFONY       = $(EXEC_PHP) bin/console

HTTP_PORT     = 8000
DOCKER_COMPOSE = docker-compose -p oxyvie -f docker-compose.yaml
# Executables
EXEC_PHP      = php
COMPOSER      = composer
CONTAINER_ID_DB = $$(docker container ls -f "name=dbplsql" -q)



DB = docker exec -ti $(CONTAINER_ID_DB)
## —— 🐝 The Strangebuzz Symfony Makefile 🐝 ———————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'


# analyze: ## Analyse & fix syntax errors make analyze name=[tests|src]
# 	 ../tools/php-cs-fixer/vendor/bin/php-cs-fixer --rules=@Symfony  --using-cache=no --diff --dry-run fix $(name)

# analyze-fix: ## Analyse & fix syntax errors make analyze-fix name=[tests|src]
# 	 ../tools/php-cs-fixer/vendor/bin/php-cs-fixer --rules=@Symfony  --using-cache=no --diff fix $(name)

validate:  ## Prepare env dev
	php bin/console doctrine:s:v --env=dev

prepare-dev:  ## Prepare env dev
	symfony console  cache:clear --env=dev
	symfony console  doctrine:database:create --if-not-exists --env=dev
	symfony console  doctrine:schema:update -f --env=dev
update-db: ## update db
	symfony console doctrine:schema:update --force --env=dev
dump-sql-dev:
	php bin/console doctrine:schema:update --env=dev --dump-sql


## —— Docker ———————————————————————————————————————————————————————————————

start: ## start docker bdd postgres
	docker-compose up -d
stop: ## start docker bdd postgres
	docker-compose down
restart: \
	stop \
	start

connect-db:
	$(DB) /bin/bash -c "PGPASSWORD=main psql --username main main"

shell-db:
	$(DB) /bin/bash



## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands
	$(SYMFONY)

serve: ## Serve the application with HTTPS support
	$(SYMFONY_BIN) serve -d

unserve: ## Stop the webserver
	$(SYMFONY_BIN) server:stop

cc: ## Clear the cache. DID YOU CLEAR YOUR CACHE????
	$(SYMFONY) c:c

install-prod: ## Install the application in production mode
	composer install --no-dev --optimize-autoloader

install-npm-dev: ## Install the application in development mode
	npm run dev

install-package-dev: install cc-dev

install:
	composer install


