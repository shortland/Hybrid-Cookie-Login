package HybridAuth::LoggedIn;

use strict;
use warnings;
use CGI;
use DBI;
use YAML::XS qw(LoadFile);
use HybridAuth::Auth qw(getConfig);
use Exporter qw(import);
use Data::Dumper;
our @EXPORT_OK = qw(checkLogin attempt_login);

sub checkLogin {
	my ($uHash) = @_;
    if (!defined $uHash) {
        print "You're not logged in.\n";
        exit;
    }
}

sub attempt_login {
	my $cgi = new CGI;
	if (!defined $cgi->cookie('uCookie') && !defined $cgi->cookie('pCookie')) {
		return undef;
	}
	if (length $cgi->cookie('uCookie') ne 16 || length $cgi->cookie('pCookie') ne 16) {
		return undef
	}
    my $table = getConfig->{sql}{table};
	my $DBH = DBI->connect("DBI:mysql:database=" . getConfig->{sql}{db} . ";host=" . getConfig->{sql}{host}, getConfig->{sql}{user}, getConfig->{sql}{pass}, {'RaiseError' => 1});
    my $sth = $DBH->prepare("SELECT username, IDN FROM $table WHERE u_cookie = ? AND p_cookie = ?");
    $sth->execute($cgi->cookie('uCookie'), $cgi->cookie('pCookie')) or return 0;
    return $sth->fetchrow_hashref();
}

1;