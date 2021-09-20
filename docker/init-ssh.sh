#!/bin/bash

eval "$(ssh-agent -s)"
#ssh-add -k ~/.ssh/bitbucket
if [ ! -f ~/.ssh/known_hosts ]; then
    ssh-keyscan bitbucket.org >> ~/.ssh/known_hosts
fi
