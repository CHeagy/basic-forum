<?php
include('includes/master.inc.php');
include("style/header.html");	
include("style/navbar.html");

# index.php
# The main webpage file.  This is the first thing the user sees!

header("Location: view.php");
?>

<h1>Welcome <?php if (!isset($_SESSION['username']) or $_SESSION['username'] == "") { ?> Guest<?php } else { echo $_SESSION['username']; } ?>!</h1>


<?php
include('style/footer.html');
?>

