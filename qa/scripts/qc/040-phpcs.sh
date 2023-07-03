#!/bin/bash
vendor/bin/phpcs --standard=qa/settings/sa/psr12.xml
PHP_CS=$?
exit $PHP_CS