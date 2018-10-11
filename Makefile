default: help

help:
	@echo "Usage:"
	@echo "     make [command]"
	@echo "Available commands:"
	@grep '^[^#[:space:]].*:' Makefile | grep -v '^default' | grep -v '^_' | sed 's/://' | xargs -n 1 echo ' -'

fix-code-standards:
	./vendor/bin/php-cs-fixer fix --verbose

tests:
	$(MAKE) tests-unit
	$(MAKE) tests-integration

tests-coverage:
	rm -rf coverage; ./vendor/bin/phpunit --coverage-html=coverage/ --coverage-clover=coverage/clover.xml

tests-integration:
	./vendor/bin/phpunit --testsuite integration

tests-unit:
	./vendor/bin/phpunit --testsuite unit
