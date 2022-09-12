<?php
require_once('includes/load.php');

$page_title = 'Adicionar item';
// Verifica se o usuário tem permissões
page_require_level(2);
$all_types_equip = find_all('types_equips');
$all_manufacturer = find_all('manufacturers');
$all_situation = find_all('situations');
$all_sector = find_all('sectors');
                
?>
<?php
if (isset($_POST['add_equipment'])) {
	$req_fields = array('equipment-tombo', 'equipment-specifications', 'equipment-obs', 'equipment-type_equip', 'equipment-manufacturer', 'equipment-situation', 'equipment-model', 'equipment-number_serial');
	validate_fields($req_fields);
	if (empty($errors)) {
		$equip_tombo  = remove_junk($db->escape($_POST['equipment-tombo']));
		$equip_specifications  = remove_junk($db->escape($_POST['equipment-specifications']));
		$equip_obs  = remove_junk($db->escape($_POST['equipment-obs']));
		$equip_type_equip   = remove_junk($db->escape($_POST['equipment-type_equip']));
		$equip_manufacturer   = remove_junk($db->escape($_POST['equipment-manufacturer']));
		$equip_situation  = remove_junk($db->escape($_POST['equipment-situation']));
		$equip_model	= remove_junk($db->escape($_POST['equipment-model']));
		$equip_number_serial	= remove_junk($db->escape($_POST['equipment-number_serial']));
		$equip_warranty  = remove_junk($db->escape($_POST['equipment-warranty']));
		$equip_created_by    = (int) $_SESSION['user_id'];
		$equip_created_at    = make_date();

		if (validate_tombo($equip_tombo)) {
			$session->msg('d', "Desculpe, Já existe um equipamento com o tombo $equip_tombo");
			redirect('adicionar_equipamento.php', false);
		}

		$query  = "INSERT INTO equipments (";
		$query .= " tombo, specifications, obs, types_equip_id, manufacturer_id, situation_id, model, number_serial, warranty, created_by, created_at";
		$query .= ") VALUES (";
		$query .= " '{$equip_tombo}', '{$equip_specifications}', '{$equip_obs}', '{$equip_type_equip}', '{$equip_manufacturer}', '{$equip_situation}', '{$equip_model}', '{$equip_number_serial}',";
		if (empty($equip_warranty)) $query  .= " NULL,";
		else $query .= " '{$equip_warranty}',";
		$query .= " '{$equip_created_by}','{$equip_created_at}'";
		$query .= ")";

		if ($db->query($query)) {
			$session->msg('s', "Equipamento adicionado com sucesso! ");
			redirect('adicionar_equipamento.php', false);
		} else {
			$session->msg('d', 'Desculpe, falha ao cadastrar o equipamento, tente novamente.');
			redirect('equipamentos.php', false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('adicionar_equipamento.php', false);
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
					<a href="equipamentos.php" class="btn btn-danger">voltar</a>
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<form method="post" action="adicionar_equipamento.php" class="clearfix">
						<div class="form-group">
							<!--campos principais do formulário-->
							<div class="row">
								<div class="col-md-2">
									<span class="input-group-addon">
										<b>Tombo</b>
									</span>
									<div class="input-group">
										<input type="number" class="form-control" name="equipment-tombo" placeholder="Nº Tombo *" required autocomplete="off">
									</div>
								</div>
								<div class="col-md-10">
									<span class="input-group-addon">
										<b>Descrição do item</b>
									</span>
									<select class="form-control" name="equipment-type_equip" required>
										<option value="">Selecione o item *</option>
										<?php foreach ($all_types_equip as $t_equip) : ?>
											<option value="<?= (int)$t_equip['id'] ?>">
												<?= $t_equip['name'] ?></option>
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
									<select class="form-control" name="equipment-situation" required>
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
										<input type="text" class="form-control" name="equipment-local" placeholder="Localização" autocomplete="off">
									</div>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Fabricante</b>
									</span>
									<select class="form-control" name="equipment-manufacturer">
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
									<select class="form-control" name="equipment-situation" required>
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
										<input type="text" class="form-control" name="equipment-model" placeholder="Modelo" autocomplete="off">
									</div>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Nº de Série</b>
									</span>
									<div class="input-group">
										<input type="text" class="form-control" name="equipment-number_serial" placeholder="Número de Série" autocomplete="off">
									</div>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Nota Fiscal</b>
									</span>
									<div class="input-group">
										<input type="text" class="form-control" name="equipment-specifications" placeholder="Nº NF" autocomplete="off">
									</div>
								</div>
								<div class="col-md-3">
									<span class="input-group-addon">
										<b>Valor</b>
									</span>
									<div class="input-group">
										<input type="text" class="form-control" name="equipment-specifications" placeholder="R$ 0,00 (Opcional)" autocomplete="off">
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
										<input type="text" class="form-control" name="equipment-obs" placeholder="Observações (Opcional)" autocomplete="off">
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
									<input type="date" class="form-control" name="equipment-warranty">
									<span style="font-weight: bold; font-size:13.2px;"> * se não houver, deixar em branco.</span>
								</div>
							</div>
						</div>
						<button type="submit" name="add_equipment" class="btn btn-success">CADASTRAR ITEM</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('layouts/footer.php'); ?>