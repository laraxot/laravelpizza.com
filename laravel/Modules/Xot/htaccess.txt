https://frostbutter.com/articles/htaccess-cache-control-for-a-faster-website/

# Start Cache control
<IfModule mod_expires.c>
    # Turn on the module.
    ExpiresActive on
    
    # Set the default cache times
    ExpiresDefault "access plus 7 days"
    ExpiresByType image/jpg "access plus 3 month"
    ExpiresByType image/svg+xml "access 3 month"
    ExpiresByType image/gif "access plus 3 month"
    ExpiresByType image/jpeg "access plus 3 month"
    ExpiresByType image/png "access plus 3 month"
    ExpiresByType image/ico "access plus 3 month"
    ExpiresByType image/x-icon "access plus 3 month"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType text/javascript "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType text/html "access plus 1 month"
</IfModule>
# End cache control


https://frostbutter.com/articles/redirect-http-to-https-force-https-with-htaccess/

# redirect all http to https
RewriteCond %{HTTPS} off 
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

