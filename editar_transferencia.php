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

$asset = find_by_id('assets', $transfer['asset_id']);
$desc_asset = find_by_id('description_assets', $asset['description_asset_id']);
$resp_user = find_by_id('users', $transfer['created_by']);

if(isset($_POST['update_transfer'])){
  $req_fields = array('tombo','sector','transfer_date');
  if(empty($errors)){
    $a_sector  = $db->escape((int) $_POST['sector']);
    $a_t_date      = $db->escape($_POST['transfer_date']);
    $a_user_update = (int) $_SESSION['user_id'];
    $a_date_update = make_date();

    $sql  = "UPDATE transfers SET";
    $sql .= " sector_id={$a_sector}, transfer_date='{$a_t_date}', updated_by={$a_user_update}, updated_at='{$a_date_update}'";
    $sql .= " WHERE id ='{$transfer['id']}'";
    $result = $db->query($sql);
    if( $result && $db->affected_rows() === 1){
      $session->msg('s','Transferência de tombo '. $asset['tombo'] .' foi alterado com sucesso!');
      redirect('transferencias.php?id='.$transfer['id'], false);
    } else {
      $session->msg('d','Desculpe, falha ao alterar a transferência, entre em contato com NTI-HGWA.');
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
          <a href="transferencias.php" class="btn btn-danger">cancelar</a>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <th> Tombo </th>
            <th> Descrição do bem </th>
            <th> Usuário Responsável </th>
            <th> Setor </th>
            <th> Data da transferência </th>
            <th class="text-center"> Ação</th>
          </thead>
          <tbody  id="asset_info">
            <tr>
              <form method="post" action="editar_transferencia.php?id=<?= (int)$transfer['id']; ?>">
                <td id="e_tombo">
                  <input type="text" class="form-control" id="sug_input" name="tombo" value="<?= remove_junk($asset['tombo']); ?>" disabled>
                </td>
                <td>
                  <input type="text" class="form-control" name="description_asset" value="<?= remove_junk($desc_asset['name']); ?>" disabled>
                </td>
                <td>
                  <input type="text" class="form-control" name="responsible_user" value="<?= remove_junk($resp_user['name']); ?>" disabled>
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
