#!/bin/bash


git config --global credential.helper store

echo "git add ."
git add .

echo "acquiring time now"
time=$(date "+%Y-%m-%d %H:%M:%S")
echo "now is $time"

echo "git commit $time updated"
git commit -m "$time updated"

echo "git push origin master"
git push origin master
