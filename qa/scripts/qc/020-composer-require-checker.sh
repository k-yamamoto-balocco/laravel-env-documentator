#!/bin/bash
vendor/bin/composer-require-checker check composer.json --config-file=qa/settings/sa/crc/composer-require-checker.json
CRC=$?
exit $CRC