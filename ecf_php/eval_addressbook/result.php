<?php
session_start();
require_once 'Loader.php';
require_once 'Debug.php';


if (empty($_POST['name']) || empty($_POST['city']) || empty($_POST['phone'])) {
    $_SESSION['error'] = 'Toutes les informations sont obligatoires ! ';
    header('location: index.php');
    exit;
}

if (strlen($_POST['name']) < 4) {
    $_SESSION['error'] = "Le nom doit contenir minimum 4 caractères !";
    header('location: index.php');
    exit();
}

if (strlen($_POST['city']) < 4) {
    $_SESSION['error'] = "La ville doit contenir minimum 4 caractères !";
    header('location: index.php');
    exit();
}

$regexPhone = '/^[0-9]([-. ]?[0-9]{2}){4}$/';

if (preg_match($regexPhone,$_POST['phone'])) {
    $_SESSION['error'] = "Le format pour le téléphone ne corresponde pas !";
    header('location: index.php');
    exit();
}

d($_POST);


$entreprise = new Entreprise($_POST['name'], $_POST['city'], $_POST['phone']);





d($entreprise);

if ($entreprise->insert()) {
    $_SESSION['success'] = "Contact ajouté !";
} else {
    $_SESSION['error'] = "Erreur ajout de contact !";
}


?>
<fieldset>
    <legend>Liste des entreprises</legend>
    <table>
        <tr>
            <th>Nom</th>
            <th>Ville</th>
            <th>Téléphone</th>
        </tr>

        <?php
        $entreprises = new EntrepriseManager;

        foreach ($entreprises->getAll() as $entreprise) {
        ?>
            <tr>
                <th><?= $entreprise['ets_name']; ?></th>
                <th><?= $entreprise['ets_city']; ?></th>
                <th><?= $entreprise['ets_phone']; ?></th>
            </tr>
        <?php
        }
        ?>

    </table>
</fieldset>