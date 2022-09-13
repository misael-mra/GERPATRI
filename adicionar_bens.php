<?php
require_once('includes/load.php');

$page_title = 'Adicionar item';
// Verifica se o usuário tem permissões
page_require_level(2);

$all_description_asset = find_all('description_assets');
$all_types_item = find_all('types_itens');
$all_manufacturer = find_all('manufacturers');
$all_situation = find_all('situations');
$all_sector = find_all('sectors');
                
?>
<?php
if (isset($_POST['add_assets'])) {
	$req_fields = array('assets-tombo', 'assets-specifications', 'assets-obs', 'assets-type_item', 'assets-manufacturer', 'assets-situation', 'assets-model', 'assets-number_serial');
	validate_fields($req_fields);
	if (empty($errors)) {
		$asset_tombo  = remove_junk($db->escape($_POST['assets-tombo']));
		$asset_specifications  = remove_junk($db->escape($_POST['assets-specifications']));
		$asset_obs  = remove_junk($db->escape($_POST['assets-obs']));
		$asset_type_item   = remove_junk($db->escape($_POST['assets-type_item']));
		$asset_manufacturer   = remove_junk($db->escape($_POST['assets-manufacturer']));
		$asset_situation  = remove_junk($db->escape($_POST['assets-situation']));
		$asset_model	= remove_junk($db->escape($_POST['assets-model']));
		$asset_number_serial	= remove_junk($db->escape($_POST['assets-number_serial']));
		$asset_warranty  = remove_junk($db->escape($_POST['assets-warranty']));
		$asset_created_by    = (int) $_SESSION['user_id'];
		$asset_created_at    = make_date();

		if (validate_tombo($asset_tombo)) {
			$session->msg('d', "Desculpe, Já existe um assetamento com o tombo $asset_tombo");
			redirect('adicionar_bens.php', false);
		}

		$query  = "INSERT INTO assets (";
		$query .= " tombo, specifications, obs, types_item_id, manufacturer_id, situation_id, model, number_serial, warranty, created_by, created_at";
		$query .= ") VALUES (";
		$query .= " '{$asset_tombo}', '{$asset_specifications}', '{$asset_obs}', '{$asset_type_item}', '{$asset_manufacturer}', '{$asset_situation}', '{$asset_model}', '{$asset_number_serial}',";
		if (empty($asset_warranty)) $query  .= " NULL,";
		else $query .= " '{$asset_warranty}',";
		$query .= " '{$asset_created_by}','{$asset_created_at}'";
		$query .= ")";

		if ($db->query($query)) {
			$session->msg('s', "assetamento adicionado com sucesso! ");
			redirect('adicionar_bens.php', false);
		} else {
			$session->msg('d', 'Desculpe, falha ao cadastrar o assetamento, tente novamente.');
			redirect('bens.php', false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('adicionar_bens.php', false);
	}
}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
	<div class="col-md-12">
		<?= display_msg($msg); ?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<strong>
					<span class="glyphicon glyphicon-th"></span>
					<span>Adicionar Novo Item</span>
				</strong>
				<div class="pull-right">
					<a href="bens.php" class="btn btn-danger">voltar</a>
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<form method="post" action="adicionar_bens.php" class="clearfix">
						<div class="form-group">
							<!--campos principais do formulário-->
							<div class="row">
								<div class="col-md-2">
									<span class="input-group-addon">
										<b>Tombo</b>
									</span>
									<div class="input-group">
										<input type="number" class="form-control" name="assets-tombo" placeholder="Nº Tombo *" required autocomplete="off">
									</div>
								</div>
								<div class="col-md-7">
									<span class="input-group-addon">
										<b>Descrição do bem</b>
									</span>
									<select class="form-control" name="assets-type_item" required>
										<option value="">Selecione um item *</option>
										<?php foreach ($all_description_asset as $t_descr_asset) : ?>
											<option value="<?= (int)$t_descr_asset['id'] ?>">
												<?= $t_descr_asset['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Tipo</b>
									</span>
									<select class="form-control" name="assets-type_item" required>
										<option value="">Selecione *</option>
										<?php foreach ($all_types_item as $t_type_item) : ?>
											<option value="<?= (int)$t_type_item['id'] ?>">
												<?= $t_type_item['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Setor</b>
									</span>
									<select class="form-control" name="assets-situation" required>
										<option value="">Selecione o setor *</option>
										<?php foreach ($all_sector as $sector) : ?>
											<option value="<?= (int)$sector['id'] ?>">
												<?= $sector['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Localização</b>
									</span>
									<div class="input-group">
										<input type="text" class="form-control" name="assets-local" placeholder="Localização" autocomplete="off">
									</div>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Fabricante</b>
									</span>
									<select class="form-control" name="assets-manufacturer">
										<option value="">Selecione o fabricante</option>
										<?php foreach ($all_manufacturer as $man) : ?>
											<option value="<?= (int)$man['id'] ?>">
												<?= $man['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Status</b>
									</span>
									<select class="form-control" name="assets-situation" required>
										<option value="">Selecione o status*</option>
										<?php foreach ($all_situation as $sit) : ?>
											<option value="<?= (int)$sit['id'] ?>">
												<?= $sit['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<!--Campos Adicionais-->
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Modelo</b>
									</span>
									<div class="input-group">
										<input type="text" class="form-control" name="assets-model" placeholder="Modelo" autocomplete="off">
									</div>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Nº de Série</b>
									</span>
									<div class="input-group">
										<input type="text" class="form-control" name="assets-number_serial" placeholder="Número de Série" autocomplete="off">
									</div>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Nota Fiscal</b>
									</span>
									<div class="input-group">
										<input type="text" class="form-control" name="assets-specifications" placeholder="Nº NF" autocomplete="off">
									</div>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Valor</b>
									</span>
									<div class="input-group">
										<input type="text" class="form-control" name="assets-specifications" placeholder="R$ 0,00 (Opcional)" autocomplete="off">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<span class="input-group-addon">
										<b>Observações</b>
									</span>
									<div class="input-group">
										<input type="text" class="form-control" name="assets-obs" placeholder="Observações (Opcional)" autocomplete="off">
									</div>
								</div>
							</div>
						</div>
						<!--Garantia-->
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-calendar"></i> <b>Término da Garantia</b>
									</span>
									<input type="date" class="form-control" name="assets-warranty">
									<span style="font-weight: bold; font-size:13.2px;"> * se não houver, deixar em branco.</span>
								</div>
							</div>
						</div>
						<button type="submit" name="add_assets" class="btn btn-success">CADASTRAR ITEM</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('layouts/footer.php'); ?>