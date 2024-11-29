<!DOCTYPE html>
<html>
<body>
<?php
if (!isset($_POST['btnSeConnecter'])) { /* L'entrée btnSeConnecter est vide = le formulaire n'a pas été submit=posté, on affiche le formulaire */
    echo '
    <form action="" method = "post" ">
        Mel: <input name="mel" type="text" size ="30"">
        Mot de passe: <input name="mot_de_passe" type="text" size ="30"">
        <input type="submit" name="btnSeConnecter"  value="Se connecter">
    </form>';
} else
/* L'utilisateur a cliqué sur Se connecter, l'entrée btnSeConnecter <> vide, on traite le formulaire */
{
// On se connecte
    require_once 'connexion.php';
    $mel = $_POST['mel'];
    $mot_de_passe = $_POST['mot_de_passe'];
 
    $stmt = $connexion->prepare("SELECT * FROM utilisateur where mel=:mel AND mot_de_passe=:mot_de_passe");
 
    $stmt->bindValue(":mel", $mel); // pas de troisième paramètre STR par défaut
    $stmt->bindValue(":mot_de_passe", $mot_de_passe); // idem
    $stmt->setFetchMode(PDO::FETCH_OBJ);
// Les résultats retournés par la requête seront traités en 'mode' objet
    $stmt->execute();
    $enregistrement = $stmt->fetch(); // boucle while inutile
    if ($enregistrement) { // si $enregistrement n'est pas vide = on a trouvé quelque chose -> on est connecté
        echo '<h1>Connexion réussie !</h1>';
    } else { // La requête n'a pas retournée de résultat, on a pas trouvé de ligne correspondant au mel et mot de passe
        echo "Echec à la connexion.";
    }
}
?>
</body>
</html>
8.23.9       (INSERT) Insertion d’une ligne dans une table, avec récupération Id généré (Requête préparée)
Pour ajouter deux lignes dans notre table « utilisateur » on pourra écrire :
Fichier : p_ajouter_utilisateur.php
<?php
require_once('connexion.php');
 
$stmt = $connexion->prepare("INSERT INTO utilisateur (nom, prenom, mel, mot_de_passe) VALUES (:nom, :prenom, :mel, :mot_de_passe)");
 
// insertion d'une ligne
$nom = 'Dupont';
$prenom = 'Paul';
$mel = 'p.dupont@yahoo.fr';
$mot_de_passe = 'secretdupont';
 
$stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
$stmt->bindValue(':prenom', $prenom, PDO::PARAM_STR);
$stmt->bindValue(':mel', $mel, PDO::PARAM_STR);
$stmt->bindValue(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
/* Nota Bene : PDO::PARAM_STR est le type de la valeur a insérer
Dans le cas d'un entier le type sera PDO::PARAM_INT et on ne mettra pas sa valeur entre 'quote'
Pour les types réels, date... on associe le type PDO::PARAM_STR ... PDO::PARAM_STR est le type par défaut : 
on aurait pu ommettre le troisième paramètre ici.
Le PDO::PARAM_INT est indispensable pour la valeur d'un LIMIT d'un SELECT.
Exemple : $numero = 88; $stmt->bindValue(':numero', $mot_de_passe, PDO::PARAM_INT);
Pour la liste des types : https://www.php.net/manual/en/pdo.constants.php
*/
 
$stmt->execute();
$nb_ligne_affectees = $stmt->rowCount();
echo $nb_ligne_affectees." ligne() insérée(s).<BR>";
$dernier_numero = $connexion->lastInsertId();
// Optionnel, Nota Bene : sur récup. sur l'objet PDO, connexion
echo "Dernier numéro utilisateur généré : ".$dernier_numero."<BR>";
 
// insertion d'une autre ligne avec des valeurs différentes
$nom = 'Tremblay';
$prenom = 'Robert';
$mel = 'r.tremblay@gmail.fr';
$mot_de_passe = 'secrettremblay';
$stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
$stmt->bindValue(':prenom', $prenom, PDO::PARAM_STR);
$stmt->bindValue(':mel', $mel, PDO::PARAM_STR);
$stmt->bindValue(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
$stmt->execute();
$nb_ligne_affectees = $stmt->rowCount();
echo $nb_ligne_affectees." ligne() insérée(s).<BR>";
$dernier_numero = $connexion->lastInsertId(); // Optionnel, Nota Bene : sur récup. sur l'objet PDO, connexion
echo "Dernier numéro utilisateur généré : ".$dernier_numero."<BR>";
?>