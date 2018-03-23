<h2>Hybrid Cookie Login</h2>

#Barebones Perl CGI Login Script
  
  <h3>Perl Modules:</h3>
```perl
# for CGI capability of Perl
use CGI;
# for setting cookies in browser
use CGI::Cookie;
# for giving browser/client messages
use JSON;
# for connecting to mysql database
use DBI;
# for creating browser cookies
use String::Random;
# for the custom modules in directory "HybridAuth"
use Exporter qw(import);
use File::Basename qw(dirname);
use Cwd qw(abs_path);
use lib;
# for sql config file (".config.yaml")
use YAML::XS qw(LoadFile);
# for password hashing
use Crypt::PBKDF2;
```

  <h3>Issues:</h3>
  - Brute force is nearly impossible; but still possible as any system is vulnerable to bruteforce. This login system DOES NOT include a CAPTCHA system. (planned)

  <h3>Planned:</h3>
  - Add captcha for registering and for logging in after (X) failed login attempts.
  - Temporarily block IP (for X minutes) if (X) failed cookie attempts are made with different cookie values.
  - (won't block if user is repeatedly failing to login with same cookie).