
<pre>hello(print)

Połączenie z bazą:
<?php
    include("data.php");
    $mysqli = new mysqli($host, $user, $pass, $db);
    print_r($mysqli);

?>

</pre>