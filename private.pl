#!/usr/bin/perl

	$cgi = new CGI;
	print $cgi->header(-status=> '200', -type => 'text/html');

require "cookie_login.pl";

print qq{
<p>This is cookie protected!</p>
<p>Members only content here!</p>
		};