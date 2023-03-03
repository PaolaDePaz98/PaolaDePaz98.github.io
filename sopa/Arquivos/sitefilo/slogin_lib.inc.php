<?php
// Simple Text-File Login (SiTeFiLo).
// Copyright ©2004,2005,2006 by Mario A. Valdez-Ramirez
// http://www.mariovaldez.net/

// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330,
// Boston, MA 02111-1307, USA.

// You can contact Mario A. Valdez-Ramirez by email
// at mario@mariovaldez.org or paper mail at
// Olmos 809, San Nicolas, NL. 66495, Mexico.


// ====================================================================
// Start of configuration options...
// ====================================================================

// Set default language.
// de = German, en = English, es = Spanish, fr = French
$slogin_default_lang = "en";

// Set default page title.
$slogin_default_pagetitle = "Welcome to my website";

// Set name of users file.
// To disable authentication, just empty the slogin_userstxt variable.
// The PHP slogin_altuser users file is used only if the option
// slogin_canusefopen is set to 0.
$slogin_userstxt = "slog_users.txt";
$slogin_altuser = "slog_users.php";

// To use normal text file (easier to edit) set this to 1 or
// to use alternative php file (if fopen function is disabled) set to 0.
// Read the install.txt file for more information.
$slogin_canusefopen = 1;

// Use MD5 hashes, for extra security if set to 1. The passwords
// in the password file need to be MD5 hashes. Also,
// using a hash will make passwords case-sensitive.
// Read the install.txt file for more information.
$slogin_usehashes = 0;

// Set default redirection target. The user will be sent to this
// URL after login in. It must be the full URL; something
// like "http://www.mydomain.com/welcome.php". Redirection
// can be set on a per-page basis or for-all-pages.
// Note: the "admin" user is never redirected.
$slogin_default_redirect = "";

// Set default logout redirection target. The user will be sent
// to this URL after logout. It must be the full URL; something
// like "http://www.mydomain.com/welcome.php". Redirection
// can be set on a per-page basis or for-all-pages.
// Note: the "admin" user is never redirected.
$slogin_default_logoutredirect = "";

// Enable per-user redirection. The user will be sent to a
// directory with his/her username appended. This require
// that slogin_default_redirect be set. So, for example. if
// slogin_default_redirect is "http://www.mydomain.com/priv/"
// the user "mary" will be sent to the URL:
// http://www.mydomain.com/priv/mary/. If slogin_default_redirect
// is set to "http://www.mydomain.com/user_" then "mary" would be
// sent to http://www.mydomain.com/user_mary/.
// Note: the "admin" user is never redirected.
$slogin_allowuser_redirect = 0;

// ====================================================================
// End of configuration options...
// ====================================================================


// Set error reporting level.
error_reporting (E_ALL & ~E_NOTICE);


// Fix the paths.
if (!isset ($slogin_path)) {
  $slogin_path = "";
}
$slogin_userstxt = $slogin_path . $slogin_userstxt;
$slogin_altuser = $slogin_path . $slogin_altuser;

// Create missing variables.
// (Variables that are optional in each page).
if (!isset ($slogin_lang)) {
  $slogin_lang = "";
}
if (!isset ($slogin_noauthpage)) {
  $slogin_noauthpage = 0;
}
if (!isset ($slogin_pagetitle)) {
  $slogin_pagetitle = "";
}
if (!isset ($slogin_redirect)) {
  $slogin_redirect = "";
}
if (!isset ($slogin_logoutredirect)) {
  $slogin_logoutredirect = "";
}

// Set language if not specified.
if (!$slogin_lang) {
  $slogin_lang = $slogin_default_lang;
}
else {
  $slogin_lang = substr (trim ($slogin_lang), 0, 2);
}
// Set redirect if not specified.
if (!$slogin_redirect) {
  $slogin_redirect = $slogin_default_redirect;
}
else {
  $slogin_redirect = substr (trim ($slogin_redirect), 0, 255);
}
// Set logout redirect if not specified.
if (!$slogin_logoutredirect) {
  $slogin_logoutredirect = $slogin_default_logoutredirect;
}
else {
  $slogin_logoutredirect = substr (trim ($slogin_logoutredirect), 0, 255);
}
// Set page title if not specified.
if (!$slogin_pagetitle) {
  $slogin_pagetitle = $slogin_default_pagetitle;
}
else {
  $slogin_pagetitle = substr (trim ($slogin_pagetitle), 0, 128);
}


