<?php
require_once('connexion.php');
$stmt = $connexion->prepare("SELECT noregion, nomregion FROM region");
$stmt->setFetchMode(PDO::FETCH_OBJ);
$stmt->execute();
while ($enregistrement = $stmt->fetch())
{
    $noregion = $enregistrement ->noregion;
    $nomregion = $enregistrement ->nomregion;

    echo "<table style=width:20% border >
    <td><a>$noregion</a></td>
    <td><a>$nomregion</a></td>
    </table>";

}

?>