<?php
/**
 * Page d'accueil de l'application AgoraBo

 * Point d'entrée unique de l'application
 * @author MD
 * @package default
 */
require 'vue/v_header.html';	// entête des pages HTML

// inclure les bibliothèques de fonctions
require_once 'app/_config.inc.php';
require_once 'modele/class.PdoJeux.inc.php';
	
// Connexion au serveur et à la base (A)
$db = PdoJeux::getPdoJeux();

// Récupère l'identifiant de la page passé via l'URL
// Si non défini, on considère que la page demandée est la page d'accueil
if (!isset($_GET['uc'])){
    $_GET['uc'] = 'index';
}
$uc = $_GET['uc'];

// selon la valeur du use case demandé(uc) on inclut le contrôleur secondaire
switch($uc){
	case 'index' : {
		$menuActif = '';
		require 'vue/v_menu.php';
        require 'vue/v_accueil.html'; break;
	}
    case 'gererGenres' : {
		$menuActif = 'Jeux';	// pour garder le menu correspondant ouvert
		require 'vue/v_menu.php';
		require 'controleur/c_gererGenres.php';
		break;
	}  
	case 'gererPegis' : {
		$menuActif = 'Jeux';	// pour garder le menu correspondant ouvert
		require 'vue/v_menu.php';
		require 'controleur/c_gererPegis.php';
		break;
	}  
	case 'gererMarques' : {
		$menuActif= 'Jeux';
		require 'vue/v_menu.php';
		require 'controleur/c_gererMarques.php';
		break;
	}
	case 'gererPlateformes' : {
		$menuActif= 'Jeux';
		require 'vue/v_menu.php';
		require 'controleur/c_gererPlateformes.php';
		break;
	}
	case 'gererJeux' : {
		$menuActif= 'Jeux';
		require 'vue/v_menu.php';
		require 'controleur/c_gererJeux.php';
		break;
	}
}

// Fermeture de la connexion (C)
$db = null;	

// pied de page
require('vue/v_footer.html') ;	
?>