// Define some constants.
define ("SLOGIN_USER_PREFIX", "slog_");
define ("SLOGIN_LOG_PREFIX", "slog_");
define ("SLOGIN_LOG_SUFFIX", "_log");
define ("SLOGIN_TIMEZONE_SHIFT", 0);
define ("SLOGIN_USERS_FILE", $slogin_userstxt);
define ("SLOGIN_LOG_FILE", $slogin_path . SLOGIN_LOG_PREFIX . fslogin_logprefix() . SLOGIN_LOG_SUFFIX . ".txt");
define ("SLOGIN_MAXLEN_USERNAME", 32);
define ("SLOGIN_MAXLEN_PASSWORD", 32);
define ("SLOGIN_COLS_TEXTAREA", 60);
define ("SLOGIN_ROWS_TEXTAREA", 15);
define ("SLOGIN_ADMIN_USERNAME", "ADMIN");
define ("SLOGIN_BACKUP_SUFFIX", ".bak.gz");



// Define some message strings.

// English strings
$slogin_text["en"]["Username"] = "Username:";
$slogin_text["en"]["Password"] = "Password:";
$slogin_text["en"]["LoginButton"] = "Enter";
$slogin_text["en"]["UserLoggedIn"] = "User logged in";
$slogin_text["en"]["LoginFailed"] = "Login failed for";
$slogin_text["en"]["WrongLogin"] = "Wrong username or password.";
$slogin_text["en"]["ReturnLogList"] = "Return to log list.";
$slogin_text["en"]["ReturnHome"] = "Return to homepage.";
$slogin_text["en"]["CantRead"] = "CRITICAL ERROR: The users file cannot be read.";
$slogin_text["en"]["CantLog"] = "It seems we cannot create the log files.";
$slogin_text["en"]["NoAdmin"] = "Only the admin user can view the logs.";
$slogin_text["en"]["EnterPlain"] = "Enter the password in plain text to generate the MD5 hashed string:";
$slogin_text["en"]["GetHashed"] = "The hashed password is:";
$slogin_text["en"]["HashButton"] = "Generate";
$slogin_text["en"]["LogList"] = "Available logs.";
$slogin_text["en"]["ShowPHP"] = "Show PHP configuration.";
$slogin_text["en"]["ShowSFL"] = "Show SiTeFiLo configuration.";
$slogin_text["en"]["UserFileList"] = "Password files.";
$slogin_text["en"]["UFileEdit"] = "edit";
$slogin_text["en"]["UFileBak"] = "backup";
$slogin_text["en"]["UFileDL"] = "download";
$slogin_text["en"]["Used"] = "used";
$slogin_text["en"]["Unused"] = "unused";
$slogin_text["en"]["SaveFile"] = "Save file";
$slogin_text["en"]["Cancel"] = "Cancel";
$slogin_text["en"]["MayNotSave"] = "According to your configuration (slogin_canusefopen), we may not be able to save any file. Try to save one to test if we can do it.";
$slogin_text["en"]["CantSave"] = "Unable to save the file.";
$slogin_text["en"]["FileSaved"] = "The file has been saved.";
$slogin_text["en"]["BakFileDel"] = "delete";
$slogin_text["en"]["CantDelete"] = "Unable to delete the file.";
$slogin_text["en"]["FileDeleted"] = "The file has been deleted.";
$slogin_text["en"]["UserLoggedIn"] = "User logged out";
$slogin_text["en"]["BakList"] = "Available backups.";
$slogin_text["en"]["PasswordHasher"] = "MD5 hash generator.";

