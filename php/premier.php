<html>
<body>
<?php
$g = $_GET["pesanteur"];
$t = $_GET["temps"];
$y = $g*$t*$t/2;
$v = $g*$t;

echo("Distance parcourue après $t secondes = $y mètres <br>");
echo("Vitesse acquise après $t secondes = $v mètres/secondes");


?>

</body>
</html>

