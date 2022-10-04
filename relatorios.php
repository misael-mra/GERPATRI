<?php
require_once('includes/load.php');

$page_title = 'Relatórios';
// Checkin What level user has permission to view this page
page_require_level(2);

$all_description_asset = find_all('description_assets');
$all_types_itens = find_all('types_itens');
$all_manufacturer = find_all('manufacturers');
$all_situation = find_all('situations');
$all_sector = find_all('sectors');
$all_domain = find_all('domain');

//Display all manufacturers.
if (isset($_POST['submit'])) :
  $a_tombo  = remove_junk($db->escape($_POST['asset-tombo']));
  $a_description_asset  = remove_junk($db->escape($_POST['asset-description']));
  $a_types_item   = remove_junk($db->escape($_POST['asset-types_item']));
  $a_sector  = remove_junk($db->escape($_POST['asset-sector']));
  $a_manufacturer   = remove_junk($db->escape($_POST['asset-manufacturer']));
  $a_situation  = remove_junk($db->escape($_POST['asset-situation']));

  $all_assets = issue_reports($a_tombo, $a_description_asset, $a_types_item, $a_sector, $a_manufacturer, $a_situation);


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
                  <input type="text" class="form-control" name="asset-tombo" placeholder="Tombo">
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <select class="form-control" name="asset-description">
                    <option value="">Todos</option>
                    <?php foreach ($all_description_asset as $desc_asset) : ?>
                      <option value="<?= (int)$desc_asset['id'] ?>">
                        <?= $desc_asset['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="asset-responsible_user" placeholder="Usuário Responsável">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <select id="transfers" class="form-control" name="asset-transfer">
                  <option value="1">Todos Equipamentos</option>
                </select>
              </div>
              <div class="col-md-4">
                <select class="form-control" name="asset-types_item">
                  <option value="">Todos os tipos</option>
                  <?php foreach ($all_types_itens as $t_itens) : ?>
                    <option value="<?= (int)$t_itens['id'] ?>">
                      <?= $t_itens['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <select id="sector" class="form-control" name="asset-sector">
                  <option value="">Todos os setores</option>
                  <?php foreach ($all_sector as $sector) : ?>
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
                <select class="form-control" name="asset-manufacturer">
                  <option value="">Fabricante</option>
                  <?php foreach ($all_manufacturer as $man) : ?>
                    <option value="<?= (int)$man['id'] ?>">
                      <?= $man['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <select class="form-control" name="asset-situation">
                  <option value="">Todas situações</option>
                  <?php foreach ($all_situation as $sit) : ?>
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

<?php if (!empty($all_assets)) : ?>
  <div class="row">
    <div class="col-md-12" style="font-size:12px;">
      <table class="table table-border table-striped datatable-button-active table-hover">
        <thead>
          <tr class="info">
            <th>Tombo</th>
            <th>Descrição</th>
            <th>Setor</th>
            <th>Fabricante</th>
            <th>Situação</th>
            <th>Observação</th>
            <th class="none">Término da Garantia</th>
            <th class="none">Transferido?</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($all_assets as $result) : ?>
            <tr>
              <td><?= remove_junk($result['tombo']); ?></td>
              <td><?= remove_junk($result['descrip_assets']); ?></td>
              <td><?php if (is_null($result['sector'])) : echo "SEM SETOR";
                  else : echo remove_junk($result['sector']);
                  endif; ?></td>
              <td><?= remove_junk($result['manufacturer']); ?></td>
              <td><?= remove_junk($result['situation']); ?></td>
              <td><?= remove_junk($result['obs']); ?></td>
              <td><?php if (is_null($result['warranty'])) : echo "Sem Garantia";
                  else : echo strftime('%d/%m/%Y', strtotime($result['warranty']));
                  endif; ?></td>
              <td><?php if (empty($result['sector'])) : echo "Não";
                  else : echo "Sim";
                  endif; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

<?php
elseif (isset($all_assets)) :
  $output  = "<div class=\"alert alert-danger\">";
  $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
  $output .= "Desculpe, nenhum equipamento encontrado!";
  $output .= "</div>";
  echo $output;
endif;

?>

<?php
//$scripts .= "
	//$('#sector').hide();
	//$('#transfers').change(function(){
	  //if($('#transfers').val() == 2) $('#sector').show();
	 // else $('#sector').hide();
	//});
//"
?>

<?php include_once('layouts/footer.php'); ?>