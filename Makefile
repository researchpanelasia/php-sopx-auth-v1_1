all: composer-update

ifneq ("$(wildcard composer.phar)", "")
COMPOSER_IS_LOCAL = 1
else
COMPOSER_IS_LOCAL = 0
endif

composer-update:
ifeq ($(COMPOSER_IS_LOCAL), 1)
	php composer.phar update --prefer-source
else
	composer update --prefer-source
endif

validate:
ifeq ($(COMPOSER_IS_LOCAL), 1)
	php composer.phar validate
else
	composer validate
endif

test:
	./vendor/bin/phpunit tests
