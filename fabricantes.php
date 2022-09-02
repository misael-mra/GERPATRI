<?php
require_once('includes/load.php');

$page_title = 'Todos os fabricantes';
// Checkin What level user has permission to view this page
page_require_level(1);

$all_manufacturers = find_all('manufacturers');

if(isset($_POST['add_manufacturer'])){
  $req_field = array('manufacturer-name');
  validate_fields($req_field);
  $manufacturer_name = remove_junk($db->escape($_POST['manufacturer-name']));
  if(empty($errors)){
    $sql  = "INSERT INTO manufacturers (name)";
    $sql .= " VALUES ('{$manufacturer_name}')";
    if($db->query($sql)){
      $session->msg("s", "Fabricante adicionado com sucesso!");
      redirect('fabricantes.php',false);
    } else {
      $session->msg("d", "Desculpe, falha ao cadastrar o fabricante.");
      redirect('fabricantes.php',false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('fabricantes.php',false);
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
          <span>Adicionar novo fabricante</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="fabricantes.php">
          <div class="form-group">
            <input type="text" class="form-control" name="manufacturer-name" placeholder="Nome do fabricante" required autocomplete="off">
          </div>
          <button type="submit" name="add_manufacturer" class="btn btn-primary">Novo fabricante</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Todos os Fabricantes</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Fabricantes</th>
              <th class="text-center" style="width: 100px;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_manufacturers as $man):?>
              <tr>
                <td class="text-center"><?= count_id();?></td>
                <td><?= remove_junk(ucfirst($man['name'])); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="editar_fabricante.php?id=<?= (int)$man['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>

                    <button title="Remover" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#launchModal-<?= (int)$man['id'];?>">
                      <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <?php $action="deletar_fabricante.php"; $id=(int)$man['id']; include('layouts/modal-confirmacao.php'); ?>
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