// Spanish strings
$slogin_text["es"]["Username"] = "Nombre de usuario:";
$slogin_text["es"]["Password"] = "Contrase&ntilde;a:";
$slogin_text["es"]["LoginButton"] = "Entrar";
$slogin_text["es"]["UserLoggedIn"] = "Usuario inici&oacute; sesi&oacute;n";
$slogin_text["es"]["LoginFailed"] = "Inicio de sesión fállido para";
$slogin_text["es"]["WrongLogin"] = "Nombre de usuario o contrase&ntilde;a incorrectos.";
$slogin_text["es"]["ReturnLogList"] = "Regresar a la lista de registros.";
$slogin_text["es"]["ReturnHome"] = "Regresar a p&aacute;gina principal.";
$slogin_text["es"]["CantRead"] = "ERROR CRITICO: No se puede leer el archivo de usuarios.";
$slogin_text["es"]["CantLog"] = "Parece que no podemos crear los registros.";
$slogin_text["es"]["NoAdmin"] = "Sólo el usuario admin puede ver los registros.";
$slogin_text["es"]["EnterPlain"] = "Introduzca la contrase&ntilde;a en texto simple para generar la cadena MD5 encriptada:";
$slogin_text["es"]["GetHashed"] = "La contrase&ntilde;a encryptada es:";
$slogin_text["es"]["HashButton"] = "Generar";
$slogin_text["es"]["LogList"] = "Registros disponibles.";
$slogin_text["es"]["ShowPHP"] = "Mostrar configuraci&oacute;n de PHP.";
$slogin_text["es"]["ShowSFL"] = "Mostrar configuraci&oacute;n de SiTeFiLo.";
$slogin_text["es"]["UserFileList"] = "Archivos de contrase&ntilde;as.";
$slogin_text["es"]["UFileEdit"] = "editar";
$slogin_text["es"]["UFileBak"] = "respaldar";
$slogin_text["es"]["UFileDL"] = "descargar";
$slogin_text["es"]["Used"] = "usado";
$slogin_text["es"]["Unused"] = "no usado";
$slogin_text["es"]["SaveFile"] = "Guardar archivo";
$slogin_text["es"]["Cancel"] = "Cancelar";
$slogin_text["es"]["MayNotSave"] = "De acuerdo a su configuraci&oacute;n (slogin_canusefopen), quiz&aacute;s no podremos guardar ning&uacute;n archivo. Intente guardar uno para probar si podemos hacerlo.";
$slogin_text["es"]["CantSave"] = "No fue posible guardar el archivo.";
$slogin_text["es"]["FileSaved"] = "El archivo ha sido guardado.";
$slogin_text["es"]["BakFileDel"] = "borrar";
$slogin_text["es"]["CantDelete"] = "No fue posible borrar el archivo.";
$slogin_text["es"]["FileDeleted"] = "El archivo ha sido borrado.";
$slogin_text["es"]["UserLoggedIn"] = "Usuario termin&oacute; sesi&oacute;n";
$slogin_text["es"]["BakList"] = "Respaldos disponibles.";
$slogin_text["es"]["PasswordHasher"] = "Generador de hash MD5.";

// French strings contributed by Christophe Helson (christophe.helson@free.fr).
$slogin_text["fr"]["Username"] = "Utilisateur :";
$slogin_text["fr"]["Password"] = "Mot de passe :";
$slogin_text["fr"]["LoginButton"] = "Entrer";
$slogin_text["fr"]["UserLoggedIn"] = "Utilisateur identifi&eacute;";
$slogin_text["fr"]["LoginFailed"] = "Identification &eacute;chou&eacute;e &agrave;cause de";
$slogin_text["fr"]["WrongLogin"] = "Nom d'utilisateur ou mot de passe incorrect.";
$slogin_text["fr"]["ReturnLogList"] = "Retour &agrave;la liste des logs.";
$slogin_text["fr"]["ReturnHome"] = "Retour &agrave;la page d'accueil.";
$slogin_text["fr"]["CantRead"] = "ERREUR CRITIQUE: le fichier utilisateurs ne peut pas &ecirc;tre lu.";
$slogin_text["fr"]["CantLog"] = "Il semble impossible de cr&eacute;er les fichiers logs.";
$slogin_text["fr"]["NoAdmin"] = "Seul l'administrateur peut consulter les logs.";
$slogin_text["fr"]["EnterPlain"] = "Entrez le mot de passe en texte simple pour g&eacute;n&eacute;rer la cha&icirc;ne crypt&eacute;e MD5:";
$slogin_text["fr"]["GetHashed"] = "Le mot de passe crypt&eacute;est:";
$slogin_text["fr"]["HashButton"] = "G&eacute;n&eacute;rer";
$slogin_text["fr"]["LogList"] = "Logs disponibles.";
$slogin_text["fr"]["ShowPHP"] = "Montrer la configuration de PHP.";
$slogin_text["fr"]["ShowSFL"] = "Montrer la configuration de SiTeFiLo.";
$slogin_text["fr"]["UserFileList"] = "Password files.";
$slogin_text["fr"]["UFileEdit"] = "edit";
$slogin_text["fr"]["UFileBak"] = "backup";
$slogin_text["fr"]["UFileDL"] = "download";
$slogin_text["fr"]["Used"] = "used";
$slogin_text["fr"]["Unused"] = "unused";
$slogin_text["fr"]["SaveFile"] = "Save file";
$slogin_text["fr"]["Cancel"] = "Cancel";
$slogin_text["fr"]["MayNotSave"] = "According to your configuration (slogin_canusefopen), we may not be able to save any file. Try to save one to test if we can do it.";
$slogin_text["fr"]["CantSave"] = "Unable to save the file.";
$slogin_text["fr"]["FileSaved"] = "The file has been saved.";
$slogin_text["fr"]["BakFileDel"] = "delete";
$slogin_text["fr"]["CantDelete"] = "Unable to delete the file.";
$slogin_text["fr"]["FileDeleted"] = "The file has been deleted.";
$slogin_text["fr"]["UserLoggedIn"] = "User logged out";
$slogin_text["fr"]["BakList"] = "Available backups.";
$slogin_text["fr"]["PasswordHasher"] = "MD5 hash generator.";

