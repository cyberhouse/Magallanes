default: vendor/autoload.php

test: vendor/autoload.php
	./bin/phpcs --encoding=utf-8 --colors -p --standard=ruleset.xml --extensions=php --severity=1 src/
	./bin/phpcs --encoding=utf-8 --colors -p --standard=ruleset.xml --extensions=php --severity=1 tests/
	./bin/phpunit -c phpunit.xml.dist tests/

fix: composer.phar
	./bin/php-cs-fixer fix --config-file=.php_cs
	./bin/phpcbf --encoding=utf-8 --colors -p --standard=ruleset.xml --extensions=php --severity=1 src/
	./bin/phpcbf --encoding=utf-8 --colors -p --standard=ruleset.xml --extensions=php --severity=1 tests/

phar: mage.phar

install: /usr/local/bin/mage

clean:
	rm -rf vendor
	cd bin && rm -f coveralls php*
	rm -f *.phar
	rm -f .php_cs.cache composer.lock

.PHONY: test fix default clean phar install

vendor/autoload.php: composer.phar
	php composer.phar install -o --prefer-dist --no-dev

composer.phar:
	php -r "readfile('https://getcomposer.org/installer');" | php

mage.phar:
	php -f src/phar.php; chmod +x mage.phar

/usr/local/bin/mage: mage.phar
	cp mage.phar /usr/local/bin/mage && chmod +x /usr/local/bin/mage
