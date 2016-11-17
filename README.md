#WAFyy

Simple Web Application Firewall to lock down HTTP parameters (request array) using simple alphanumeric filters and lenght method.
Also includes simple bootstrap UI to set Headers/Parameters filter based rules.




@HowToInstall

	1. Upload WAFyy to a https://yoursite.com/<WAFyy_directory>
	2. Go to https://yoursite.com/<WAFyy_directory>/index.php (IF first time u will be transferd to start.php to create password one time password, so keep it safe)
	3. Enter your desired password (password > 10 characretrs)
	4. Add include.php file absolute path [include("/var/www/html/WAFyy/include.php");] to one of the files on your PHP application that u wish to protect. (if u add it to wp-config.php for example the WAF will protect all parameters) 
	[To get Linux/Windows absolute path on your site go to: https://yoursite.com/<WAFyy_directory>/index.php?location (after login)]
	5. Make sure "Collect new parameters" flag is "on" int the application.


@TO DO

	@ Build support for all HTTP/S protocols.
	@ add JSON parser.
	@ Build file upload parser
	@ Build Tree strucrute to map parameters (/domain.x3e/tools/index.php [q={0-9A-z}]) 
