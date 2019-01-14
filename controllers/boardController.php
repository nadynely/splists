<?php
require_once('helper.php');

$bdd = dbConnect('splists', 'root', '', 3308);

$res = $bdd->query('SELECT * FROM lists');

$lists = [];

while($donnees = $res->fetch()) {

    $lists[] = $donnees;
        
}

$res->closeCursor();

/* Cas où je reçois une variable POST de _form_list.php: je crée une liste */

if (!empty($_POST['list-title'])) {

$res = $bdd->prepare("INSERT INTO lists(title) VALUES (:title)");

$res->execute([
    "title" => $_POST['list-title']
]);

Header('location: /splists/views/board.php?list_id=' .$bdd->LastInsertId());

}

/* READ (1 élément) : Lecture d'une liste */

function getList($idList) {

    $bdd = dbconnect('splists', 'root', '', 3308);

    $request = 'SELECT * FROM lists WHERE id = ' .$idList;

    $response = $bdd->query($request);

    /* Je m'attends à recevoir 1 seul élément, je ne fais pas de while (tant que...)
    car while me sert à dire: "tant qu'il y a des éléments qui vont dans $liste" or, je n'en ai qu'un seul qui va dans liste
    Voir select* from list */

    $liste = $response->fetch();
    
    return $liste;
}