// German strings contributed by Anja Pregowski (pregoanj@zhwin.ch).
$slogin_text["de"]["Username"] = "Benutzername:";
$slogin_text["de"]["Password"] = "Passwort:";
$slogin_text["de"]["LoginButton"] = "anmelden";
$slogin_text["de"]["UserLoggedIn"] = "Benutzer angemeldet";
$slogin_text["de"]["LoginFailed"] = "Anmeldung fehlgeschlagen";
$slogin_text["de"]["WrongLogin"] = "Falscher Benutzername oder Passwort";
$slogin_text["de"]["ReturnLogList"] = "Zurück zur Logliste";
$slogin_text["de"]["ReturnHome"] = "Zurück zur Startseite";
$slogin_text["de"]["CantRead"] = "FEHLER: Die Seite kann nicht gelesen werden.";
$slogin_text["de"]["CantLog"] = "Leider kann kein Logfile erstellt werden.";
$slogin_text["de"]["NoAdmin"] = "Nur der Administrator kann diese Files lesen.";
$slogin_text["de"]["EnterPlain"] = "Bitte Passwort eingeben um die Verschlüsselung zu erzeugen:";
$slogin_text["de"]["GetHashed"] = "Das verschlüsselte Passwort hat den Wert:";
$slogin_text["de"]["HashButton"] = "Generieren";
$slogin_text["de"]["LogList"] = "Vorhandene Logs";
$slogin_text["de"]["ShowPHP"] = "Zeige die PHP Konfiguration.";
$slogin_text["de"]["ShowSFL"] = "Zeige die SiTeFiLo Konfiguration.";
$slogin_text["de"]["UserFileList"] = "Password files.";
$slogin_text["de"]["UFileEdit"] = "edit";
$slogin_text["de"]["UFileBak"] = "backup";
$slogin_text["de"]["UFileDL"] = "download";
$slogin_text["de"]["Used"] = "used";
$slogin_text["de"]["Unused"] = "unused";
$slogin_text["de"]["SaveFile"] = "Save file";
$slogin_text["de"]["Cancel"] = "Cancel";
$slogin_text["de"]["MayNotSave"] = "According to your configuration (slogin_canusefopen), we may not be able to save any file. Try to save one to test if we can do it.";
$slogin_text["de"]["CantSave"] = "Unable to save the file.";
$slogin_text["de"]["FileSaved"] = "The file has been saved.";
$slogin_text["de"]["BakFileDel"] = "delete";
$slogin_text["de"]["CantDelete"] = "Unable to delete the file.";
$slogin_text["de"]["FileDeleted"] = "The file has been deleted.";
$slogin_text["de"]["UserLoggedIn"] = "User logged out";
$slogin_text["de"]["BakList"] = "Available backups.";
$slogin_text["de"]["PasswordHasher"] = "MD5 hash generator.";



