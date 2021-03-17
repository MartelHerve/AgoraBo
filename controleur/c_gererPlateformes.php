<?php
	// si le paramètre action n'est pas positionné alors
	//		si aucun bouton "action" n'a été envoyé alors par défaut on affiche les Plateformes
	//		sinon l'action est celle indiquée par le bouton

	if (!isset($_POST['cmdAction'])) {
		 $action = 'afficherPlateformes';
	}
	else {
		// par défaut
		$action = $_POST['cmdAction'];
	}

	$idPlateformeModif = -1;		// positionné si demande de modification
	$notification = 'rien';	// pour notifier la mise à jour dans la vue

	// selon l'action demandée on réalise l'action 
	switch($action) {

		case 'ajouterNouvellePlateforme': {		
			if (!empty($_POST['txtLibPlateforme'])) {
				$idPlateformeNotif = $db->ajouterPlateforme($_POST['txtLibPlateforme']);
				// $idPlateformeNotif est l'idPlateforme du Plateforme ajouté
				$notification = 'Ajouté';	// sert à afficher l'ajout réalisé dans la vue
			}
		  break;
		}

		case 'demanderModifierPlateforme': {
				$idPlateformeModif = $_POST['txtIdPlateforme']; // sert à créer un formulaire de modification pour ce Plateforme
			break;
		}
			
		case 'validerModifierPlateforme': {
			$db->modifierPlateforme($_POST['txtIdPlateforme'], $_POST['txtLibPlateforme']); 
			$idPlateformeNotif = $_POST['txtIdPlateforme']; // $idPlateformeNotif est l'idPlateforme du Plateforme modifié
			$notification = 'Modifié';  // sert à afficher la modification réalisée dans la vue
			break;
		}

		case 'supprimerPlateforme': {
			$idPlateforme = $_POST['txtIdPlateforme'];
			$db->supprimerPlateforme($idPlateforme); //  à compléter, voir quelle méthode appeler dans le modèle
			break;
		}
	}
		
	// l' affichage des Plateformes se fait dans tous les cas	
	$tbPlateformes  = $db->getLesPlateformes();		
	require 'vue/v_lesPlateformes.php';
