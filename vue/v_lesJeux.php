<!-- page start-->
<?php require_once 'app/_fonction.inc.php' ?>
<div class="col-sm-12">
    <section class="panel">
        <div class="chat-room-head">
            <h3><i class="fa fa-angle-right"></i> Gérer les jeux</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-advance table-hover">
                <thead>
                    <tr class="tableau-entete">
                        <th><i class="fa fa-bullhorn"></i> Référence</th>
                        <th><i class="fa fa-bookmark"></i> Nom</th>
                        <th><i class="fa fa-bookmark"></i> Date Parution</th>
                        <th><i class="fa fa-bookmark"></i> Prix</th>
                        <th><i class="fa fa-bookmark"></i> genre</th>
                        <th><i class="fa fa-bookmark"></i> plateforme</th>
                        <th><i class="fa fa-bookmark"></i> pegi</th>
                        <th><i class="fa fa-bookmark"></i> Marque</th>

                        <th></th>
                    </tr>
                </thead>

                <body>
                    <!--formulaire pour ajouter un nouveau jeu -->
                    <tr>
                        <form action="index.php?uc=gererJeux" method="post">
                            <td>
                                <input type="text" id="txtRefJeu" name="txtRefJeu" size="16" required minlength="4" maxlength="16">
                            </td>
                            <td>
                                <input type="text" id="txtNomJeu" name="txtNomJeu" size="30" required minlength="4" maxlength="100">
                            </td>
                            <td>
                                <input type="date" id="txtDateParutionJeu" name="txtDateParutionJeu" required min="1995-01-01" max="2050-12-31">
                            </td>
                            <td>
                                <input type="number" id="txtPrixJeu" name="txtPrixJeu" size="8" required min="0">
                            </td>
                            <td>
                                <?php afficherListe($db->getLesGenres(), 'lstGenres', 1, 1) ?>
                            </td>
                            <td>
                                <?php afficherListe($db->getLesPlateformes(), 'lstPlateformes', 1, 1) ?>
                            </td>
                            <td>
                                <?php afficherListe($db->getLesPegis(), 'lstPegis', 1, 1) ?>
                            </td>
                            <td>
                                <?php afficherListe($db->getLesMarques(), 'lstMarques', 1, 1) ?>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="ajouterNouveauJeu" title="Enregistrer nouveau Jeu"><i class="fa fa-save"></i></button>
                                <button class="btn btn-info btn-xs" type="reset" title="Effacer la saisie"><i class="fa fa-eraser"></i></button>
                            </td>
                        </form>
                    </tr>
                    <?php
                    foreach ($tbJeux as $jeu) {
                    ?>
                        <tr>

                            <!-- formulaire pour modifier et supprimer les jeux-->
                            <form action="index.php?uc=gererJeux" method="post">
                                <td><?php
                                    if ($jeu->identifiant != $refJeuModif) {
                                        echo $jeu->identifiant;

                                    ?>
                                </td>
                                <td><?php echo $jeu->libelle; ?><input type="hidden" name="txtRefJeu" value="<?php echo $jeu->identifiant; ?>" /></td>
                                <td><?php echo $jeu->dateParution; ?></td>
                                <td><?php echo $jeu->prix; ?></td>
                                <td><?php echo $jeu->genre; ?></td>
                                <td><?php echo $jeu->plateforme; ?></td>
                                <td><?php echo $jeu->pegi; ?></td>
                                <td><?php echo $jeu->marque; ?></td>
                                <td>
                                    <?php if ($notification != 'rien' && $jeu->identifiant == $refJeuNotif) {
                                            echo '<button class="btn btn-success btn-xs"><i class="fa fa-check"></i>' . $notification . '</button>';
                                        } ?>
                                    <button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="demanderModifierJeu" title="Modifier"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger btn-xs" type="submit" name="cmdAction" value="supprimerJeu" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce jeu?');"><i class="fa fa-trash-o "></i></button>
                                <?php
                                    } else {
                                ?>
                                    <input type="text" id="txtRefJeu" name="txtRefJeu" size="16" required minlength="4" maxlength="16" value = "<?php echo $jeu->identifiant; ?>" />
                                </td>
                                <td>
                                    <input type="text" id="txtNomJeu" name="txtNomJeu" size="24" required minlength="4" maxlength="24" value="<?php echo $jeu->libelle; ?>" />
                                </td>
                                <td>
                                    <input type="date" id="txtDateParutionJeu" name="txtDateParutionJeu" required min="1995-01-01" max="2050-12-31" value="<?php echo $jeu->dateParution; ?>" />
                                </td>
                                <td>
                                    <input type="number" id="txtPrixJeu" name="txtPrixJeu" size="8" required value="<?php echo $jeu->prix; ?>" />
                                </td>
                                <td>
                                    <?php afficherListe($db->getLesGenres(), 'lstGenres', 1, $jeu->genre); ?> 
                                </td>
                                <td>
                                    <?php afficherListe($db->getLesPlateformes(), 'lstPlateformes', 1, $jeu->plateforme); ?>
                                </td>
                                <td>
                                    <?php afficherListe($db->getLesPegis(), 'lstPegis', 1, $jeu->pegi); ?>
                                </td>
                                <td>
                                    <?php afficherListe($db->getLesMarques(), 'lstMarques', 1, $jeu->marque); ?>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="validerModifierJeu" title="Enregistrer"><i class="fa fa-save"></i></button>
                                    <button class="btn btn-info btn-xs" type="reset" title="Effacer la saisie"><i class="fa fa-eraser"></i></button>
                                    <button class="btn btn-warning btn-xs" type="submit" name="cmdAction" value="annulerModifierJeu" title="Annuler"><i class="fa fa-undo"></i></button>
                                </td>
                            <?php
                                    }
                            ?>
                            </form>

                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
            </table>

        </div><!-- fin div panel-body-->
    </section><!-- fin section jeux-->
</div>
<!--fin div col-sm-6-->