My Approach for implementing the "Remember Me feature".

Cookies and a dedicated database table called "rememberedsession" will be used to remember the user.

When a user opens the login page, we check if a cookie with the name "ambitionbox" is stored or not. If the cookie is not stored, we proceed to the normal form of login.

If, however the cookie is found, we gather the username and token value from the token value. The token value is a very large random number.
We then check the "rememberedsessions" table and find the token value corresponding to the username. If the token value from the two sources is same. We know(with some error) that the user is the same and we log him in.

Everytime, the user logs in, the older cookie is deleted and new cookie with new token value is set to ensure security.




