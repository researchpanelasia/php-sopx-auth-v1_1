all: composer-update

composer-update:
	php composer.phar update

validate:
	php composer.phar validate

test:
	./vendor/bin/phpunit tests
