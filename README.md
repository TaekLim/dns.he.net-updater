dns.he.net-updater
==================

Free DNS.HE.NET updater for home server with dynamic IP address

This script can be used in conjunction with php-cli and crontab on Linux.

Requirement
------------------
- Free acount from https://dns.he.net/
- DDNS key of domain 'A Record' at zone setting page on dns.he.net
-- Before setting up DDNS key, you need to tick for 'Enable entry for dynamic dns' by clicking domain name.

Installation
-------------------

Change settings

$domain_name = "example.com";	// The A TYPE name that needs to be updated (example.com, sub.example.com, etc)
$ddns_key = "DDNS_PASSWORD";	// DDNS key for the A TYPE name
$host_name = "example.com"; 	// Host name - usually domain.com

$send_email = true;					// Send email? true/false
$email_title = "Home IP changed";	// Email title
$email_to = "email@email.com";		// Email address

$debug = false;	// If debug need, change to true

Crontab
0 * * * * /usr/bin/php /home/{LOCATION}/auto_dns.php #Every hour
