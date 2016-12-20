#!/bin/sh

./bin/console assets:install --symlink
./bin/console cache:clear --env=dev