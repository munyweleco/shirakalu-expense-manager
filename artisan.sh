#!/bin/bash

# Set ARTISAN_PATH to the directory of the script
ARTISAN_PATH="$(cd "$(dirname "$0")" && pwd)"

# Check if PHP_COMMAND is set, otherwise default to php
PHP_COMMAND="${PHP_COMMAND:-php}"

# Run the artisan command with PHP_COMMAND and pass all arguments
"${PHP_COMMAND}" "${ARTISAN_PATH}/artisan" "$@"
