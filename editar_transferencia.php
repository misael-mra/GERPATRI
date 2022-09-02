<?php
require_once('includes/load.php');

$page_title = 'Editar Transferência';
// Checkin What level user has permission to view this page
page_require_level(2);

$all_sector = find_all('sectors');

$transfer = find_by_id('transfers',(int)$_GET['id']);
if(!$transfer){
  $session->msg("d","Transferência não encontrada.");
  redirect('transferencias.php');
}

$equipment = find_by_id('equipments',$transfer['equipment_id']);

if(isset($_POST['update_transfer'])){
  $req_fields = array('tombo','sector','responsible_user','transfer_date');
  validate_fields($req_fields);
  if(empty($errors)){
    $e_r_u     = $db->escape($_POST['responsible_user']);
    $e_sector  = $db->escape((int) $_POST['sector']);
    $e_t_date      = $db->escape($_POST['transfer_date']);
    $e_user_update = (int) $_SESSION['user_id'];
    $e_date_update = make_date();

    $sql  = "UPDATE transfers SET";
    $sql .= " responsible_user='{$e_r_u}',sector_id={$e_sector},transfer_date='{$e_t_date}',updated_by={$e_user_update}, updated_at='{$e_date_update}'";
    $sql .= " WHERE id ='{$transfer['id']}'";
    $result = $db->query($sql);
    if( $result && $db->affected_rows() === 1){
      $session->msg('s','Transferência de tombo '. $equipment['tombo'] .' foi alterado com sucesso!');
      redirect('transferencias.php?id='.$transfer['id'], false);
    } else {
      $session->msg('d','Desculpe, falha ao alterar a transferência.');
      redirect('transferencias.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('editar_transferencia.php?id='.(int)$transfer['id'],false);
  }
}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?= display_msg($msg); ?>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Editar Transferência</span>
        </strong>
        <div class="pull-right">
          <a href="transferencias.php" class="btn btn-danger">Listar transferências</a>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <th> Tombo </th>
            <th> Especificações </th>
            <th> Usuário Responsável </th>
            <th> Setor </th>
            <th> Data da transferência </th>
            <th> Ação</th>
          </thead>
          <tbody  id="equipment_info">
            <tr>
              <form method="post" action="editar_transferencia.php?id=<?= (int)$transfer['id']; ?>">
                <td id="e_tombo">
                  <input type="text" class="form-control" id="sug_input" name="tombo" value="<?= remove_junk($equipment['tombo']); ?>" readonly>
                  <div id="result" class="list-group"></div>
                </td>
                <td>
                  <input type="text" class="form-control" name="specifications" value="<?= remove_junk($equipment['specifications']); ?>" readonly>
                </td>
                <td>
                  <input type="text" class="form-control" name="responsible_user" value="<?= remove_junk($transfer['responsible_user']); ?>" required>
                </td>
                <td>
                  <select class="form-control" name="sector" required>
                    <option value="">Selecione o Setor</option>
                    <?php  foreach ($all_sector as $sec): if($sec['id'] == $transfer['sector_id']): ?>
                    <option selected value="<?= (int)$sec['id'] ?>"><?= $sec['name'] ?></option>
                    <?php else: ?>
                    <option value="<?= (int)$sec['id'] ?>"><?= $sec['name'] ?></option>
                    <?php endif; endforeach; ?>
                  </select>
                </td>    
                <td>
                  <input type="date" class="form-control" name="transfer_date" value="<?= remove_junk($transfer['transfer_date']); ?>" required>
                </td>
                <td class="text-center">
                  <button type="submit" name="update_transfer" class="btn btn-primary">Atualizar Transferência</button>
                </td>
              </form>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
