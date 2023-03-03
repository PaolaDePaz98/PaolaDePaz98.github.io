<?php
session_start();
$slogin_noauthpage = 0;
$slogin_pagetitle = "Page title";
$slogin_path = "./";
include_once ($slogin_path . "/slogin_lib.inc.php");
include_once ($slogin_path . "/header.inc.php");
?>


<p>
Here goes your content. Here goes your content.
Here goes your content. Here goes your content.
Here goes your content. Here goes your content.
Here goes your content. Here goes your content.
Here goes your content. Here goes your content.
Here goes your content. Here goes your content.
</p>


<p>This is a link to the administration page:
<a href="adminlog.php">admin page</a>.</p>



<p>This is a simple logout link<br>
To logout <a href="<?php echo $slogin_php_self."?logout=1" ?>">click here</a>.
</p>

<p>This is a simpler logout link<br>
To logout <a href="index.php?logout=1">click here</a>.
</p>


<?php include_once ($slogin_path . "footer.inc.php"); ?>