#!/bin/sh
php --version >> /dev/null 2>&1 || 
(echo "PHP is not installed!" && exit 1)

python --version >> /dev/null 2>&1 ||
(echo "Python is not installed" && exit 1)

echo "Ready!"
exit 0