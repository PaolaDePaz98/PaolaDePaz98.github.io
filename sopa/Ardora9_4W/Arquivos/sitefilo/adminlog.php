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
session_start();
$slogin_noauthpage = 0;
$slogin_pagetitle = "Logs viewer, password file editor, hasher and configuration viewer.";
$slogin_path = "./";
include_once ($slogin_path . "/slogin_lib.inc.php");
include_once ($slogin_path . "/header.inc.php");



function fslogin_setpwfile ($pwfileid) {
global $slogin_userstxt, $slogin_altuser;
  if ($pwfileid) {
    $pwfileid = abs (trim ($pwfileid));
    if ($pwfileid == 1) { return $slogin_userstxt; }
    elseif ($pwfileid == 2) { return $slogin_altuser; }
    else { return 0; }
  }
  else { return 0; }
}


function fslogin_adminnav ($option_disabled) {
  global $slogin_php_self, $slogin_lang, $slogin_text;
  echo "<ul>\n";
  if ($option_disabled == 1) {
    echo "<li class=\"maintext\">{$slogin_text[$slogin_lang]["ReturnHome"]}</li>\n";
  }
  else {
    echo "<li class=\"maintext\"><A href=\"index.php\">{$slogin_text[$slogin_lang]["ReturnHome"]}</a></li>\n";
  }
  if ($option_disabled == 2) {
    echo "<li class=\"maintext\">{$slogin_text[$slogin_lang]["ShowSFL"]}</li>\n";
  }
  else {
    echo "<li class=\"maintext\"><A href=\"$slogin_php_self?cfg=1\">{$slogin_text[$slogin_lang]["ShowSFL"]}</a></li>\n";
  }
  if ($option_disabled == 3) {
    echo "<li class=\"maintext\">{$slogin_text[$slogin_lang]["ShowPHP"]}</li>\n";
  }
  else {
    echo "<li class=\"maintext\"><A href=\"$slogin_php_self?info=1\">{$slogin_text[$slogin_lang]["ShowPHP"]}</a></li>\n";
  }
  if ($option_disabled == 4) {
    echo "<li class=\"maintext\">{$slogin_text[$slogin_lang]["ReturnLogList"]}</li>\n";
  }
  else {
    echo "<li class=\"maintext\"><A href=\"$slogin_php_self\">{$slogin_text[$slogin_lang]["ReturnLogList"]}</a></li>\n";
  }
  echo "</ul>\n<hr>\n";
}


