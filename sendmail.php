<?php
   $check = mail("rutiksarode7@gmail.com","Testing mail","This is testing mai","from:rutiksarode94@gmail.com");

   if($check)
   {
     echo" email send successfully";
   }
   else
   {
    echo"email not send";
   }
?>