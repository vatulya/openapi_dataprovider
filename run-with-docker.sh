#!/usr/bin/env bash

docker build -t openapi_dataprovider . \
  && docker run --rm --interactive --tty --volume $PWD:/app openapi_dataprovider "$@"