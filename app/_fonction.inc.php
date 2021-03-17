<?php
//Affiche une liste de choix à partir d'un tableau
// d'objets ayant les attributs (identifiant, libelle)

// $tbObjets : le tableau d'objets.
// $name : les attributs name et id de la liste déroulante.
// $size : l'attribut size de la liste déroulante.
// $idSelect : l'identifiant de l'élément à présélectionner dans la liste.

function afficherListe(array $tbObjets, string $name, int $size, $idSelect){
    if (count($tbObjets)&&(empty($idSelect))){
        $idSelect = $tbObjets[0]->identifiant;
    }
    //tous les id doivent être écrits sous la forme: lst..... pour afficher le 
    //Pour  ne pas avoir à écrire le label dans le prog Principal : echo '<label for="'.$name.'">'.substr($name,3).'</label>';
    echo '<select name="'.$name.'" id="'.$name.'" size="'.$size.'">';
    foreach($tbObjets as $objet){
        if ($objet->identifiant !=$idSelect){
            echo '<option value="'.$objet->identifiant.'">'.$objet->libelle.'</option>';
        }
        else{
            echo '<option selected value="'.$objet->identifiant.'" selected >'.$objet->libelle.'</option>';
        }
    }
    echo '</select>';
    return ($idSelect);
}