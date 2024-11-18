APP_NAME = $(shell cat .env | grep APP_NAME | sed -E 's/.*=(.*)/\1/')

phpcs:
	./vendor/bin/phpcs app tests

run-tests: ## Run all tests
	./vendor/bin/sail artisan test

