#!/bin/bash

echo "generating migrations";
sudo php artisan migrate;
echo "migration finished successfully";
sudo php artisan db:seed;
echo "seeding finished successfully";
sudo php artisan serve;

