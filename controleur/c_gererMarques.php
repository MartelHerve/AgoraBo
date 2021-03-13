	<?php
	// si le paramètre action n'est pas positionné alors
	//		si aucun bouton "action" n'a été envoyé alors par défaut on affiche les Marques
	//		sinon l'action est celle indiquée par le bouton

	if (!isset($_POST['cmdAction'])) {
		$action = 'afficherMarques';
	} else {
		// par défaut
		$action = $_POST['cmdAction'];
	}

	$idMarqueModif = -1;		// positionné si demande de modification
	$notification = 'rien';	// pour notifier la mise à jour dans la vue

	// selon l'action demandée on réalise l'action 
	switch ($action) {

		case 'ajouterNouvelleMarque': {
				if (!empty($_POST['txtNomMarque'])) {
					$idMarqueNotif = $db->ajouterMarque($_POST['txtNomMarque']);
					// $idMarqueNotif est l'idMarque du Marque ajouté
					$notification = 'Ajouté';	// sert à afficher l'ajout réalisé dans la vue
				}
				break;
			}

		case 'demanderModifierMarque': {
				$idMarqueModif = $_POST['txtIdMarque']; // sert à créer un formulaire de modification pour ce Marque
				break;
			}

		case 'validerModifierMarque': {
				$db->modifierMarque($_POST['txtIdMarque'], $_POST['txtNomMarque']);
				$idMarqueNotif = $_POST['txtIdMarque']; // $idMarqueNotif est l'idMarque de la Marque modifié
				$notification = 'Modifié';  // sert à afficher la modification réalisée dans la vue
				break;
			}

		case 'supprimerMarque': {
				$idMarque = $_POST['txtIdMarque'];
				$db->supprimerMarque($idMarque); //  à compléter, voir quelle méthode appeler dans le modèle
				break;
			}
	}

	// l' affichage des Marques se fait dans tous les cas	
	$tbMarques  = $db->getLesMarques();
	require 'vue/v_lesMarques.php';

	?>
