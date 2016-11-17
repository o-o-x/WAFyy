# WAFyy - README

	# The idea

		$ Build a simple Web Application Firewall to lock down HTTP parameters using simple alphanumeric filters and lenght method.




#INSTALL

	# Upload WAFyy to a https://yoursite.com/<WAFyy_directory>
	# Go to https://yoursite.com/<WAFyy_directory>/index.php (IF first time u will be transferd to start.php to create password one time password, so keep it safe)
	# Enter your desired password (password > 10 characretrs)
	# Add include.php file absolute path [include("/var/www/html/WAFyy/include.php");] to one of the files on your PHP application that u wish to protect. (if u add it to wp-config.php for example the WAF will protect all parameters) 
	[To get Linux/Windows absolute path on your site go to: https://yoursite.com/<WAFyy_directory>/index.php?location (after login)]


# TO DO

	1. Build support for all HTTP/S protocols.
	2. add JSON parser.
	3. Build file upload parser
	4. Build Tree strucrute to map parameters (/domain.x3e/tools/index.php [q={0-9A-z}]) 
