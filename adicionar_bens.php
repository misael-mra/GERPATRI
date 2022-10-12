<?php
require_once('includes/load.php');

$page_title = 'Adicionar bem';
// Verifica se o usuário tem permissões de acesso a pagina
page_require_level(2);

$all_description_asset = find_all('description_assets');
$all_types_item = find_all('types_itens');
$all_manufacturer = find_all('manufacturers');
$all_situation = find_all('situations');
$all_sector = find_all('sectors');

?>
<?php
if (isset($_POST['add_asset'])) {
	$req_fields = array(
		'asset-tombo', 'asset-domain', 'asset-description', 'asset-type_item', 'asset-sector', 'asset-localization', 'asset-manufacturer',
		'asset-situation', 'asset-provider', 'asset-number_nf', 'asset-date_aquisition', 'asset-value', 'asset-number_serial', 'asset-obs'
	);
	if (empty($errors)) {
		$a_tombo = remove_junk($db->escape($_POST['asset-tombo']));
		$a_domain = remove_junk($db->escape($_POST['asset-domain']));
		$a_description = remove_junk($db->escape($_POST['asset-description']));
		$a_type_item = remove_junk($db->escape($_POST['asset-type_item']));
		$a_sector = remove_junk($db->escape($_POST['asset-sector']));
		$a_localization = remove_junk($db->escape($_POST['asset-localization']));
		$a_manufacturer = remove_junk($db->escape($_POST['asset-manufacturer']));
		$a_situation = remove_junk($db->escape($_POST['asset-situation']));
		$a_provider   = remove_junk($db->escape($_POST['asset-provider']));
		$a_number_nf = remove_junk($db->escape($_POST['asset-number_nf']));
		$a_date_aquisition = remove_junk($db->escape($_POST['asset-date_aquisition']));
		$a_value = remove_junk($db->escape($_POST['asset-value']));
		$a_number_serial = remove_junk($db->escape($_POST['asset-number_serial']));
		$a_obs = remove_junk($db->escape($_POST['asset-obs']));
		$a_warranty = remove_junk($db->escape($_POST['asset-warranty']));
		$a_created_by = (int) $_SESSION['user_id'];
		$a_created_at = make_date();

		if (validate_tombo($a_tombo)) {
			$session->msg('d', "Desculpe, Já existe um bem registrado com o tombo $a_tombo");
			redirect('adicionar_bens.php', false);
		}

		$query  = "INSERT INTO assets (";
		$query .= " tombo, domain_id, description_asset_id, types_item_id, sector_id, localization, manufacturer_id, situation_id, provider, number_nf,date_aquisition,value,number_serial,obs,warranty, created_by, created_at";
		$query .= ") VALUES (";
		$query .= " '{$a_tombo}', '{$a_domain}', '{$a_description}', '{$a_type_item}', '{$a_sector}', '{$a_localization}', '{$a_manufacturer}', '{$a_situation}', '{$a_provider}', '{$a_number_nf}',
		 '{$a_date_aquisition}', '{$a_value}', '{$a_number_serial}', '{$a_obs}',";
		if (empty($a_warranty)) $query  .= " NULL,";
		else $query .= " '{$a_warranty}',";
		$query .= " '{$a_created_by}','{$a_created_at}'";
		$query .= ")";

		if ($db->query($query)) {
			$session->msg('s', "Bem adicionado com sucesso! ");
			redirect('adicionar_bens.php', false);
		} else {
			$session->msg('d', 'Desculpe, falha ao cadastrar o bem, tente novamente.');
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
					<span>Preencha os campos abaixo:</span>
				</strong>
				<div class="pull-right">
					<a href="bens.php" class="btn btn-danger">cancelar</a>
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
										<b>Tombo<span class="required-tag"> *</span></b>
									</span>
									<div class="input-group">
										<input type="text" class="form-control" name="asset-tombo" placeholder="Nº Tombo" required autocomplete="off">
									</div>
								</div>
								<div class="col-md-2 text-center">
									<span class="input-group-addon">
										<b>Unidade de Domínio<span class="required-tag"> *</span></b>
									</span>
									<div class="form-check form-check-inline" style="margin-top:6px;font-size:14px;">
										<input class="form-check-input" type="radio" name="asset-domain" value="1" id="asset-domain1" checked>
										<label class="form-check-label" for="asset-domain1">
											ISGH
										</label>
										<input class="form-check-input" type="radio" name="asset-domain" value="2" id="asset-domain2" style="margin-left:15%;margin-top: 6px;">
										<label class="form-check-label" for="asset-domain2">
											SESA
										</label>
									</div>
								</div>
								<div class="col-md-8">
									<span class="input-group-addon">
										<b>Descrição do bem<span class="required-tag"> *</span></b>
									</span>
									<select class="form-control" name="asset-description" required>
										<option value="">Selecione</option>
										<?php foreach ($all_description_asset as $descr_asset) : ?>
											<option value="<?= (int)$descr_asset['id'] ?>">
												<?= $descr_asset['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<span class="input-group-addon">
										<b>Tipo<span class="required-tag"> *</span></b>
									</span>
									<select class="form-control" name="asset-type_item" required>
										<option value="">Selecione</option>
										<?php foreach ($all_types_item as $t_type_item) : ?>
											<option value="<?= (int)$t_type_item['id'] ?>">
												<?= $t_type_item['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-4">
									<span class="input-group-addon">
										<b>Setor<span class="required-tag"> *</span></b>
									</span>
									<select class="form-control" name="asset-sector" required>
										<option value="">Selecione</option>
										<?php foreach ($all_sector as $sector) : ?>
											<option value="<?= (int)$sector['id'] ?>">
												<?= $sector['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-4">
									<span class="input-group-addon">
										<b>Localização<span class="required-tag"> *</span></b>
									</span>
									<div class="input-group">
										<input type="text" class="form-control" name="asset-localization" placeholder="Exemplo: Sala 01" autocomplete="off" required>
									</div>
								</div>
							</div>
						</div>
						<!--Campos Adicionais-->
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Fabricante | Marca</b>
									</span>
									<select class="form-control" name="asset-manufacturer">
										<option value="">Selecione</option>
										<?php foreach ($all_manufacturer as $man) : ?>
											<option value="<?= (int)$man['id'] ?>">
												<?= $man['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Situação Atual<span class="required-tag"> *</span></b>
									</span>
									<select class="form-control" name="asset-situation" required>
										<option value="">Selecione</option>
										<?php foreach ($all_situation as $sit) : ?>
											<option value="<?= (int)$sit['id'] ?>">
												<?= $sit['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Fornecedor</b>
									</span>
									<div class="input-group">
										<input type="text" class="form-control" name="asset-provider" placeholder="Fornecedor" autocomplete="off">
									</div>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Data de Aquisição</b>
									</span>
									<div class="input-group">
										<input type="date" class="form-control" name="asset-date_aquisition">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Nota Fiscal</b>
									</span>
									<div class="input-group">
										<input type="text" class="form-control" name="asset-number_nf" placeholder="Nº Nota fiscal" autocomplete="off">
									</div>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Valor</b>
									</span>
									<div class="input-group">
									<span class="input-group-addon">
									<b>R$</b>
									</span>
										<input type="text" class="form-control" name="asset-value" id="currency" placeholder="R$ 0,00 (Opcional)" autocomplete="off" onkeyup="formatCurrency();">
									</div>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Nº de Série</b>
									</span>
									<div class="input-group">
										<input type="text" class="form-control" name="asset-number_serial" placeholder="Número de Série" autocomplete="off">
									</div>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-calendar"></i> <b>Término da Garantia</b>
									</span>
									<input type="date" class="form-control" name="asset-warranty">
									<span style="font-weight: bold; font-size:13px;"> * se não houver, deixar em branco.</span>
								</div>
							</div>
						</div>
						<!--Observações-->
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<span class="input-group-addon">
										<b>Observações</b>
									</span>
									<div class="input-group">
										<textarea type="text" class="form-control" style="height: 100px" name="asset-obs" placeholder="Observações (Opcional)" autocomplete="off"></textarea>
									</div>
								</div>
							</div>
						</div>
						<button type="submit" name="add_asset" class="btn btn-success">FINALIZAR CADASTRO</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('layouts/footer.php'); ?>