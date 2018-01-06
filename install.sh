#!/bin/sh
php --version >> /dev/null 2>&1 || 
(echo "PHP is not installed!" && exit 1)

python --version >> /dev/null 2>&1 ||
(echo "Python is not installed" && exit 1)
(cp $(php -r "print __DIR__.\"/bin/youtube-dl\";") /tmp/youtube-dl && chmod +rwx /tmp/youtube-dl) ||
echo "Failed!" &&
echo "Ready!" 
exit 0