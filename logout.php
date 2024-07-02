<?php
  session_start();
      
  session_destroy();
  
  header("Location: sesionUsuario.php");
    
  exit();
?>