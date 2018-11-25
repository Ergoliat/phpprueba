1. Extract the .zip file to your web server

2. Run "phpstockdb.sql" to generate the MySQL tables and populate some records

3. Change the database connection from "ewcfg11.php" file, find this code:

// Database connection info
define("EW_CONN_HOST", 'localhost', TRUE);
define("EW_CONN_PORT", 3306, TRUE);
define("EW_CONN_USER", 'yourusername', TRUE);
define("EW_CONN_PASS", 'yourpassword', TRUE);
define("EW_CONN_DB", 'yourdatabase', TRUE);

and adjust it with yours

4. For login, please use:

- Username: admin
- Password: master

5. If you would like to see the live demo, please visit: http://phpstock.ilovephpmaker.com

