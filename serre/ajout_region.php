<!DOCTYPE html>
<html>
<body>
<?php
if (!isset($_POST['btnSeConnecter'])) {
    echo '
    <form action="" method = "post" ">
        Numéro: <input name="numero" type="text" size ="30"">
        Nom région: <input name="nomregion" type="text" size ="30"">
        <input type="submit" name="btnSeConnecter"  value="Ajouter région">
    </form>';
} else
{
    require_once 'connexion.php';
    $numero = $_POST['numero'];
    $nomregion = $_POST['nomregion'];
 
    $stmt = $connexion->prepare("INSERT INTO region (noregion, nomregion) VALUES (:numero, :nomregion)");
 
    $stmt->bindValue(":numero", $numero); 
    $stmt->bindValue(":nomregion", $nomregion); 
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    $stmt->execute();
    $enregistrement = $stmt->fetch(); 
  

$nb_ligne_affectees = $stmt->rowCount();
echo $nb_ligne_affectees." ligne() insérée(s).<BR>";
}
?>
</body>
</html>