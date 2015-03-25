Make
====================================
Makerspace/3D printing billing

The backend is written in PHP 5.2.x using CodeIgniter 2.2.1.

Manifest
===============
Gruntfile.js - Grunt config file; used to configure autorefresh etc
application - application PHP code
config - default config files
deploy.sh - deployment script
htdocs - static assets and the CodeIgniter index.php file
htdocs/web.config - denies access to application and config directories
logs - log4j may be configured to write log files here; webserver-writeable
package.json - npm config file; used to configured Grunt modules
system - CodeIgniter framework

Deployment
===============
First release:
1. Run deploy.sh; this will install the application.
2. Rename the config files in the deployment directory's "config" directory
   from "somefile.php-default" to "somefile.php" and edit them as needed.
   These files will NOT be overwritten by subsequent releases.

Subsequent releases:
1. Run deploy.sh.



Used Components
===============

=> jQuery (v1.11.0) - http://jquery.com/

=> Bootstrap (v3.1.1) - http://getbootstrap.com/

=> Bootstrap Form Helper (v2.3.0) - http://bootstrapformhelpers.com/

=> Bootstrap Validator (v0.4.4) - http://bootstrapvalidator.com/
