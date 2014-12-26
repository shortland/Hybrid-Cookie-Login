<h2>This project has been renamed to 'hybrid-cookie-login' :D</h2>
Originally this project was meant to be a simple php cookie script login, although with my other private projects; I run into issues where I'm using PHP here, Perl there and a bunch of languages all together...

The aim of this project will be for a user's cookies to be easily transfered between pages that are not of the same language (php & perl). Basically have multiple versions of 'cookie_login.php' though in different web CGI languages (perl, python...).

Currently, in one of my private projects I'm testing out 'cookie_login.pl' along with the '.php' files in this project, so far its working out great! Once I get most of the bugs worked out & clean up the code I'll post it up here, and grow the hybrid cookie login :D

Unlike most other Web Cookie logins, this one stores cookie information in the database rather than in a file. Cookies will also be shared between pages of not the same language type (.pl, .py, .php...), these pages would share cookies between one another in a simple fashion.
  
  - Most data in the database is simply base64_encoded, not for any specific reason other than to clean up SQL inputs.
  - Password Encryption is not base64 encrypted, rather a once way, irreversible (safe) method.
  - U_Cookie and P_Cookie are basically a "username & password" to get access to the database.
  - U_Cookie and P_Cookie are reset each time the user does a manual login (changes devices). 
  - This restricts the user to only be logged in on one (device/browser) at a time.
  - Most data that is entered into Database is base64_encoded, which removes the chances of SQLi.

  <h3>Suggested:</h3>
  
  - I would suggest you increase each of the cookies lengths, although due to the fact that they change pretty often, its more than average safe.

  <h3>Problems:</h3>
  
  - Bruteforcing is a slim possibility, it'd be extremely difficult for one to do, as the U_Cookie and P_Cookie are random and change every time you re-login, as-well as that the 'hacker' would need to have both u_cookie and p_cookie simultaneously.
  - Increasing cookie length would help with security.

  <h3>Planned:</h3>
  
  - Temporarily block IP (for X minutes) if (X) failed cookie attempts are made with different cookie values.
  - (won't block if user is repeatedly failing to login with same cookie).
  
  - Fix up the SQL coding, it could be neater and safer.
