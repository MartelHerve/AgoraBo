<!-- page start-->
<div class="col-sm-6">
	<section class="panel">
		<div class="chat-room-head">
			<h3><i class="fa fa-angle-right"></i> Gérer les Marques</h3>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-advance table-hover">
				<thead>
					<tr class="tableau-entete">
						<th><i class="fa fa-bullhorn"></i> Identifiant</th>
						<th><i class="fa fa-bookmark"></i> Libellé</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<!-- formulaire pour ajouter un nouveau Marque-->
					<tr>
						<form action="index.php?uc=gererMarques" method="post">
							<td>Nouveau</td>
							<td>
								<input type="text" id="txtNomMarque" name="txtNomMarque" size="24" required minlength="4" maxlength="24" placeholder="Nom de la marque" title="De 4 à 24 caractères" />
							</td>
							<td>
								<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="ajouterNouvelleMarque" title="Enregistrer nouvelle Marque"><i class="fa fa-save"></i></button>
								<button class="btn btn-info btn-xs" type="reset" title="Effacer la saisie"><i class="fa fa-eraser"></i></button>
							</td>
						</form>
					</tr>

					<?php
					foreach ($tbMarques as $Marque) {
					?>
						<tr>

							<!-- formulaire pour modifier et supprimer les Marques-->
							<form action="index.php?uc=gererMarques" method="post">
								<td><?php echo $Marque->identifiant; ?><input type="hidden" name="txtIdMarque" value="<?php echo $Marque->identifiant; ?>" /></td>
								<td><?php
									if ($Marque->identifiant != $idMarqueModif) {
										echo $Marque->libelle;
									?>
								</td>
								<td>
									<?php if ($notification != 'rien' && $Marque->identifiant == $idMarqueNotif) {
											echo '<button class="btn btn-success btn-xs"><i class="fa fa-check"></i>' . $notification . '</button>';
										} ?>
									<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="demanderModifierMarque" title="Modifier"><i class="fa fa-pencil"></i></button>
									<button class="btn btn-danger btn-xs" type="submit" name="cmdAction" value="supprimerMarque" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce Marque?');"><i class="fa fa-trash-o "></i></button>
								</td>
							<?php
									} else {
							?><input type="text" id="txtNomMarque" name="txtNomMarque" size="24" required minlength="4" maxlength="24" value="<?php echo $Marque->libelle; ?>" />
								</td>
								<td>
									<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="validerModifierMarque" title="Enregistrer"><i class="fa fa-save"></i></button>
									<button class="btn btn-info btn-xs" type="reset" title="Effacer la saisie"><i class="fa fa-eraser"></i></button>
									<button class="btn btn-warning btn-xs" type="submit" name="cmdAction" value="annulerModifierMarque" title="Annuler"><i class="fa fa-undo"></i></button>
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
	</section><!-- fin section Marques-->
</div>
<!--fin div col-sm-6-->