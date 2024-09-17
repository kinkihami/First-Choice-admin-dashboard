<?php

$con= mysqli_connect("localhost","root","","firstchoice");

// Check connection
if (!$con)
  {
    echo("Connection failed: " . mysqli_connect_error());
  }
  

?>