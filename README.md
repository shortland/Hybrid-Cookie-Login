Unlike most other PHP-Cookie logins, this one stores cookie information in the database rather than in a file. 
  
  - Most data in the database is simply base64_encoded, not for any specific reason other than to clean up SQL inputs.
  - Password Encryption is not base64 encrypted, rather a once way, irreversible (safe) method.
  - U_Cookie and P_Cookie are basically a "username & password" to get access to the database.
  - U_Cookie and P_Cookie are reset for the user each time they do a manual login. 
  - This restricts the user to only be logged in on one (device/browser) at a time.

  <h3>Suggested:</h3>
  
  - I strongly suggest you increase each of the cookies lengths.

  <h3>Problems:</h3>
  
  - Bruteforcing is a possibility, though it's extremely difficult for one to do as the U_Cookie and P_Cookie are random and change every time you re-login.
  - Increasing cookie length can ensure more security.

  <h3>Planned:</h3>
  
  - Temporarily block user's IP (for X minutes) if (X) failed cookie attempts are made.
  - With different cookie values (won't block if cookie value is same and repeatedly tried).
  
  - Fix up the SQL coding, it's a little ugly and "not so safe". 
  - Data that is entered into Database is base64_encoded, removes the chances of SQLi.
