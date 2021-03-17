<?php

/**
 *  AGORA
 * 	©  Logma, 2019
 * @package default
 * @author MD
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 * 
 * Classe d'accès aux données. 
 * Utilise les services de la classe PDO
 * pour l'application AGORA
 * Les attributs sont tous statiques,
 * $monPdo de type PDO 
 * $monPdoJeux qui contiendra l'unique instance de la classe
 */
class PdoJeux
{

    private static $monPdo;
    private static $monPdoJeux = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct()
    {
        // A) >>>>>>>>>>>>>>>   Connexion au serveur et à la base
        try {
            // encodage
            $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'');
            // Crée une instance (un objet) PDO qui représente une connexion à la base
            PdoJeux::$monPdo = new PDO(DSN, DB_USER, DB_PWD, $options);
            // configure l'attribut ATTR_ERRMODE pour définir le mode de rapport d'erreurs 
            // PDO::ERRMODE_EXCEPTION: émet une exception 
            PdoJeux::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // configure l'attribut ATTR_DEFAULT_FETCH_MODE pour définir le mode de récupération par défaut 
            // PDO::FETCH_OBJ: retourne un objet anonyme avec les noms de propriétés 
            //     qui correspondent aux noms des colonnes retournés dans le jeu de résultats
            PdoJeux::$monPdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {    // $e est un objet de la classe PDOException, il expose la description du problème
            die('<section id="main-content"><section class="wrapper"><div class = "erreur">Erreur de connexion à la base de données !<p>'
                . $e->getmessage() . '</p></div></section></section>');
        }
    }

    /**
     * Destructeur, supprime l'instance de PDO  
     */
    public function _destruct()
    {
        PdoJeux::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoJeux = PdoJeux::getPdoJeux();
     * 
     * @return l'unique objet de la classe PdoJeux
     */
    public static function getPdoJeux()
    {
        if (PdoJeux::$monPdoJeux == null) {
            PdoJeux::$monPdoJeux = new PdoJeux();
        }
        return PdoJeux::$monPdoJeux;
    }

    //==============================================================================
    //
    //	METHODES POUR LA GESTION DES GENRES
    //
    //==============================================================================

    /**
     * Retourne tous les genres sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Genre)
     */
    public function getLesGenres(): array
    {
        $requete =  'SELECT idGenre as identifiant, libGenre as libelle 
						FROM genre 
						ORDER BY libGenre';
        try {
            $resultat = PdoJeux::$monPdo->query($requete);
            $tbGenres  = $resultat->fetchAll();
            return $tbGenres;
        } catch (PDOException $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Ajoute un nouveau genre avec le libellé donné en paramètre
     * 
     * @param string $libGenre : le libelle du genre à ajouter
     * @return int l'identifiant du genre crée
     */
    public function ajouterGenre(string $libGenre): int
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO genre "
                . "(idGenre, libGenre) "
                . "VALUES (0, :unLibGenre) ");
            $requete_prepare->bindParam(':unLibGenre', $libGenre, PDO::PARAM_STR);
            $requete_prepare->execute();
            // récupérer l'identifiant crée
            return PdoJeux::$monPdo->lastInsertId();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Modifie le libellé du genre donné en paramètre
     * 
     * @param int $idGenre : l'identifiant du genre à modifier  
     * @param string $libGenre : le libellé modifié
     */
    public function modifierGenre(int $idGenre, string $libGenre): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE genre "
                . "SET libGenre = :unLibGenre "
                . "WHERE genre.idGenre = :unIdGenre");
            $requete_prepare->bindParam(':unIdGenre', $idGenre, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unLibGenre', $libGenre, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Supprime le genre donné en paramètre
     * 
     * @param int $idGenre :l'identifiant du genre à supprimer 
     */
    public function supprimerGenre(int $idGenre): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM genre "
                . "WHERE genre.idGenre = :unIdGenre");
            $requete_prepare->bindParam(':unIdGenre', $idGenre, PDO::PARAM_INT);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }

    //==============================================================================
    //
    //	METHODES POUR LA GESTION DES MARQUES
    //
    //==============================================================================

