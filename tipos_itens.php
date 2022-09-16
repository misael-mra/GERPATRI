<?php
require_once('includes/load.php');

$page_title = 'Todos os tipos de itens';
// Verifica se o usuário tem permissão de acesso
page_require_level(1);

$all_types_item = find_all('types_itens');

if (isset($_POST['types_item'])) {
	$req_field = array('tipos_itens-name');
	$type_type_item_name = remove_junk($db->escape($_POST['tipos_itens-name']));
	if (empty($errors)) {
		$sql  = "INSERT INTO types_itens (name)";
		$sql .= " VALUES ('{$type_type_item_name}')";
		if ($db->query($sql)) {
			$session->msg("s", "Tipos de item adicionado com sucesso!");
			redirect('tipos_itens.php', false);
		} else {
			$session->msg("d", "Desculpe, falha ao cadastrar o tipo de item.");
			redirect('tipos_itens.php', false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('tipos_itens.php', false);
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
					<span>Cadastrar novo tipo</span>
				</strong>
			</div>
			<div class="panel-body">
				<form method="post" action="tipos_itens.php">
					<div class="form-group">
						<input type="text" class="form-control" name="tipos_itens-name" placeholder="Nova descrição" required autocomplete="off">
					</div>
					<button type="submit" name="types_item" class="btn btn-success">CADASTRAR</button>
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
						<?php foreach ($all_types_item as $t_type_item) : ?>
							<tr>
								<td class="text-center"><?= count_id(); ?></td>
								<td><?= remove_junk(ucfirst($t_type_item['name'])); ?></td>
								<td class="text-center">
									<div class="btn-group">
										<a href="editar_tipos_itens.php?id=<?= (int)$t_type_item['id']; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
											<span class="glyphicon glyphicon-edit" style="width: 22px;"></span>
										</a>

										<button title="Remover" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#launchModal-<?= (int)$t_type_item['id']; ?>">
											<i class="glyphicon glyphicon-remove" style="width: 22px;"></i>
										</button>
										<?php $action = "deletar_tipos_itens.php";
										$id = (int)$t_type_item['id'];
										include('layouts/modal-confirmacao.php'); ?>
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

<?php include_once('layouts/footer.php'); ?>