#!/usr/bin/perl

use strict;
use warnings;
use CGI;
use JSON;
use File::Basename qw(dirname);
use Cwd qw(abs_path);
use lib dirname(dirname abs_path $0) . '/';
use HybridAuth::Auth qw(userExists createDBH isNotValidDetails isUserPasswordValid getUserHash setCookiesEIE makeNewCookies updateDBCookies);

BEGIN {
    my $cgi = CGI->new;
    my $user = $cgi->param('u');
    my $pass = $cgi->param('p');
    my $DBH = createDBH();

    if (isNotValidDetails($user, $pass) || !userExists($user, $DBH) || !isUserPasswordValid(getUserHash($user, $DBH), $pass)) {
        print $cgi->header(-type => "application/json");
        print encode_json {error => JSON::true, response => "invalid username or password"};
        exit;
    }
    else {
        my @newCookies = makeNewCookies();
        updateDBCookies($user, $newCookies[0], $newCookies[1], $DBH);
        setCookiesEIE($newCookies[0], $newCookies[1]);
        print $cgi->header(-type => "application/json");
        print encode_json {error => JSON::false, response => "successfully logged in"};
        exit;
    }

    open(STDERR, ">&STDOUT");
}