// Get environment variables.
$slogin_php_self = $_SERVER["PHP_SELF"];
if (!$slogin_php_self) {
  $slogin_php_self = $HTTP_SERVER_VARS["PHP_SELF"];
  if (!$slogin_php_self) {
    $slogin_php_self = $_ENV["PHP_SELF"];
    if (!$slogin_php_self) {
      $slogin_php_self = getenv("PHP_SELF");
    }
    else $slogin_php_self = "";
  }
}


// Include alternative user file if needed.
$slogin_user = array ();
$slogin_pass = array ();
if (!$slogin_canusefopen) {
  include ($slogin_altuser);
}


// Get login data from login-form or session variables.
if ($_GET["logout"]) { $slogin_logout = 1; } else { $slogin_logout = 0; }
if ($_POST["slogin_POST_explicitauth"]) { $slogin_explicitauth = 1; } else { $slogin_explicitauth = 0; }
if ($_POST["slogin_POST_username"]) { $slogin_loginname = substr (trim (ereg_replace("[^[:alnum:]_.@]", "", $_POST["slogin_POST_username"])), 0, SLOGIN_MAXLEN_USERNAME); } else { $slogin_loginname = ""; }
if ($_POST["slogin_POST_password"]) { $slogin_loginpass = substr (trim (ereg_replace("[^[:alnum:]_.@]", "",$_POST["slogin_POST_password"])), 0, SLOGIN_MAXLEN_PASSWORD); } else { $slogin_loginpass = ""; }
if ($_SESSION["Username"]) { $slogin_Username = substr ($_SESSION["Username"], 0, SLOGIN_MAXLEN_USERNAME); } else { $slogin_Username = ""; }


// Authenticate.
// If we are login out, destroy the session data.
// If logout redirection is enable, redirect after logout.
// If not, check if authentication is needed.
// If needed, show the login form.
// If we are receiving the login form data, check the users file.
// If redirection is enabled, redirect after first authentication.
// If the per-user redirection is enabled, append the username to the redirect URL.
if ($slogin_logout) {
  fslogin_log_user ("{$slogin_text[$slogin_lang]["UserLoggedOut"]} $slogin_loginname");
  @session_unset ();
  @session_destroy ();
  if ($slogin_logoutredirect) {
    if (strtoupper ($slogin_loginname) != SLOGIN_ADMIN_USERNAME) {
      header ("Location: " . $slogin_logoutredirect);
      exit;
    }
  }
  include_once ($slogin_path . "header.inc.php");
  include_once ($slogin_path . "slogin.inc.php");
  include_once ($slogin_path . "footer.inc.php");
  exit;
}
else {
  if (($slogin_noauthpage != 1) || ($slogin_explicitauth)) {
    if ((!$slogin_Username) && (!$slogin_Password)) {
      if ((!$slogin_loginname) && (!$slogin_loginpass)) {
        include_once ($slogin_path . "header.inc.php");
        include_once ($slogin_path . "slogin.inc.php");
        include_once ($slogin_path . "footer.inc.php");
        exit;
      }
      else {
        if (fslogin_check_user ($slogin_loginname, $slogin_loginpass)) {
          fslogin_log_user ("{$slogin_text[$slogin_lang]["UserLoggedIn"]} $slogin_loginname");
          $slogin_Username = $slogin_loginname;
          $slogin_Password = $slogin_loginpass;
          $_SESSION["Username"] = $slogin_loginname;
          if ($slogin_redirect) {
            if (strtoupper ($slogin_loginname) != SLOGIN_ADMIN_USERNAME) {
              if ($slogin_allowuser_redirect) {
                header ("Location: " . $slogin_redirect . $slogin_Username);
              }
              else {
                header ("Location: " . $slogin_redirect);
              }
              exit;
            }
          }
        }
        else {
          fslogin_log_user ("{$slogin_text[$slogin_lang]["LoginFailed"]} $slogin_loginname");
          @session_unset ();
          @session_destroy ();
          include_once ($slogin_path . "header.inc.php");
          echo "<div align=\"center\">{$slogin_text[$slogin_lang]["WrongLogin"]}</div>";
          include_once ($slogin_path . "slogin.inc.php");
          include_once ($slogin_path . "footer.inc.php");
          exit;
        }
      }
    }
  }
}


