<?php
$__errors = array();
global $__errors;
set_error_handler('errorHandler', E_ALL);

function errorHandler ($errno, $errstr, $errfile, $errline, $errcontext)
// If the error condition is E_USER_ERROR or above then abort
{   global $__errors;
   switch ($errno)
   {
      case E_USER_WARNING:
        echo "<p style='color:red;'>ERROR: Handlingen du utförde kunde inte registreras.</p>";
      case E_USER_NOTICE:
      case E_WARNING:
      case E_NOTICE:
      case E_CORE_WARNING:
      case E_COMPILE_WARNING:
         break;
      case E_USER_ERROR:
      case E_ERROR:
      case E_PARSE:
      case E_CORE_ERROR:
      case E_COMPILE_ERROR:

         global $query;

         session_start();
         @$__errors[] = sprintf('"%s" (%s line %s)', $errno, $errstr, $errfile, $errline, $errcontext);
         if (eregi('^(sql)$', $errstr)) {
            $MYSQL_ERRNO = mysql_errno();
            $MYSQL_ERROR = mysql_error();
            $errstr = "MySQL error: $MYSQL_ERRNO : $MYSQL_ERROR";
         } else {
            $query = NULL;
         } // if

         echo "<h2 style='color:red;'>This system is temporarily unavailable.\n
         Var god och starta om och kontakta administratören.</h2>\n";
         echo "<b><font color='red'>\n";
         echo "<p>Fatal Error: $errstr (# $errno).</p>\n";
         if ($query) echo "<p>SQL query: $query</p>\n";
         echo "<p>Error in line $errline of file '$errfile'.</p>\n";
         echo "<p>Script: '{$_SERVER['PHP_SELF']}'.</p>\n";
         echo "</b></font>";
         // Stop the system
         session_unset();
         session_destroy();
         die();
      default:
         break;
   } // switch
};
function send_error_log() {
    global $__errors;

    if ( count( $__errors ) > 0 ) {
        foreach ( $__errors as $error ) {
            $body . $error . "\n";
        }
        mail('bjoal199@student.liu.se', 'error log', $body );
    };
}; // errorHandler
register_shutdown_function( 'send_error_log' );
?>
