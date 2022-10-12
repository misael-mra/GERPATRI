<?php
require_once('includes/load.php');

$page_title = 'Realizar baixa';
// Checkin What level user has permission to view this page
page_require_level(2);
?>
<?php

if(isset($_POST['add_asset_off'])){
  $req_fields = array('a_id','sector','responsible_user','transfer_date');
  if(empty($errors)){
    $a_id      = $db->escape((int) $_POST['a_id']);
    $a_r_u     = (int) $_SESSION['responsible_user'];
    $a_sector  = $db->escape((int) $_POST['sector']);
    $a_t_date      = $db->escape($_POST['transfer_date']);
    $a_user_create = (int) $_SESSION['user_id'];
    $a_date_create = make_date();

    $sql  = "INSERT INTO transfer_asset_off (";
    $sql .= " asset_id, responsible_user, sector_id, transfer_date, created_by, created_at";
    $sql .= ") VALUES (";
    $sql .= "'{$a_id}','{$a_r_u}','{$a_sector}','{$a_t_date}','{$a_user_create}','{$a_date_create}'";
    $sql .= ")";

    if($db->query($sql)){
      $session->msg('s',"Baixa patrimonial realizada com sucesso!");
      redirect('adicionar_baixa.php', false);
    } else {
      $session->msg('d','Desculpe, falha ao realizar a baixa patrimonial');
      redirect('adicionar_baixa.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('adicionar_baixa.php',false);
  }
}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-3">
    <?= display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
      <div class="form-group">
        <div class="input-group">
          <input type="text" id="sug_input" class="form-control" name="tombo"  placeholder="Informe o nº tombo">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-primary">Buscar</button>
          </span>            
        </div>
        <div id="result" class="list-group"></div>
      </div>
    </form>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong style="font-size:16px;">
          <span class="glyphicon glyphicon-download-alt"></span>
          <span>Realizar baixa patrimonial</span>
        </strong>
        <div class="pull-right">
          <a href="bens_baixados.php" class="btn btn-danger">cancelar</a>
        </div>
      </div>
      <div class="panel-body">
        <form method="post" action="adicionar_baixa.php">
          <table class="table table-bordered">
            <thead>
              <th class="text-center"> Tombo</th>
              <th> Descrição do bem</th>
              <th> Responsável pela Baixa</th>
              <th> Unidade de destino</th>
              <th class="text-center"> Data da Baixa</th>
              <th class="text-center"> Ação</th>
            </thead>
            <tbody  id="asset_info"> </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
