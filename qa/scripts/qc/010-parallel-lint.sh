#!/bin/bash
vendor/bin/parallel-lint src
SYNTAX_CHECK=$?

if [ "$SYNTAX_CHECK" -ne 0 ] ; then
    exit 10
fi

exit 0
