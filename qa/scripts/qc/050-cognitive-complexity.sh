#!/bin/bash
vendor/bin/phpcs --standard=qa/settings/sa/cognitive-complexity.xml
CC=$?
exit $CC
