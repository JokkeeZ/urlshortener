# urlshortener
Simple, ugly, quickly made url shortener.

# .htaccess
RewriteEngine On
RewriteRule ^s/([^/]*)$ /short/index.php?s=$1 [L]
