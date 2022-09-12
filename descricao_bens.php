<?php
require_once('includes/load.php');

$page_title = 'Todos os tipos de itens';
// Verifica se o usuário tem permissão de acesso
page_require_level(1);

$all_description_assets = find_all('description_assets');

if(isset($_POST['description_assets'])){
	$req_field = array('descricao_bens-name');
	validate_fields($req_field);
	$type_equip_name = remove_junk($db->escape($_POST['descricao_bens-name']));
	if(empty($errors)){
		$sql  = "INSERT INTO description_assets (name)";
		$sql .= " VALUES ('{$type_equip_name}')";
		if($db->query($sql)){
			$session->msg("s", "Tipos de item adicionado com sucesso!");
			redirect('descricao_bens.php',false);
		} else {
			$session->msg("d", "Desculpe, falha ao cadastrar o tipo de item.");
			redirect('descricao_bens.php',false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('descricao_bens.php',false);
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
	<div class="col-md-5">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong>
					<span class="glyphicon glyphicon-th"></span>
					<span>Cadastrar nova descrição - nomeclatura</span>
				</strong>
			</div>
			<div class="panel-body">
				<form method="post" action="descricao_bens.php">
					<div class="form-group">
						<input type="text" class="form-control" name="descricao_bens-name" placeholder="Nova descrição" required autocomplete="off">
					</div>
					<button type="submit" name="description_assets" class="btn btn-success">CADASTRAR</button>
					<br><br>
					<div style="background-color: #f1f2f7; font-size:12px; padding: 15px; border-radius: 8px;">
					<span>Padrão:<br> - NOME, TIPO, MATERIAL E COR.<br> - TUDO EM CAIXA ALTA.<br> - Nº SEM O ZERO NA FRENTE.<br><br>Preposicçoes padrão: <br> - DE e COM. <br><br> Exemplo:<br> ARMÁRIO DE AÇO COM 2 PORTAS CINZA E AZUL</span><br>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong>
					<span class="glyphicon glyphicon-th"></span>
					<span>Todos os registros</span>
				</strong>
			</div>
			<div class="panel-body" id="panel-body-list">
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th class="text-center" style="width: 60px;">#</th>
							<th>Todos os Itens</th>
							<th class="text-center" style="width: 100px;">Ações</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($all_description_assets as $t_equip):?>
							<tr>
								<td class="text-center"><?= count_id();?></td>
								<td><?= remove_junk(ucfirst($t_equip['name'])); ?></td>
								<td class="text-center">
									<div class="btn-group">
										<a href="editar_descricao_bens.php?id=<?= (int)$t_equip['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
											<span class="glyphicon glyphicon-edit" style="width: 22px;"></span>
										</a>

										<button title="Remover" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#launchModal-<?= (int)$t_equip['id'];?>">
											<i class="glyphicon glyphicon-remove" style="width: 22px;"></i>
										</button>
										<?php $action="deletar_descricao_bens.php"; $id=(int)$t_equip['id']; include('layouts/modal-confirmacao.php'); ?>
									</div>
								</td>

							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>

<?php include_once('layouts/footer.php'); ?>
