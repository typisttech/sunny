<?php
 
echo "<h4>The GET Data</h4>";
 
echo "<ul>";
    foreach( $_GET as $key => $value ) {
        echo "<li>" . $key . ": " . $value . "</li>";
    }
echo "</ul>";
 
echo "<p>You can now save or disregard this information, </p>";