#!/usr/bin/perl

use strict;
use warnings;
use CGI;
use File::Basename qw(dirname);
use Cwd qw(abs_path);
use lib dirname(dirname abs_path $0) . '/';
use HybridAuth::LoggedIn qw(checkLogin attempt_login);

sub body_page {
	print attempt_login()->{username} . " is your username. You will only see this if you're logged in.\n";
	print "Put some user-protected data here...\n";
	print "Replicate this page and rename it if you want to.\n";
}

BEGIN {
    my $cgi = CGI->new;
    print $cgi->header(-type => "text/plain", -status => "200 OK");
	print "hello ";
	checkLogin(attempt_login());
	body_page;
}