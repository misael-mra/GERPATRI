<?php
require_once('includes/load.php');
// Check if user is logged in
if(!$session->isUserLoggedIn(true)) { redirect('dashboard.php', false);}

// Auto sugestão
$html = '';
if(isset($_POST['asset_tombo']) && strlen($_POST['asset_tombo']))
{
  $assets = find_asset_by_tombo($_POST['asset_tombo']);
  if($assets){
    foreach ($assets as $asset):
      $html .= "<li class=\"list-group-item\">";
      $html .= $asset['tombo'];
      $html .= "</li>";
    endforeach;
  } else {

    $html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
    $html .= 'Tombo não encontrado ou este bem já foi transferido.';
    $html .= "</li>";

  }

  echo json_encode($html);
}

// Usuário responsável

$user = current_user();

// Encontrar todos os bens 
if(isset($_POST['a_tombo']) && strlen($_POST['a_tombo']))
{
  $asset_tombo = remove_junk($db->escape($_POST['a_tombo']));
  if($results = find_all_asset_info_by_tombo($asset_tombo)){
    $all_sector = find_all('sectors');
    foreach ($results as $result) {

      $html .= "<tr>";

      $html .= "<input type=\"hidden\" name=\"asset_id\" value=\"{$result['id']}\">";

      $html .= "<td class=\"text-center\" id=\"a_tombo\">".$result['tombo']."</td>";

      $html .= "<td>".$result['descrip_asset']."</td>";

      $html  .= "<td>";
      $html  .= "<input type=\"text\" class=\"form-control\" value=\"{$user['name']}\" name=\"responsible_user\" disabled>";
      $html  .= "</td>";

      $html .= "<td>";
      $html .= "<select class=\"form-control\" name=\"sector\" required>";
      $html .=    "<option selected value=\"\">Selecione</option>";
      foreach ($all_sector as $sec):          
        $html .=    "<option value=\"{$sec['id']}\">{$sec['name']}</option>";
      endforeach;
      $html .= "</select>";
      $html  .= "</td>";

      $html  .= "<td>";
      $html  .= "<input type=\"date\" class=\"form-control\" name=\"transfer_date\" required>";
      $html  .= "</td>";

      $html  .= "<td class=\"text-center\">";
      $html  .= "<button type=\"submit\" name=\"add_transfer\" class=\"btn btn-primary\">Registrar Transferência</button>";
      $html  .= "</td>";

      $html  .= "</tr>";

    }
  } else {
    $html ='<tr><td>Tombo não encontrado ou o bem já foi transferido.</td></tr>';
  }

  echo json_encode($html);
}
?>