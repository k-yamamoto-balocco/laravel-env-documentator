#!/bin/bash
# Mandatory arguments:
# 1) A php source code filename or directory. Can be a comma-separated string
# 2) A report format
# 3) A ruleset filename or a comma-separated string of rulesetfilenames
vendor/bin/phpmd src text qa/settings/sa/phpmd.xml
PHPMD=$?

exit $PHPMD