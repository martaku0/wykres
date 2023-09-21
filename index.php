<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pomiary</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <map name="pomiary">
        <area shape="circle" coords="100,100,20" alt="1" >
    </map>
    <?php 
        echo "<img src='wykres.php?height=", isset($_GET["height"])?$_GET["height"]:"250", "&width=", isset($_GET["width"])?$_GET["width"]:"820","' >"; 
    ?>
</body>

</html>