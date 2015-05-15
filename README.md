<h2>Hybrid Cookie Login</h2>


<h1 style='color:red'>WARNING: There are many conflicting errors with these scripts... I'm working on recoding them all from scratch.</h1>


Originally this project was meant to be a simple PHP cookie script login (it still is!), although with my other private projects; I run into issues where I'm using a little PHP here, and a little Perl (CGI) there ect...

The aim of this project is to make a Login, and Register system working in both PHP and Perl. So people may use this script for their Perl project, or maybe their PHP project. (Even both... I use these scripts for some of my projects collaboratively.

Unlike most other Web Cookie logins, this one stores cookie information in a database rather than in an server file.
  
  - Most data in the database is simply base64_encoded, not for any specific reason other than to clean up SQL inputs.
  - Password Encryption is not base64 encrypted, rather a once way, irreversible (safe) method.
  - U_Cookie and P_Cookie are basically a "username & password" to get access to the database.
  
  <h3>Perl Modules:</h3>
- ```use CGI;```
- Standard for CGI web pages in Perl.
- ```use CGI::Cookie;```
- Necessary for Perl Web Cookies
- ``` use MIME::Base64;```
- Used for cleaning inputs, same as in PHP.
- ``` use DBI;```
- Used for connecting to database.

  <h3>Issues:</h3>
  - Brute force is nearly impossible; but still possible as any system is vulnerable to bruteforce. This login system DOES NOT include a CAPTCHA system. (planned)
  - Bruteforcing is a tiny possibility, it'd be extremely difficult for one to do, as the U_Cookie and P_Cookie are random and change every time you re-login, as-well as that the 'hacker' would need to have both u_cookie and p_cookie simultaneously.
  - Increasing cookie length could help with security.

  <h3>Planned:</h3>
  - Add captcha for registering and for logging in after (X) failed login attempts.
  - Temporarily block IP (for X minutes) if (X) failed cookie attempts are made with different cookie values.
  - (won't block if user is repeatedly failing to login with same cookie).
