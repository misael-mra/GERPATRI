<?php ob_start();
$page_title = 'Histórico de Transferências';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);

$transfers = find_all_transfer_history();

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
          <span>Histórico de Transferências</span>
        </strong>          
      </div>
      <div class="panel-body">
        <table class="table table-bordered datatable-active">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>                
              <th> Tombo</th>
              <th> Especificações </th>
              <th class="text-center" style="width: 10%;"> Setor </th>
              <th class="text-center" style="width: 10%;"> Usuário Responsável </th>
              <th class="text-center" style="width: 10%;"> Data da transferência </th>
              <th class="text-center" style="width: 10%;"> Recebido por </th>
              <th class="text-center" style="width: 10%;"> Recebido em </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($transfers as $transfer):?>
              <tr>
                <td class="text-center"><?= count_id();?></td>
                <td class="text-center"><?= remove_junk($transfer['tombo']); ?></td>
                <td><?= remove_junk($transfer['specifications']); ?></td>
                <td class="text-center"><?= remove_junk($transfer['sector']); ?></td>                
                <td class="text-center"><?= remove_junk($transfer['responsible_user']); ?></td>                
                <td class="text-center"><?= remove_junk($transfer['transfer_date']); ?></td>                
                <td class="text-center"><?= remove_junk($transfer['create_user']); ?></td>                
                <td class="text-center"><?= remove_junk($transfer['created_at']); ?></td>                
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
