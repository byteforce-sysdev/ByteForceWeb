#!/bin/bash

BUILD=$1
REGISTRY=images.docker.byteforce.id
REPO=repository/vibranium-images

docker login -u gitlabcicd -p Byteforce2020 $REGISTRY
docker build -t byteforceid/byteforce-id-website .
docker tag byteforceid/byteforce-id-website $REGISTRY/$REPO/byteforce-id-website:$BUILD
exec docker push $REGISTRY/$REPO/byteforce-id-website:$BUILD
