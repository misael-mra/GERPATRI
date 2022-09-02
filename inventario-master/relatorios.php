<?php
require_once('includes/load.php');

$page_title = 'Relatório de Equipamentos';
// Checkin What level user has permission to view this page
page_require_level(2);

$all_types_equip = find_all('types_equips');
$all_manufacturer = find_all('manufacturers');
$all_situation = find_all('situations');
$all_sector = find_all('sectors');

//Display all manufacturers.
if(isset($_POST['submit'])):
  $equip_tombo  = remove_junk($db->escape($_POST['equipment-tombo']));
  $equip_specifications  = remove_junk($db->escape($_POST['equipment-specifications']));
  $equip_responsible_user  = remove_junk($db->escape($_POST['equipment-responsible_user']));
  $equip_transfer  = remove_junk($db->escape($_POST['equipment-transfer']));      
  $equip_type_equip   = remove_junk($db->escape($_POST['equipment-type_equip']));
  $equip_sector  = remove_junk($db->escape($_POST['equipment-sector']));
  $equip_manufacturer   = remove_junk($db->escape($_POST['equipment-manufacturer']));
  $equip_situation  = remove_junk($db->escape($_POST['equipment-situation']));

  $all_equips = issue_reports($equip_tombo, $equip_specifications, $equip_responsible_user, $equip_transfer, $equip_type_equip, $equip_sector, $equip_manufacturer, $equip_situation);


endif;

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
      <div class="panel-heading clearfix text-center">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Gerar Relatório</span>
        </strong>
      </div>
      <div class="panel-body">
        <form class="clearfix" method="post" action="relatorios.php">
          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="number" class="form-control" name="equipment-tombo" placeholder="Tombo">
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="equipment-specifications" placeholder="Especificações do Equipamento">
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="equipment-responsible_user" placeholder="Usuário Responsável">
                </div>
              </div>                            
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <select id="transfers" class="form-control" name="equipment-transfer">
                  <option value="1">Todos Equipamentos</option>
                  <option value="2">Somente transferidos</option>
                  <option value="3">Somente não transferidos</option>
                </select>
              </div>
              <div class="col-md-4">
                <select class="form-control" name="equipment-type_equip">
                  <option value="">Tipo de Equipamento</option>
                  <?php  foreach ($all_types_equip as $t_equip): ?>
                   <option value="<?= (int)$t_equip['id'] ?>">
                  <?= $t_equip['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <select id="sector" class="form-control" name="equipment-sector">
                  <option value="">Setor</option>
                  <?php  foreach ($all_sector as $sector): ?>
                  <option value="<?= (int)$sector['id'] ?>">
                  <?= $sector['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <select class="form-control" name="equipment-manufacturer">
                  <option value="">Fabricante</option>
                  <?php  foreach ($all_manufacturer as $man): ?>
                  <option value="<?= (int)$man['id'] ?>">
                    <?= $man['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <select class="form-control" name="equipment-situation">
                  <option value="">Situação</option>
                  <?php  foreach ($all_situation as $sit): ?>
                  <option value="<?= (int)$sit['id'] ?>">
                  <?= $sit['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>          

          <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary">Gerar Relatório</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<?php if(!empty($all_equips)): ?>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-border table-striped datatable-button-active">
        <thead>
          <tr class="info">
            <th>#</th>             
            <th>Tombo</th>
            <th>Tipo de Equipamento</th>
            <th>Especificações</th>
            <th>Usuário Responsável</th>              
            <th>Setor</th>
            <th>Fabricante</th>
            <th>Situação</th>
            <th>Observação</th>
            <th class="none">Término da Garantia</th>
            <th class="none">Transferido?</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($all_equips as $result): ?>
            <tr>
              <td><?= count_id(); ?></td>              
              <td><?= remove_junk($result['tombo']);?></td>
              <td><?= remove_junk($result['types_equip']);?></td>              
              <td><?= remove_junk($result['specifications']);?></td>              
              <td><?php if(is_null($result['responsible_user'])): echo "SUINFOR"; else: echo remove_junk($result['responsible_user']); endif; ?></td>
              <td><?php if(is_null($result['sector'])): echo "SEM SETOR"; else: echo remove_junk($result['sector']); endif; ?></td>
              <td><?= remove_junk($result['manufacturer']);?></td>
              <td><?= remove_junk($result['situation']);?></td>
              <td><?= remove_junk($result['obs']);?></td>
              <td><?php if(is_null($result['warranty'])): echo "Sem Garantia"; else: echo strftime('%d/%m/%Y', strtotime($result['warranty'])); endif; ?></td>
              <td><?php if(empty($result['sector'])): echo "Não"; else: echo "Sim"; endif;?></td>
            </tr>
          <?php endforeach; ?>        
        </tbody>
      </table>
    </div>
  </div>

  <?php
elseif(isset($all_equips)):
  $output  = "<div class=\"alert alert-danger\">";
  $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
  $output .= "Desculpe, nenhum equipamento encontrado!";
  $output .= "</div>";
  echo $output;
endif;

?>

<?php
$scripts .= "
	$('#sector').hide();
	$('#transfers').change(function(){
	  if($('#transfers').val() == 2) $('#sector').show();
	  else $('#sector').hide();
	});
"
?>

<?php include_once('layouts/footer.php'); ?>
