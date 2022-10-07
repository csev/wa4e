<!DOCTYPE html>
<html>
<body>

<?php
   // if empty($user) = TRUE, set $status = "anonymous"
   echo $status = (empty($user)) ? "anonymous" : "logged in";
   echo("<br><br>");

   $user = "John Doe";
   // if empty($user) = FALSE, set $status = "logged in"
   echo $status = (empty($user)) ? "anonymous" : "logged in";

   echo("<br><br>");

      // variable $user is the value of $_GET['user']
   // and 'anonymous' if it does not exist
   echo $user = $_GET["user"] ?? "anonymous";
   echo("<br><br>");
  
   // variable $color is "red" if $color does not exist or is null
   echo $color = $color ?? "red";
   
   echo("<br><br>");
   $stuff =132;
   $msg = $stuff >100? "large":"small";
   echo "$stuff is $msg number.\n";

   echo("<br><br>");
   $msg2 = ($stuff % 2 == 0)? "even":"odd";
   echo "$stuff is an $msg2 number.\n";

   // side effect assignments
   echo("<br><br>");
   echo "\n";
   $out = "Hello";
   $out = $out ;" ";
   $out .="World !";
   echo $out; 
   
   echo("<br><br>");
   $count = 0;
   $count += 1;
   echo "Count: $count \n";

?>  

</body>
</html>