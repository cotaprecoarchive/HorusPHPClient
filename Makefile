PHPUNIT="./vendor/bin/phpunit"

tests:
	@$(PHPUNIT) --colors tests/.

check-cs:
	@./vendor/bin/phpcs --standard=PSR2 src tests

phpmd:
	@./vendor/bin/phpmd src text phpmd.xml.dist

.PHONY: tests
