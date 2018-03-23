#!/usr/bin/perl

use strict;
use warnings;
use CGI;
use CGI::Cookie;
use File::Basename qw(dirname);
use Cwd qw(abs_path);
use lib dirname(dirname abs_path $0) . '/';
use HybridAuth::Regex qw(isCharNum isPosIntNotBin);
use HybridAuth::Auth qw(getConfig userExists createDBH isNotValidDetails hashPassword setCookiesEIE makeNewCookies);
use JSON;
use DBI;
use String::Random;

sub registerUser {
    my ($user, $pass, $uCookieVal, $pCookieVal, $DBH) = @_;
    my $hash = hashPassword($pass);
    my $table = getConfig->{sql}{table};
    my $sth = $DBH->prepare("INSERT INTO $table (username, hash, u_cookie, p_cookie, upc_changed, create_ip, last_ip, create_ua, last_ua, last_login) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)") or die "Can't prepare: ", $DBH->errstr;
    $sth->execute($user, $hash, $uCookieVal, $pCookieVal, time(), $ENV{REMOTE_ADDR}, $ENV{REMOTE_ADDR}, $ENV{HTTP_USER_AGENT}, $ENV{HTTP_USER_AGENT}, time()) or die "Can't execute: ", $DBH->errstr;
    $sth = $DBH->prepare("SELECT IDN FROM $table WHERE username = ?") or die "Can't prepare: ", $DBH->errstr;
    $sth->execute($user) or die "Can't execute: ", $DBH->errstr;
    return $sth->fetchrow_hashref()->{IDN};
}

sub setCookiesINE {
    my ($cgi, $u, $p) = @_;
    if (defined $cgi->cookie('uCookie') || defined $cgi->cookie('pCookie')) {
        return 0;
    }
    else {
        print "Set-Cookie: " . CGI::Cookie->new(-name => 'uCookie', -value => $u, -expires => '+3M') . "\n";
        print "Set-Cookie: " . CGI::Cookie->new(-name => 'pCookie', -value => $p, -expires => '+3M') . "\n";
    }
}

BEGIN {
    my $cgi = CGI->new;
    my $user = $cgi->param('u');
    my $pass = $cgi->param('p');
    my $DBH = createDBH();
    my @newCookies = makeNewCookies();
    setCookiesEIE($newCookies[0], $newCookies[1]);
    print $cgi->header(-type => "application/json");
    if (isNotValidDetails($user, $pass)) {
        print encode_json isNotValidDetails($user, $pass);
        exit;
    }
    if (userExists($user, $DBH)) {
        print encode_json {error => JSON::true, response => "user exists"};
        exit;
    }
    my $userIDN = registerUser($user, $pass, $newCookies[0], $newCookies[1], $DBH);
    if (!isPosIntNotBin($userIDN)) {
        print encode_json {error => JSON::true, response => "[DB]:Unknown error in registering user"};
        exit;
    }

    print encode_json {error => JSON::false, response => "successfully registered"};

    open(STDERR, ">&STDOUT");
}