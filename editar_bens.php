<?php
require_once('includes/load.php');

$page_title = 'Editar bem';
// Checkin What level user has permission to view this page
page_require_level(1);

$asset = find_by_id('assets', (int)$_GET['id']);
$all_description_asset = find_all('description_assets');
$all_types_item = find_all('types_itens');
$all_manufacturer = find_all('manufacturers');
$all_situation = find_all('situations');
$all_sector = find_all('sectors');

if (!$asset) {
  $session->msg("d", "Bem não encontrado!");
  redirect('bens.php');
}

if (isset($_POST['update_asset'])) {
  $req_fields = array('asset-description', 'asset-type_item', 'asset-localization','asset-manufacturer', 'asset-situation', 'asset-provider', 'asset-date_aquisition','asset-number_nf','asset-value','asset-number_serial','asset-obs');

  if (empty($errors)) {
    $a_description  = remove_junk($db->escape($_POST['asset-description']));
    $a_types_item   = remove_junk($db->escape($_POST['asset-type_item']));
    $a_localization  = remove_junk($db->escape($_POST['asset-localization']));
    $a_manufacturer   = remove_junk($db->escape($_POST['asset-manufacturer']));
    $a_situation  = remove_junk($db->escape($_POST['asset-situation']));
    $a_provider  = remove_junk($db->escape($_POST['asset-provider']));
    $a_date_aquisition  = remove_junk($db->escape($_POST['asset-date_aquisition']));
    $a_number_nf = remove_junk($db->escape($_POST['asset-number_nf']));
    $a_value = remove_junk($db->escape($_POST['asset-value']));
    $a_number_serial = remove_junk($db->escape($_POST['asset-number_serial']));
    $a_obs  = remove_junk($db->escape($_POST['asset-obs']));
    $a_updated_by    = (int) $_SESSION['user_id'];
    $a_updated_at    = make_date();

    $query   = "UPDATE assets SET";
    $query  .= " description_asset_id ='{$a_description}', types_item_id ='{$a_types_item}', localization ='{$a_localization}',";
    $query  .= " manufacturer_id ='{$a_manufacturer}', situation_id='{$a_situation}', provider='{$a_provider}',";
    $query  .= " date_aquisition='{$a_date_aquisition}', number_nf='{$a_number_nf}', value='{$a_value}', number_serial='{$a_number_serial}', obs ='{$a_obs}', updated_by='{$a_updated_by}', updated_at='{$a_updated_at}'";
    $query  .= " WHERE id ='{$asset['id']}'";
    $result = $db->query($query);
    if ($result && $db->affected_rows() === 1) {
      $session->msg('s', 'O bem de tombo ' . $asset['tombo'] . ' foi alterado com sucesso!');
      redirect('bens.php', false);
    } else {
      $session->msg('d', 'Desculpe, falha ao alterar o bem de tombo ' . $asset['tombo']);
      redirect('editar_bens.php?id=' . $asset['id'], false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('editar_bens.php?id=' . $asset['id'], false);
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
          <span>Editar bem</span>
        </strong>
        <div class="pull-right">
          <a href="bens.php" class="btn btn-danger">CANCELAR</a>
        </div>
      </div>
      <div class="panel-body">
        <div class="col-md-12">
          <form method="post" action="editar_bens.php?id=<?= (int)$asset['id'] ?>" class="clearfix">
            <div class="form-group">
              <!--campos principais do formulário-->
              <div class="row">
                <div class="col-md-2">
                  <span class="input-group-addon">
                    <b>Tombo</b>
                  </span>
                  <div class="input-group">
                    <input type="text" class="form-control" name="asset-tombo" value="<?= (int)$asset['tombo'] ?>" disabled>
                  </div>
                </div>
                <div class="col-md-7">
                  <span class="input-group-addon">
                    <b>Descrição do bem</b>
                  </span>
                  <select class="form-control" name="asset-description">
                    <option value="">Selecione</option>
                    <?php foreach ($all_description_asset as $desc_asset) : if ($desc_asset['id'] == $asset['description_asset_id']) : ?>
                        <option selected value="<?= (int)$desc_asset['id'] ?>"><?= $desc_asset['name'] ?></option>
                      <?php else : ?>
                        <option value="<?= (int)$desc_asset['id'] ?>"><?= $desc_asset['name'] ?></option>
                    <?php endif;
                    endforeach; ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <span class="input-group-addon">
                    <b>Tipo</b>
                  </span>
                  <select class="form-control" name="asset-type_item">
                    <option value="">Selecione</option>
                    <?php foreach ($all_types_item as $t_item) : if ($t_item['id'] == $asset['types_item_id']) : ?>
                        <option selected value="<?= (int)$t_item['id'] ?>"><?= $t_item['name'] ?></option>
                      <?php else : ?>
                        <option value="<?= (int)$t_item['id'] ?>"><?= $t_item['name'] ?></option>
                    <?php endif;
                    endforeach; ?>
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
                  <select class="form-control" name="asset-sector" disabled>
                    <option selected value="<?= (int)$sector['id'] ?>"><?= $sector['name'] ?>Selecione</option>
                    <?php foreach ($all_sector as $sector) : if ($sector['id'] == $asset['sector_id']) : ?>
                        <option selected value="<?= (int)$sector['id'] ?>"><?= $sector['name'] ?></option>
                      <?php else : ?>
                        <option value="<?= (int)$sector['id'] ?>"><?= $sector['name'] ?></option>
                    <?php endif;
                    endforeach; ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <span class="input-group-addon">
                    <b>Localização</b>
                  </span>
                  <div class="input-group">
                    <input type="text" class="form-control" name="asset-localization" placeholder="Localização" value="<?=$asset['localization'] ?>" autocomplete="off">
                  </div>
                </div>
                <div class="col-md-3">
                  <span class="input-group-addon">
                    <b>Fabricante/Marca</b>
                  </span>
                  <select class="form-control" name="asset-manufacturer">
                    <option selected value="<?= (int)$man['id'] ?>"><?= $man['name'] ?>Selecione</option>
                    <?php foreach ($all_manufacturer as $man) : if ($man['id'] == $asset['manufacturer_id']) : ?>
                        <option selected value="<?= (int)$man['id'] ?>"><?= $man['name'] ?></option>
                      <?php else : ?>
                        <option value="<?= (int)$man['id'] ?>"><?= $man['name'] ?></option>
                    <?php endif;
                    endforeach; ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <span class="input-group-addon">
                    <b>Situação Atual</b>
                  </span>
                  <select class="form-control" name="asset-situation">
                    <option selected value="<?= (int)$sit['id'] ?>"><?= $sit['name'] ?>Selecione</option>
                    <?php foreach ($all_situation as $sit) : if ($sit['id'] == $asset['situation_id']) : ?>
                        <option selected value="<?= (int)$sit['id'] ?>"><?= $sit['name'] ?></option>
                      <?php else : ?>
                        <option value="<?= (int)$sit['id'] ?>"><?= $sit['name'] ?></option>
                    <?php endif;
                    endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
            <!--Campos Adicionais-->
            <div class="form-group">
              <div class="row">
                <div class="col-md-3">
                  <span class="input-group-addon">
                    <b>Fornecedor</b>
                  </span>
                  <div class="input-group">
                  <input type="text" class="form-control" name="asset-provider" placeholder="Localização" value="<?=$asset['provider'] ?>" autocomplete="off">
                  </div>
                </div>
                <div class="col-md-3">
                  <span class="input-group-addon">
                    <b>Data de Aquisição</b>
                  </span>
                  <div class="input-group">
                    <input type="date" class="form-control" name="asset-date_aquisition" value="<?=$asset['date_aquisition']?>">
                  </div>
                </div>
                <div class="col-md-3">
                  <span class="input-group-addon">
                    <b>Nota Fiscal</b>
                  </span>
                  <div class="input-group">
                    <input type="text" class="form-control" name="asset-number_nf" placeholder="Nº Nota fiscal" value="<?=$asset['number_nf']?>" autocomplete="off">
                  </div>
                </div>
                <div class="col-md-3">
                  <span class="input-group-addon">
                    <b>Valor</b>
                  </span>
                  <div class="input-group">
                    <input type="text" class="form-control" name="asset-value" placeholder="R$ 0,00 (Opcional)" value="<?=$asset['value']?>" autocomplete="off">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-3">
                  <span class="input-group-addon">
                    <b>Nº de Série</b>
                  </span>
                  <div class="input-group">
                    <input type="text" class="form-control" name="asset-number_serial" placeholder="Número de Série" value="<?=$asset['number_serial']?>" autocomplete="off">
                  </div>
                </div>
                <div class="col-md-9">
                  <span class="input-group-addon">
                    <b>Observações</b>
                  </span>
                  <div class="input-group">
                    <input type="text" class="form-control" name="asset-obs" placeholder="Observações (Opcional)" value="<?=$asset['obs']?>" autocomplete="off">
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
                  <input type="date" class="form-control" name="asset-warranty" value="<?=$asset['warranty']?>" disabled>
                </div>
              </div>
            </div>
            <button type="submit" name="update_asset" class="btn btn-success">ATUALIZAR</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>