<?php
require_once('includes/load.php');
// Check if user is logged in
if(!$session->isUserLoggedIn(true)) { redirect('dashboard.php', false);}

// Auto suggetion
$html = '';
if(isset($_POST['equipment_tombo']) && strlen($_POST['equipment_tombo']))
{
  $equipments = find_equipment_by_tombo($_POST['equipment_tombo']);
  if($equipments){
    foreach ($equipments as $equipment):
      $html .= "<li class=\"list-group-item\">";
      $html .= $equipment['tombo'];
      $html .= "</li>";
    endforeach;
  } else {

    $html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
    $html .= 'Tombo não encontrado ou este equipamento já foi transferido.';
    $html .= "</li>";

  }

  echo json_encode($html);
}

// find all equipment
if(isset($_POST['e_tombo']) && strlen($_POST['e_tombo']))
{
  $equipment_tombo = remove_junk($db->escape($_POST['e_tombo']));
  if($results = find_all_equipment_info_by_tombo($equipment_tombo)){
    $all_sector = find_all('sectors');
    foreach ($results as $result) {

      $html .= "<tr>";

      $html .= "<input type=\"hidden\" name=\"e_id\" value=\"{$result['id']}\">";

      $html .= "<td id=\"e_tombo\">".$result['tombo']."</td>";

      $html .= "<td>".$result['type_equip']."</td>";

      $html  .= "<td>";
      $html  .= "<input type=\"text\" class=\"form-control\" name=\"responsible_user\" required>";
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

      $html  .= "<td>";
      $html  .= "<button type=\"submit\" name=\"add_transfer\" class=\"btn btn-primary\">Registrar Transferência</button>";
      $html  .= "</td>";

      $html  .= "</tr>";

    }
  } else {
    $html ='<tr><td>Tombo não encontrado ou este equipamento já foi transferido.</td></tr>';
  }

  echo json_encode($html);
}
?>
