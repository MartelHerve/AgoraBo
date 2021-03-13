<?php
	// si le paramètre action n'est pas positionné alors
	//		si aucun bouton "action" n'a été envoyé alors par défaut on affiche les Jeux
	//		sinon l'action est celle indiquée par le bouton

	if (!isset($_POST['cmdAction'])) {
		 $action = 'afficherJeux';
	}
	else {
		// par défaut
		$action = $_POST['cmdAction'];
	}

	$refJeuModif = -1;		// positionné si demande de modification
	$notification = 'rien';	// pour notifier la mise à jour dans la vue

	// selon l'action demandée on réalise l'action 
	switch($action) {

		case 'ajouterNouveauJeu': {		
			if (!empty($_POST['txtRefJeu'])) {
				$jeu=(object)[
                    'ref'=>$_POST['txtRefJeu'],
                    'nom'=>$_POST['txtNomJeu'],
                    'dateParution'=>$_POST['txtDateParutionJeu'],
                    'prix'=>$_POST['txtPrixJeu'],
                    'genre'=>$_POST['lstGenres'],
                    'plateforme'=>$_POST['lstPlateformes'],
                    'marque'=>$_POST['lstMarques'],
                    'pegi'=>$_POST['lstPegis'],
                ];
                $refJeuNotif=$db->ajouterJeu($jeu);
                $notification='Ajouté';
            }
		  break;
		}

		case 'demanderModifierJeu': {

				$refJeuModif = $_POST['txtRefJeu']; // sert à créer un formulaire de modification pour ce Jeu
			break;
		}
			
		case 'validerModifierJeu': {
			$db->modifierJeu($_POST['txtRefJeu'], $_POST['txtNomJeu']); 
			$refJeuNotif = $_POST['txtRefJeu']; // $RefJeuNotif est l'RefJeu du Jeu modifié
			$notification = 'Modifié';  // sert à afficher la modification réalisée dans la vue
			break;
		}

		case 'supprimerJeu': {
			$refJeu = $_POST['txtRefJeu'];
			$db->supprimerJeu($refJeu); //  à compléter, voir quelle méthode appeler dans le modèle
			break;
		}
	}
		
	// l' affichage des Jeux se fait dans tous les cas	
	$tbJeux  = $db->getLesJeux();		
	require 'vue/v_lesJeux.php';
