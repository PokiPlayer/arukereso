#!/usr/bin/env bash

echo "Create directories...";
mkdir -p ./storage/logs;
mkdir -p ./storage/public;
mkdir -p ./storage/framework/cache;
mkdir -p ./storage/framework/cache/data;
mkdir -p ./storage/framework/testing;
mkdir -p ./storage/framework/sessions;
mkdir -p ./storage/framework/views;
echo "Init directories perms..."
chmod 775 -R ./storage;
chmod 777 -R ./storage/framework/cache;
chmod 777 -R ./storage/framework/sessions;
chmod 777 -R ./storage/framework/views;
chmod 777 -R ./storage/logs;