    /**
     * Retourne toutes les marques sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Marque)
     */
    public function getLesMarques(): array
    {
        $requete =  'SELECT idMarque as identifiant, nomMarque as libelle 
                      FROM marque
                      ORDER BY idMarque';
        try {
            $resultat = PdoJeux::$monPdo->query($requete);
            $tbMarques  = $resultat->fetchAll();
            return $tbMarques;
        } catch (PDOException $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Ajoute une nouvelle marque avec le libellé donné en paramètre
     * 
     * @param string $nomMarque : le nom de la marque à ajouter
     * @return int l'identifiant de la marque crée
     */
    public function ajouterMarque(string $nomMarque): int
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO marque "
                . "(idMarque, nomMarque) "
                . "VALUES (0, :unNomMarque) ");
            $requete_prepare->bindParam(':unNomMarque', $nomMarque, PDO::PARAM_STR);
            $requete_prepare->execute();
            // récupérer l'identifiant crée
            return PdoJeux::$monPdo->lastInsertId();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Modifie le nom de la marque donnée en paramètre
     * 
     * @param int $idMarque : l'identifiant de la marque à modifier  
     * @param string $nomMarque : le nom modifié
     */
    public function modifierMarque(int $idMarque, string $nomMarque): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE marque "
                . "SET nomMarque = :unNomMarque "
                . "WHERE marque.idMarque = :unIdMarque");
            $requete_prepare->bindParam(':unIdMarque', $idMarque, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unNomMarque', $nomMarque, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }



    /**
     * Supprime la marque donnée en paramètre
     * 
     * @param int $idMarque :l'identifiant de la marque à supprimer 
     */
    public function supprimerMarque(int $idMarque): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM marque "
                . "WHERE marque.idMarque = :unIdMarque");
            $requete_prepare->bindParam(':unIdMarque', $idMarque, PDO::PARAM_INT);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }
    //==============================================================================
    //
    //	METHODES POUR LA GESTION DES Pegis
    //
    //==============================================================================

    /**
     * Retourne tous les Pegis sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Pegi)
     */
    public function getLesPegis(): array
    {
        $requete =  'SELECT idPegi as identifiant, ageLimite as libelle, descPegi
						FROM Pegi 
						ORDER BY ageLimite';
        try {
            $resultat = PdoJeux::$monPdo->query($requete);
            $tbPegis  = $resultat->fetchAll();
            return $tbPegis;
        } catch (PDOException $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }

    /*
    public function ajouterMarque(string $nomMarque): int
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO marque "
                . "(idMarque, nomMarque) "
                . "VALUES (0, :unNomMarque) ");
            $requete_prepare->bindParam(':unNomMarque', $nomMarque, PDO::PARAM_STR);
            $requete_prepare->execute();
            // récupérer l'identifiant crée
            return PdoJeux::$monPdo->lastInsertId();
*/
    /**
     * Ajoute un nouveau pegi avec le libellé donné en paramètre
     * 
     * @param string $ageLimite : le libelle du Pegi à ajouter
     * @return int l'identifiant du genre crée
     */
    public function ajouterPegi(int $ageLimite, string $descPegi): int
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO pegi "
                . "(idPegi, ageLimite, descPegi) "
                . "VALUES (0, :unAgeLimite, :uneDescPegi) ");
            $requete_prepare->bindParam(':unAgeLimite', $ageLimite, PDO::PARAM_INT);
            $requete_prepare->bindParam(':uneDescPegi', $descPegi, PDO::PARAM_STR);
            $requete_prepare->execute();
            // récupérer l'identifiant créé
            return PdoJeux::$monPdo->lastInsertId();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Modifie le libellé du pegi donné en paramètre
     * 
     * @param int $idPegi : l'identifiant du pegi à modifier  
     * @param string $ageLimite : le libellé modifié
     */
    public function modifierPegi(int $idPegi, string $ageLimite, string $descPegi): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE pegi "
                . "SET ageLimite = :unAgeLimite, descPegi = :uneDescPegi "
                . "WHERE pegi.idPegi = :unIdPegi");
            $requete_prepare->bindParam(':unIdPegi', $idPegi, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unAgeLimite', $ageLimite, PDO::PARAM_INT);
            $requete_prepare->bindParam(':uneDescPegi', $descPegi, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Supprime le Pegi donné en paramètre
     * 
     * @param int $idPegi :l'identifiant du Pegi à supprimer 
     */
    public function supprimerPegi(int $idPegi): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM Pegi "
                . "WHERE Pegi.idPegi = :unIdPegi");
            $requete_prepare->bindParam(':unIdPegi', $idPegi, PDO::PARAM_INT);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }
    //==============================================================================
    //
    //	METHODES POUR LA GESTION DES PlateformeS
    //
    //==============================================================================

    /**
     * Retourne tous les Plateformes sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Plateforme)
     */
    public function getLesPlateformes(): array
    {
        $requete =  'SELECT idPlateforme as identifiant, libPlateforme as libelle 
						FROM Plateforme 
						ORDER BY idPlateforme';
        try {
            $resultat = PdoJeux::$monPdo->query($requete);
            $tbPlateformes  = $resultat->fetchAll();
            return $tbPlateformes;
        } catch (PDOException $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Ajoute un nouveau Plateforme avec le libellé donné en paramètre
     * 
     * @param string $libPlateforme : le libelle du Plateforme à ajouter
     * @return int l'identifiant du Plateforme crée
     */
    public function ajouterPlateforme(string $libPlateforme): int
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO Plateforme "
                . "(idPlateforme, libPlateforme) "
                . "VALUES (0, :unlibPlateforme) ");
            $requete_prepare->bindParam(':unlibPlateforme', $libPlateforme, PDO::PARAM_STR);
            $requete_prepare->execute();
            // récupérer l'identifiant crée
            return PdoJeux::$monPdo->lastInsertId();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Modifie le libellé du Plateforme donné en paramètre
     * 
     * @param int $idPlateforme : l'identifiant du Plateforme à modifier  
     * @param string $libPlateforme : le libellé modifié
     */
    public function modifierPlateforme(int $idPlateforme, string $libPlateforme): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE Plateforme "
                . "SET libPlateforme = :unlibPlateforme "
                . "WHERE Plateforme.idPlateforme = :unidPlateforme");
            $requete_prepare->bindParam(':unidPlateforme', $idPlateforme, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unlibPlateforme', $libPlateforme, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Supprime le Plateforme donné en paramètre
     * 
     * @param int $idPlateforme :l'identifiant du Plateforme à supprimer 
     */
    public function supprimerPlateforme(int $idPlateforme): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM Plateforme "
                . "WHERE Plateforme.idPlateforme = :unidPlateforme");
            $requete_prepare->bindParam(':unidPlateforme', $idPlateforme, PDO::PARAM_INT);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }
    //==============================================================================
    //
    //	METHODES POUR LA GESTION DES Jeux
    //
    //==============================================================================

    /**
       * Retourne tous les Jeux sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Jeu)
     */
    public function getLesJeux(): array
    {
        $requete =  'SELECT refJeu as identifiant, nom as libelle ,prix ,dateParution, p.libPlateforme as plateforme,pegi.ageLimite as pegi,m.nomMarque as marque,g.libGenre as genre
						FROM jeu_video as j
                        INNER JOIN genre as g on j.idGenre=g.idGenre
                        INNER JOIN marque as m on j.idMarque=m.idMarque
                        INNER JOIN pegi on j.idPegi=pegi.idPegi
                        INNER JOIN plateforme as p on j.idPlateforme=p.idPlateforme
						ORDER BY refJeu';
        try {
            $resultat = PdoJeux::$monPdo->query($requete);
            $tbJeux  = $resultat->fetchAll();
            return $tbJeux;
        } catch (PDOException $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Ajoute un nouveau Jeu avec le libellé donné en paramètre
     * 
     * @param string $nom : le libelle du Jeu à ajouter
     * @return int l'identifiant du Jeu crée
     */
    public function ajouterJeu($jeu): string
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO Jeu_video "
                . "(refJeu, nom, idGenre, idPlateforme, idPegi, prix, dateParution, idMarque) "
                . "VALUES (:ref, :nom, :genre, :plateforme, :pegi, :prix, :dateParution, :marque) ");
                $requete_prepare->bindParam(':ref', $jeu->ref);
                $requete_prepare->bindParam(':nom', $jeu->nom);
                $requete_prepare->bindParam(':dateParution',$jeu->dateParution);
                $requete_prepare->bindParam(':prix',$jeu->prix);
                $requete_prepare->bindParam(':genre',$jeu->genre);
                $requete_prepare->bindParam(':plateforme',$jeu->plateforme);
                $requete_prepare->bindParam(':marque',$jeu->marque);
                $requete_prepare->bindParam(':pegi',$jeu->pegi);

                $requete_prepare->execute();
            // récupérer l'identifiant crée
            return $jeu->ref;
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Modifie le libellé du Jeu donné en paramètre
     * 
     * @param int $refJeu : l'identifiant du Jeu à modifier  
     * @param string $nom : le libellé modifié
     */
    public function modifierJeu(string $refJeu, string $nom): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE Jeu_video "
                . "SET nom = :unNom, dateParution = :uneDateParution, prix = :unPrix, genre = :unGenre, plateforme = :unePlateforme, pegi = :unPegi, marque = :uneMarque  "
                . "WHERE Jeu_video.refJeu = :uneRefJeu");
            $requete_prepare->bindParam(':unNom', $nom, PDO::PARAM_STR);
            $requete_prepare->bindParam(':uneDateParution', $dateParution);
            $requete_prepare->bindParam(':unPrix', $prix);
            $requete_prepare->bindParam(':unGenre', $genre);
            $requete_prepare->bindParam(':unePlateforme', $plateforme);
            $requete_prepare->bindParam(':unPegi', $pegi);
            $requete_prepare->bindParam(':uneMarque', $marque);

            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }


    /**
     * Supprime le Jeu donné en paramètre
     * 
     * @param int $refJeu :l'identifiant du Jeu à supprimer 
     */
    public function supprimerJeu(string $refJeu): void
    {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM jeu_video "
                . "WHERE Jeu_video.refJeu = :uneRefJeu");
            $requete_prepare->bindParam(':uneRefJeu', $refJeu, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
                . $e->getmessage() . '</p></div>');
        }
    }
    
}