// Check if the user is the admin.
if (strtoupper ($slogin_Username) == SLOGIN_ADMIN_USERNAME) {

  // Sanity check for expected external parameters.
  if ($_GET["log"]) { $slogin_showlog = abs (trim ($_GET["log"])); } else { $slogin_showlog = 0; }
  if ($_GET["info"]) { $slogin_showinfo = abs (trim ($_GET["info"])); } else { $slogin_showinfo = 0; }
  if ($_GET["cfg"]) { $slogin_showcfg = abs (trim ($_GET["cfg"])); } else { $slogin_showcfg = 0; }
  if ($_POST["slogin_POST_editfile"]) { $slogin_ufileop = 1; }
  elseif ($_POST["slogin_POST_bakfile"]) { $slogin_ufileop = 2; }
  elseif ($_POST["slogin_POST_savefile"]) { $slogin_ufileop = 3; }
  elseif ($_POST["slogin_POST_delbak"]) { $slogin_ufileop = 4; }
  elseif ($_POST["slogin_POST_edithash"]) { $slogin_ufileop = 5; }
  else { $slogin_ufileop = 0; }
  if ($_POST["slogin_POST_fileid"]) {
    $slogin_ufileid = abs (trim ($_POST["slogin_POST_fileid"]));
    $ufilename = fslogin_setpwfile ($slogin_ufileid);
  }
  elseif ($_POST["slogin_POST_filename"]) {
    $ufilename = fslogin_norm_filename ($_POST["slogin_POST_filename"]);
  }
  else { $slogin_ufileid = 0; }
  if ($_POST["slogin_POST_text"]) { $slogin_filetext = fslogin_norm_poststring ($_POST["slogin_POST_text"], 0); } else { $slogin_filetext = ""; }
  if ($_POST["slogin_POST_plainpass"]) {
    $slogin_md5plainpass = substr (trim (ereg_replace("[^[:alnum:]_.@]", "",$_POST["slogin_POST_plainpass"])), 0, SLOGIN_MAXLEN_USERNAME);
  }
  else {
    $slogin_plainpass = "";
  }



  // Show a given log file.
  if ($slogin_showlog) {
    fslogin_adminnav (0);
    echo "<p class=\"maintext\">$slogin_showlog</p>";
    echo "<pre>";
    @include (SLOGIN_LOG_PREFIX . $slogin_showlog . SLOGIN_LOG_SUFFIX . ".txt");
    echo "</pre>";
  }
  // Edit a given password file.
  elseif (($slogin_ufileop == 1) && $ufilename) {
    fslogin_adminnav (0);
    if (!$slogin_canusefopen) {
      echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["MayNotSave"]}</p>";
    }
    echo "<form action=\"$slogin_php_self\" method=\"post\">\n";
    echo "<textarea name=\"slogin_POST_text\" cols=\"" . SLOGIN_COLS_TEXTAREA . "\" rows=\"" . SLOGIN_ROWS_TEXTAREA . "\">" . htmlentities (implode ("", file ($ufilename))) . "</textarea><br>\n";
    echo "<input type=\"hidden\" name=\"slogin_POST_fileid\" value=\"$slogin_ufileid\"> ";
    echo "<input type=\"submit\" name=\"slogin_POST_savefile\" value=\"{$slogin_text[$slogin_lang]["SaveFile"]}\">\n";
    echo "<input type=\"submit\" name=\"slogin_POST_cancel\" value=\"{$slogin_text[$slogin_lang]["Cancel"]}\"><br>\n";
    if ($slogin_usehashes) {
      echo "<br>{$slogin_text[$slogin_lang]["EnterPlain"]}<br>";
      echo "<input type=\"text\" name=\"slogin_POST_plainpass\" value=\"$slogin_md5plainpass\"><br>";
      echo "<input type=\"submit\" name=\"slogin_POST_edithash\" value=\"{$slogin_text[$slogin_lang]["HashButton"]}\">";
    }
    echo "</form>\n";
  }
  // Edit a given password file and show generated MD5 hash of given string.
  elseif (($slogin_ufileop == 5) && $ufilename) {
    fslogin_adminnav (0);
    if (!$slogin_canusefopen) {
      echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["MayNotSave"]}</p>";
    }
    echo "<form action=\"$slogin_php_self\" method=\"post\">\n";
    echo "<textarea name=\"slogin_POST_text\" cols=\"" . SLOGIN_COLS_TEXTAREA . "\" rows=\"" . SLOGIN_ROWS_TEXTAREA . "\">$slogin_filetext</textarea><br>\n";
    echo "<input type=\"hidden\" name=\"slogin_POST_fileid\" value=\"$slogin_ufileid\"> ";
    echo "<input type=\"submit\" name=\"slogin_POST_savefile\" value=\"{$slogin_text[$slogin_lang]["SaveFile"]}\">\n";
    echo "<input type=\"submit\" name=\"slogin_POST_cancel\" value=\"{$slogin_text[$slogin_lang]["Cancel"]}\"><br>\n";
    if ($slogin_usehashes) {
      echo "<br>{$slogin_text[$slogin_lang]["EnterPlain"]}<br>";
      echo "<input type=\"text\" name=\"slogin_POST_plainpass\" value=\"$slogin_md5plainpass\"><br>";
      if ($slogin_md5plainpass) {
        echo "{$slogin_text[$slogin_lang]["Password"]} " . md5 ($slogin_md5plainpass) . "<br>";
      }
      echo "<input type=\"submit\" name=\"slogin_POST_edithash\" value=\"{$slogin_text[$slogin_lang]["HashButton"]}\">";
    }
    echo "</form>\n";
  }
  // Save a given password file.
  elseif (($slogin_ufileop == 3) && $ufilename) {
    fslogin_adminnav (0);
    $slogin_ufile_error = false;
    $slogin_ufilef = @fopen ($ufilename, 'wb');
    if ($slogin_ufilef) {
      if (fwrite ($slogin_ufilef, $slogin_filetext) === false) {
        echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["CantSave"]} (" . basename ($ufilename) . ")</p>";
        $slogin_ufile_error = true;
      }
      fclose ($slogin_ufilef);
    }
    else {
      echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["CantSave"]} (" . basename ($ufilename) . ")</p>";
      $slogin_ufile_error = true;
    }
    if (!$slogin_ufile_error) {
      echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["FileSaved"]} (" . basename ($ufilename) . ")</p>";
    }
  }
  // Backup a given password file.
  elseif (($slogin_ufileop == 2) && $ufilename) {
    fslogin_adminnav (0);
    $slogin_bak_file = dirname ($ufilename) . "/" . date ("Ymd-His", mktime(date("H")+SLOGIN_TIMEZONE_SHIFT,date("i"),date("s"),date("m"),date("d"),date("Y"))) . "-" . basename ($ufilename) . SLOGIN_BACKUP_SUFFIX;
    if (fslogin_gzip_file ($ufilename, $slogin_bak_file)) {
      echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["FileSaved"]} (" . basename ($ufilename) . " -&gt; $slogin_bak_file)</p>";
    }
    else {
      echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["CantSave"]} (" . basename ($ufilename) . " -&gt; $slogin_bak_file)</p>";
    }
  }
  // Delete a given backup file.
  elseif (($slogin_ufileop == 4) && $ufilename) {
    fslogin_adminnav (0);
    if (eregi ("\\" . SLOGIN_BACKUP_SUFFIX . "$", strtolower ($ufilename))) {
      if (fslogin_del_file ($ufilename)) {
        echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["FileDeleted"]} (" . basename ($ufilename) . ")</p>";
      }
      else {
        echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["CantDelete"]} (" . basename ($ufilename) . ")</p>";
      }
    }
    else {
      echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["CantDelete"]} (" . basename ($ufilename) . ")</p>";
    }
  }
  // Show the PHP info.
  elseif ($slogin_showinfo) {
    fslogin_adminnav (3);
    phpinfo ();
  }
  // Show the SiTeFiLo configuration.
  elseif ($slogin_showcfg) {
    fslogin_adminnav (2);
    echo "<p>";
    echo "slogin_default_lang = " . $slogin_default_lang . "<br>";
    echo "slogin_default_pagetitle = " . $slogin_default_pagetitle . "<br>";
    echo "slogin_default_redirect = " . $slogin_default_redirect . "<br>";
    echo "slogin_default_logoutredirect = " . $slogin_default_logoutredirect . "<br>";
    echo "slogin_allowuser_redirect = " . $slogin_allowuser_redirect . "<br>";
    echo "slogin_canusefopen = " . $slogin_canusefopen . "<br>";
    echo "slogin_usehashes = " . $slogin_usehashes . "<br>";
    echo "slogin_path = " . $slogin_path . "<br>";
    echo "slogin_userstxt = " . $slogin_userstxt . "<br>";
    echo "slogin_altuser = " . $slogin_altuser . "<br>";
    echo "LOGIN_USER_PREFIX = " . SLOGIN_USER_PREFIX . "<br>";
    echo "LOGIN_LOG_PREFIX = " . SLOGIN_LOG_PREFIX . "<br>";
    echo "LOGIN_LOG_SUFFIX = " . SLOGIN_LOG_SUFFIX . "<br>";
    echo "LOGIN_TIMEZONE_SHIFT = " . SLOGIN_TIMEZONE_SHIFT . "<br>";
    echo "LOGIN_USERS_FILE = " . SLOGIN_USERS_FILE . "<br>";
    echo "LOGIN_LOG_FILE = " . SLOGIN_LOG_FILE . "<br>";
    echo "LOGIN_MAXLEN_USERNAME = " . SLOGIN_MAXLEN_USERNAME . "<br>";
    echo "LOGIN_MAXLEN_PASSWORD = " . SLOGIN_MAXLEN_PASSWORD . "<br>";
    echo "slogin_php_self = " . $slogin_php_self . "<br>";
    echo "</p>\n";
  }
  // Show available options and files.
  else {
    fslogin_adminnav (4);
    // Display log files list.
    echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["LogList"]}</p>\n";
    $slogin_totallogs = fslogin_show_logs ();
    if (($slogin_totallogs == 0) && ($slogin_canusefopen == 0)) {
      echo "<div align=\"center\">{$slogin_text[$slogin_lang]["CantLog"]}</div>\n";
    }
    echo "<hr>\n";
    // Display password files list and options.
    echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["UserFileList"]}</p>\n";
    echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["MayNotSave"]}</p>";
    echo "<form action=\"$slogin_php_self\" method=\"post\">\n";
    echo "<ul><li class=\"maintext\">" . basename ($slogin_userstxt);
    echo " (" . ceil (filesize ($slogin_userstxt) / 1024) . " k) ";
    if ($slogin_canusefopen) { echo $slogin_text[$slogin_lang]["Used"]; } else { echo $slogin_text[$slogin_lang]["Unused"]; }
    echo " <input type=\"hidden\" name=\"slogin_POST_fileid\" value=\"1\"> \n";
    echo " <input type=\"submit\" name=\"slogin_POST_editfile\" value=\"{$slogin_text[$slogin_lang]["UFileEdit"]}\"> \n";
    echo " <input type=\"submit\" name=\"slogin_POST_bakfile\" value=\"{$slogin_text[$slogin_lang]["UFileBak"]}\"> \n";
    echo "</li></ul>\n";
    echo "</form>\n";
    echo "<form action=\"$slogin_php_self\" method=\"post\">\n";
    echo "<ul><li class=\"maintext\">" . basename ($slogin_altuser);
    echo " (" . ceil (filesize ($slogin_altuser) / 1024) . " k) ";
    if ($slogin_canusefopen) { echo $slogin_text[$slogin_lang]["Unused"]; } else { echo $slogin_text[$slogin_lang]["Used"]; }
    echo " <input type=\"hidden\" name=\"slogin_POST_fileid\" value=\"2\"> \n";
    echo " <input type=\"submit\" name=\"slogin_POST_editfile\" value=\"{$slogin_text[$slogin_lang]["UFileEdit"]}\"> \n";
    echo " <input type=\"submit\" name=\"slogin_POST_bakfile\" value=\"{$slogin_text[$slogin_lang]["UFileBak"]}\"> \n";
    echo "</li></ul>\n";
    echo "</form>\n";
    echo "<hr>\n";
    // MD5 hasher, only if hashes are enabled.
    if ($slogin_usehashes) {
      echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["PasswordHasher"]}</p>\n";
      echo "<form method=\"post\" action=\"$slogin_php_self\">";
      echo "{$slogin_text[$slogin_lang]["EnterPlain"]}<br>";
      echo "<input type=\"text\" name=\"slogin_POST_plainpass\" value=\"$slogin_md5plainpass\"><br>";
      if ($slogin_md5plainpass) {
        echo "{$slogin_text[$slogin_lang]["Password"]} " . md5 ($slogin_md5plainpass) . "<br>";
      }
      echo "<input type=\"submit\" name=\"slogin_POST_edithash\" value=\"{$slogin_text[$slogin_lang]["HashButton"]}\">";
      echo "</form>";
      echo "<hr>\n";
    }
    // Display bak files list.
    echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["BakList"]}</p>\n";
    $slogin_totalbaks = fslogin_show_baks ();
    echo "<hr>\n";
  }
}
// Deny access if the user is not the admin.
else {
  echo "<div align=\"center\">\n";
  echo "<p class=\"maintext\">{$slogin_text[$slogin_lang]["NoAdmin"]}</p>\n";
  echo "<p class=\"maintext\"><A href=\"index.php\">{$slogin_text[$slogin_lang]["ReturnHome"]}</a></p>\n";
  echo "</div>\n";
}




include_once ($slogin_path . "footer.inc.php");
?>