// Given an username and password, find a match in the users file.
// We support both the plain text file and a PHP include file.
// And we support both clear text passwords and MD5-hashed ones.
// At the end, return the username and password.
function fslogin_check_user ($username, $password) {
global $slogin_canusefopen, $slogin_user, $slogin_pass, $slogin_text, $slogin_lang, $slogin_usehashes;
  if (SLOGIN_USERS_FILE) {
    if ($slogin_canusefopen) {
      if (file_exists (SLOGIN_USERS_FILE) && is_readable (SLOGIN_USERS_FILE)) {
        $slogin_ufilef = @fopen (SLOGIN_USERS_FILE, "rb");
        if ($slogin_ufilef) {
          while ($slogin_content = fgetcsv ($slogin_ufilef, 100, ",")) {
            if (strtoupper (trim ($slogin_content[0])) == strtoupper (trim ($username))) {
              if ($slogin_usehashes) {
                if (trim ($slogin_content[1]) == md5 (trim ($password))) {
                  fclose ($slogin_ufilef);
                  return ($slogin_content);
                }
              }
              else {
                if (strtoupper (trim ($slogin_content[1])) == strtoupper (trim ($password))) {
                  fclose ($slogin_ufilef);
                  return ($slogin_content);
                }
              }
            }
          }
          fclose ($slogin_ufilef);
        }
        else {
          echo "<div align=\"center\">{$slogin_text[$slogin_lang]["CantRead"]}</div>";
        }
      }
    }
    else {
      foreach ($slogin_user as $key => $user) {
        if (strtoupper (trim ($user)) == strtoupper (trim ($username))) {
          if ($slogin_usehashes) {
            if (trim ($slogin_pass[$key]) == md5 (trim ($password))) {
              $slogin_content[0] = $username;
              $slogin_content[1] = $password;
              return ($slogin_content);
            }
          }
          else {
            if (strtoupper (trim ($slogin_pass[$key])) == strtoupper (trim ($password))) {
              $slogin_content[0] = $username;
              $slogin_content[1] = $password;
              return ($slogin_content);
            }
          }
        }
      }
    }
  }
  else {
    $slogin_content[0] = "user";
    $slogin_content[1] = "user";
    return ($slogin_content);
  }
}


// Write a given text line to the log file as fast as possible.
function fslogin_log_user ($loguserline) {
  if (SLOGIN_LOG_FILE) {
    if (!(file_exists (SLOGIN_LOG_FILE) && !is_writable (SLOGIN_LOG_FILE))) {
      $slogin_lfilef = @fopen (SLOGIN_LOG_FILE, 'a');
      if ($slogin_lfilef) {
        fwrite ($slogin_lfilef, fslogin_curdate_string() . ": " . $loguserline . "\n");
        fclose ($slogin_lfilef);
      }
    }
  }
}


// Return the current date in ISO format (YYYY-MM-DD HH:MM:SS), applying a time shift (if needed).
function fslogin_curdate_string () {
  return (date("Y-m-d H:i:s", mktime(date("H")+SLOGIN_TIMEZONE_SHIFT,date("i"),date("s"),date("m"),date("d"),date("Y"))));
}

// Return the prefix of the log file according to the current year and month (YYYYMM).
function fslogin_logprefix () {
  return (date("Ym", mktime(date("H")+SLOGIN_TIMEZONE_SHIFT,date("i"),date("s"),date("m"),date("d"),date("Y"))));
}



// Display the available logs...
function fslogin_show_logs () {
global $slogin_php_self;
  $logs_dirhandle = opendir (".");
  $logs_sorteddir = array ();
  $logs_count = 0;
  while (($logs_file = readdir ($logs_dirhandle)) != false)
    $logs_sorteddir[count ($logs_sorteddir)] = $logs_file;
  closedir ($logs_dirhandle);
  rsort ($logs_sorteddir);
  echo "<ul>\n";
  foreach ($logs_sorteddir as $logs_file) {
    if (($logs_file != ".") && ($logs_file != "..") && (eregi (SLOGIN_LOG_SUFFIX . "\.txt$", strtolower ($logs_file))) && (eregi ("^" . SLOGIN_LOG_PREFIX, strtolower ($logs_file)))) {
      $logsize = ceil (filesize ($logs_file) / 1024);
      $logs_file = strtolower ($logs_file);
      $logs_file = substr ($logs_file, strlen (SLOGIN_LOG_PREFIX), strlen ($logs_file));
      $logs_file = substr ($logs_file, 0, strlen (fslogin_logprefix ()));
      echo "<li class=\"maintext\">";
      echo "<A href=\"$slogin_php_self?log=" . $logs_file . "\">$logs_file</a> ($logsize k)";
      echo "</li>\n";
      $logs_count++;
    }
  }
  echo "</ul>\n";
  return ($logs_count);
}


