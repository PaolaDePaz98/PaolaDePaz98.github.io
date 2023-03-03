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
$slogin_noauthpage = 1;
$slogin_pagetitle = "Encrypted password generator.";
include_once ("slogin_lib.inc.php");
include_once ("header.inc.php");


if ($_POST["slogin_POST_plainpass"]) {
  $slogin_plainpass = substr (trim (ereg_replace("[^[:alnum:]_.]", "",$_POST["slogin_POST_plainpass"])), 0, SLOGIN_MAXLEN_USERNAME);
  $slogin_hashedpass = md5 ($slogin_plainpass);
}
else {
  $slogin_plainpass = "";
  $slogin_hashedpass = "";
}


echo "<form method=\"post\" action=\"$slogin_php_self\">";
echo "{$slogin_text[$slogin_lang]["EnterPlain"]}<br>";
echo "<input type=\"text\" name=\"slogin_POST_plainpass\" value=\"$slogin_plainpass\"><br>";
echo "<input type=\"submit\" name=\"slogin_POST_sendgen\" value=\"{$slogin_text[$slogin_lang]["HashButton"]}\">";
echo "</form>";
if ($slogin_hashedpass) {
  echo "<p>{$slogin_text[$slogin_lang]["Password"]} $slogin_hashedpass</p>";
}

include_once ("footer.inc.php"); ?>