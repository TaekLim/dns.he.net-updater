<?php

/******************************************************************************
 * Free DNS.HE.NET updater for home server with dynamic IP address
 * https://github.com/TaekLim/dns.he.net-updater
 * 19th Feb 2014
 ******************************************************************************/

//////////////////////////////////
// Settings
//////////////////////////////////
$domain_name = "example.com";	// The A TYPE name that needs to be updated (example.com, sub.example.com, etc)
$ddns_key = "DDNS_PASSWORD";	// DDNS key for the A TYPE name
$host_name = "example.com"; 	// Host name - usually domain.com

$send_email = true;					// Send email? true/false
$email_title = "Home IP changed";	// Email title
$email_to = "email@email.com";		// Email address

$debug = false;	// If debug need, change to true

$last_ip_file = getcwd()."/dns_he_net.txt";
$last_ip = "";

// Read Last used IP
if (file_exists($last_ip_file)){
	$ip_add = file($last_ip_file);
	$last_ip = trim(end($ip_add));

	// Debug
	if ($debug) echo "Last IP was " . $last_ip . "\n";
}

// Get Current IP
exec('curl ifconfig.me > '.$last_ip_file.' 2>&1');

// Check file exist
if (!file_exists($last_ip_file) && $debug)
	echo "File not exist!\n";

// Read new ip address
$ip_add_new = file($last_ip_file);
$new_ip = trim(end($ip_add_new));

// Debug
if ($debug) echo "New IP is " . $new_ip . "\n";

if ($new_ip != $last_ip || !file_exists($last_ip_file))
{
	if ($debug) echo 'http://'.$domain_name.':'.$ddns_key.'@dyn.dns.he.net/nic/update?hostname='.$host_name.'\n';
	
	exec('curl -4 "http://'.$domain_name.':'.$ddns_key.'@dyn.dns.he.net/nic/update?hostname='.$host_name.'" > /dev/null 2>&1');

	// Send email
	if ($send_email)
	{
		exec('echo "'.$new_ip.'" | mail -s "'.$email_title.'" '.$email_to);

		// Debug
		if ($debug) echo "Email sent\n";
	}
}else if ($debug) {
	echo "Still in same IP.\n";
}
