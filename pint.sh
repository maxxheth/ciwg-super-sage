#!/bin/bash

. .env # Load environment variables from .env file

if [[ -d $PROJECT_DIR ]]; then
	${PROJECT_DIR}/vendor/bin/pint
else
	echo "Error: Project root directory does not exist: $PROJECT_DIR"
fi
