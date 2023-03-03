<!--  This is the login form  -->
<form method="post" action="<?php echo $slogin_php_self; ?>">
<?php echo $slogin_text[$slogin_lang]["Username"]; ?> <input type="text" name="slogin_POST_username" value="<?php echo $slogin_loginname; ?>"><br>
<?php echo $slogin_text[$slogin_lang]["Password"]; ?> <input type="password" name="slogin_POST_password"><br>
<input type="submit" name="slogin_POST_send" value="<?php echo $slogin_text[$slogin_lang]["LoginButton"]; ?>">
</form>