// Display the available backups...
function fslogin_show_baks () {
global $slogin_php_self, $slogin_lang, $slogin_text;
  $baks_dirhandle = opendir (".");
  $baks_sorteddir = array ();
  $baks_count = 0;
  while (($baks_file = readdir ($baks_dirhandle)) != false)
    $baks_sorteddir[count ($baks_sorteddir)] = $baks_file;
  closedir ($baks_dirhandle);
  rsort ($baks_sorteddir);
  echo "<ul>\n";
  foreach ($baks_sorteddir as $baks_file) {
    if (($baks_file != ".") && ($baks_file != "..") && (eregi ("\\" . SLOGIN_BACKUP_SUFFIX . "$", strtolower ($baks_file)))) {
      $baksize = ceil (filesize ($baks_file) / 1024);
      echo "<form action=\"$slogin_php_self\" method=\"post\">\n";
      echo "<li class=\"maintext\">";
      echo "<A href=\"$baks_file\">$baks_file</a> ($baksize k)";
      echo " <input type=\"hidden\" name=\"slogin_POST_filename\" value=\"$baks_file\">";
      echo " <input type=\"submit\" name=\"slogin_POST_delbak\" value=\"{$slogin_text[$slogin_lang]["BakFileDel"]}\">";
      echo "</li>\n";
      echo "</form>\n";
      $baks_count++;
    }
  }
  echo "</ul>\n";
  return ($baks_count);
}


function fslogin_norm_poststring ($poststr, $maxlen = 0) {
  $poststr = trim (ereg_replace (" +", " ", $poststr));
  if (get_magic_quotes_gpc ()) {
    $poststr = stripslashes ($poststr);
  }
  if ($maxlen > 0) {
    $poststr = substr ($poststr, 0, ($maxlen - 1));
  }
  return ($poststr);
}


function fslogin_norm_filename ($poststr, $maxlen = 255) {
  $poststr = str_replace (" ", "_", trim ($poststr));
  $poststr = fslogin_remove_accents ($poststr);
  $poststr = ereg_replace ("[^[:alnum:]_.-]", "", $poststr);
  if (get_magic_quotes_gpc ()) {
    $poststr = stripslashes ($poststr);
  }
  if ($maxlen > 0) {
    $poststr = substr ($poststr, 0, ($maxlen - 1));
  }
  return ($poststr);
}


// fcm_remove_accents
// Based on removeaccents function posted in php.net by "hotmail - marksteward".
function fslogin_remove_accents ($string) {
return strtr(strtr ($string,
  'ŠŽšžŸÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝàáâãäåçèéêëìíîïñòóôõöøùúûüýÿ',
  'SZszYAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy'),
  array('Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh', 'ß' => 'ss',
  'Œ' => 'OE', 'œ' => 'oe', 'Æ' => 'AE', 'æ' => 'ae', 'µ' => 'u'));
}




// Compress a file with the gzip algorithm.
function fslogin_gzip_file ($slogin_gzsource, $slogin_gztarget) {
  if (function_exists ("gzwrite") && file_exists ($slogin_gzsource)) {
    $slogin_ungzfp = @fopen ($slogin_gzsource, "rb");
    $slogin_gzfp = @gzopen ($slogin_gztarget, "wb9");
    if ($slogin_gzfp && $slogin_ungzfp) {
      while (!feof ($slogin_ungzfp)) {
        @set_time_limit (60);
        gzwrite ($slogin_gzfp, fread ($slogin_ungzfp, 65535));
      }
      @fclose ($slogin_ungzfp);
      @gzclose ($slogin_gzfp);
      return (true);
    }
    else {
      @fclose ($slogin_ungzfp);
      @gzclose ($slogin_gzfp);
      return (false);
    }
  }
  else {
    return (false);
  }
  return (false);
}


function fslogin_del_file ($filename){
  if ($filename) {
    return (@unlink ($filename));
  }
  else {
    return (true);
  }
}




?>