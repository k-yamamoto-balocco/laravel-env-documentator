#!/bin/bash
echo '[Process] phpcbf(psr12 coding standard)'
echo ''
vendor/bin/phpcbf --standard=qa/settings/sa/psr12.xml

# Since phpcbf is supposed to be executed as a set with phpcs, 0 is returned regardless of the result of phpcbf.
exit 0