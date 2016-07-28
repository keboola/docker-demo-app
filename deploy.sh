#!/bin/bash
docker login -u="$QUAY_USERNAME" -p="$QUAY_PASSWORD" quay.io
docker tag keboola/docker-demo-app quay.io/keboola/docker-demo-app:$TRAVIS_TAG
docker tag keboola/docker-demo-app quay.io/keboola/docker-demo-app:latest
docker tag keboola/docker-demo-app quay.io/keboola/docker-demo-private:$TRAVIS_TAG
docker tag keboola/docker-demo-app quay.io/keboola/docker-demo-private:latest
docker images
docker push quay.io/keboola/docker-demo-app:$TRAVIS_TAG
docker push quay.io/keboola/docker-demo-app:latest
docker push quay.io/keboola/docker-demo-private:$TRAVIS_TAG
docker push quay.io/keboola/docker-demo-private:latest
