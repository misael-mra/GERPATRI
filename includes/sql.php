<?php

/*--------------------------------------------------------------*/
/* Função para encontrar todas as linhas da tabela da base de dados pelo nome da tabela
/*--------------------------------------------------------------*/
function find_all($table) {
  global $db;
  if(tableExists($table))
  {
    return find_by_sql("SELECT * FROM ".$db->escape($table));
  }
}

/*--------------------------------------------------------------*/
/* Função para realizar consultas
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
  return $result_set;
}

/*--------------------------------------------------------------*/
/*  Função para procurar dados da tabela pelo id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
  if(tableExists($table)){
    $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
    if($result = $db->fetch_assoc($sql))
      return $result;
    else
      return null;
  }
}

/*--------------------------------------------------------------*/
/* Função para apagar dados da tabela por id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
  {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}

/*--------------------------------------------------------------*/
/* Função de contagem de id pelo nome da tabela
/*--------------------------------------------------------------*/
function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
    return($db->fetch_assoc($result));
  }
}

/*--------------------------------------------------------------*/
/* Determinar se a tabela da base de dados existe
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
  if($table_exit) {
    if($db->num_rows($table_exit) > 0)
      return true;
    else
      return false;
  }
}

/*--------------------------------------------------------------*/
/* Entrar com os dados fornecidos no $_POST,
/* vindos do formulário de login.
/*--------------------------------------------------------------*/
function authenticate($username='', $password='') {
  global $db;
  $username = $db->escape($username);
  $password = $db->escape($password);
  $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
  $result = $db->query($sql);
  if($db->num_rows($result)){
    $user = $db->fetch_assoc($result);
    $password_request = sha1($password);
    if($password_request === $user['password'] ){
      return $user['id'];
    }
  }
  return false;
}


/*--------------------------------------------------------------*/
/* Encontrar usuário atual logado pelo id da sessão
/*--------------------------------------------------------------*/
function current_user(){
  static $current_user;
  global $db;
  if(!$current_user){
    if(isset($_SESSION['user_id'])):
      $user_id = intval($_SESSION['user_id']);
      $current_user = find_by_id('users',$user_id);
    endif;
  }
  return $current_user;
}

/*--------------------------------------------------------------*/
/* Encontrar todos os usuários através da junção da 
/* tabela de usuários e da tabela de grupos de usuários
/*--------------------------------------------------------------*/
function find_all_user(){
  global $db;
  $results = array();
  $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
  $sql .="g.group_name ";
  $sql .="FROM users u ";
  $sql .="LEFT JOIN user_groups g ";
  $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
  $result = find_by_sql($sql);
  return $result;
}

/*--------------------------------------------------------------*/
/* Função para atualizar o último login de um usuário
/*--------------------------------------------------------------*/
function updateLastLogIn($user_id)
{
  global $db;
  $date = make_date();
  $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
  $result = $db->query($sql);
  return ($result && $db->affected_rows() === 1 ? true : false);
}

/*--------------------------------------------------------------*/
/* Encontrar nível de grupo
/*--------------------------------------------------------------*/
function find_by_groupLevel($level)
{
  global $db;
  $sql = "SELECT group_level,group_status FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Função para verificar qual o nível de acesso do usuário à página
/*--------------------------------------------------------------*/
function page_require_level($require_level){
  global $session;
  $current_user = current_user();
  $login_level = find_by_groupLevel($current_user['user_level']);

  //se o usuário não fizer login
  if (!$session->isUserLoggedIn(true)):
    $session->msg('d','Por favor, faça o Login.');
    redirect('index.php', false);
  //se o estado do grupo estiver desativado
  elseif($login_level['0']['group_status'] === '0'):     
    if(!$session->logout()):
      $session->msg('d','Este nível de usuário está desabilitado.');
      redirect("index.php");        
    endif;
  //verifica o nível de login e o nível de permissão
  elseif($current_user['user_level'] <= (int)$require_level):
    return true;
  else:
    $session->msg("d", "Você não tem permissão para acessar esta página.");
    redirect('dashboard.php', false);
  endif;

}

/*--------------------------------------------------------------*/
/* Função para encontrar todos os bens
/*--------------------------------------------------------------*/
function find_all_asset(){
  global $db;
  $sql  =" SELECT e.id, e.tombo, e.obs, e.warranty, d_a.name AS descrip_asset,";
  $sql  .=" m.name AS manufacturer, sit.name AS situation, t_item.name AS type_item,";
  $sql  .=" e.created_at, u_c.name AS created_user, u_u.name AS updated_user, e.updated_at";
  $sql  .=" FROM assets e";
  $sql  .=" INNER JOIN description_assets d_a ON d_a.id = e.description_asset_id";
  $sql  .=" INNER JOIN types_itens t_item ON t_item.id = e.types_item_id";
  $sql  .=" INNER JOIN manufacturers m ON m.id = e.manufacturer_id";
  $sql  .=" INNER JOIN situations sit ON sit.id = e.situation_id";
  $sql  .=" INNER JOIN users u_c ON u_c.id = e.created_by";
  $sql  .=" LEFT JOIN users u_u ON u_u.id = e.updated_by";
  $sql  .=" ORDER BY e.id DESC";
  return find_by_sql($sql);

}

/*--------------------------------------------------------------*/
/* Função para validar o tombo dos bens
/*--------------------------------------------------------------*/
function validate_tombo($asset_tombo){
  global $db;
  $sql = "SELECT tombo FROM assets WHERE tombo = $asset_tombo";
  $result = find_by_sql($sql);

  if(empty($result)){
    return false;
  }

  return true;
}

/*--------------------------------------------------------------*/
/* Função para validar a descrição do bem
/*--------------------------------------------------------------*/
function validate_description_asset($desc_asset_name){
    global $db;
    $sql  = "SELECT name FROM description_assets WHERE name = '$desc_asset_name'";
    $result = find_by_sql($sql);

  if(empty($result)){
    return false;
  }

  return true;
}

/*--------------------------------------------------------------*/
/* Função para validar o tipo/categoria do bem
/*--------------------------------------------------------------*/
function validate_types_item($type_item_name){
  global $db;
  $sql  = "SELECT name FROM types_itens WHERE name = '$type_item_name'";
  $result = find_by_sql($sql);

if(empty($result)){
  return false;
}

return true;
}

/*--------------------------------------------------------------*/
/* Função para encontrar todos os nomes dos bens 
/* solicitados por ajax.php para auto-sugestão
/*--------------------------------------------------------------*/
function find_asset_by_tombo($asset_tombo){
  global $db;
  $a_tombo = remove_junk($db->escape($asset_tombo));
  $sql  = "SELECT tombo FROM assets";
  $sql .= " WHERE id NOT IN (SELECT asset_id FROM transfers)";
  $sql .= " AND tombo like '%$a_tombo%' LIMIT 5";
  $result = find_by_sql($sql);
  return $result;
}

/*--------------------------------------------------------------*/
/* Função para encontrar todas as informações do bem pelo nº tombo 
/* solicitados por ajax.php
/*--------------------------------------------------------------*/
function find_all_asset_info_by_tombo($tombo){
  global $db;
  $sql  = "SELECT a.id, a.tombo, d_a.name AS descrip_asset FROM assets a";
  $sql .= " INNER JOIN description_assets d_a ON d_a.id = a.description_asset_id";
  $sql .= " WHERE a.id NOT IN (SELECT asset_id FROM transfers)";    
  $sql .= " AND a.tombo ='{$tombo}'";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Função para encontrar todas as transferências
/*--------------------------------------------------------------*/
function find_all_transfer(){
  global $db;
  $sql  = "SELECT t.id, t.responsible_user, t.transfer_date, a.tombo, a.description_asset_id, s.name AS sector, d_a.name AS descrip_asset,";
  $sql  .=" t.created_at, u_c.name AS created_user, u_u.name AS updated_user, t.updated_at";
  $sql .= " FROM transfers t";
  $sql .= " INNER JOIN assets a ON a.id = t.asset_id";
  $sql .= " INNER JOIN sectors s ON s.id = t.sector_id";
  $sql .= " INNER JOIN description_assets d_a ON d_a.id = a.description_asset_id";
  $sql  .=" INNER JOIN users u_c ON u_c.id = t.created_by";
  $sql  .=" LEFT JOIN users u_u ON u_u.id = t.updated_by";
  $sql .= " ORDER BY t.created_at DESC";   
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Função para exibição de empréstimo/transferencia recente
/*--------------------------------------------------------------*/
function find_recent_transfer_added($limit){
  global $db;
  $sql  ="SELECT t.id, t.responsible_user, t.transfer_date, a.tombo, d_a.name AS descrip_asset";
  $sql .= " FROM transfers t";
  $sql .= " INNER JOIN assets a ON a.id = t.asset_id";
  $sql  .=" INNER JOIN description_assets d_a ON d_a.id = a.description_asset_id";
  $sql .= " ORDER BY t.created_at DESC LIMIT ".$db->escape((int)$limit);
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Função para encontrar todo o histórico de transferências
/*--------------------------------------------------------------*/
function find_all_transfer_history(){
  global $db;
  $sql  = "SELECT l_h.id,l_h.responsible_user,l_h.transfer_date,l_h.created_at,e.tombo,e.specifications,s.name AS sector,u.name AS create_user";
  $sql .= " FROM transfer_historys l_h";
  $sql .= " INNER JOIN assets e ON e.id = l_h.asset_id";
  $sql .= " INNER JOIN sectors s ON s.id = l_h.sector_id";
  $sql .= " INNER JOIN users u ON u.id = l_h.created_by";
  $sql .= " ORDER BY l_h.created_at DESC";   
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Relatórios: Função de emissão de relatórios
/*--------------------------------------------------------------*/
function issue_reports($tombo, $specifications, $responsible_user, $transfer, $description_asset, $sector, $manufacturer, $situation){
  global $db;
  $sql  = "SELECT e.tombo,e.specifications,e.obs,e.warranty,t.responsible_user,s.name AS sector,m.name AS manufacturer,sit.name AS situation,t_e.name AS description_assets FROM assets e 
  LEFT JOIN transfers t ON t.asset_id = e.id 
  LEFT JOIN sectors s ON s.id = t.sector_id 
  INNER JOIN manufacturers m ON m.id = e.manufacturer_id 
  INNER JOIN situations sit ON sit.id = e.situation_id 
  INNER JOIN types_itens t_e ON t_e.id = e.description_assets_id WHERE e.id ";

  // Procurar bens na categoria de "Somente Emprestados"
  if($transfer === "2"){
    $sql  = "SELECT e.tombo,e.specifications,e.obs,e.warranty,t.responsible_user,s.name AS sector,m.name AS manufacturer,sit.name AS situation,t_e.name AS description_assets FROM assets e 
    INNER JOIN transfers t ON t.asset_id = e.id 
    INNER JOIN sectors s ON s.id = t.sector_id 
    INNER JOIN manufacturers m ON m.id = e.manufacturer_id 
    INNER JOIN situations sit ON sit.id = e.situation_id 
    INNER JOIN types_itens t_e ON t_e.id = e.description_assets_id WHERE e.id ";

  // Procurar bens na categoria de "Somente não Emprestados"
  } elseif($transfer === "3") {
    $sql  = "SELECT e.tombo,e.specifications,e.obs,e.warranty,m.name AS manufacturer,sit.name AS situation,t_e.name AS description_assets FROM assets e 
    INNER JOIN manufacturers m ON m.id = e.manufacturer_id 
    INNER JOIN situations sit ON sit.id = e.situation_id 
    INNER JOIN description_assets t_e ON t_e.id = e.description_asset_id 
    WHERE e.id NOT IN (SELECT asset_id FROM transfers) ";
  }

  if(!empty($tombo)) $sql .= " AND e.tombo LIKE '%$tombo%'";
  if(!empty($specifications)) $sql .= " AND e.specifications LIKE '%$specifications%'";
  if(!empty($responsible_user) && $transfer !== "3") $sql .= " AND t.responsible_user LIKE '%$responsible_user%'";
  if(!empty($description_asset)) $sql .= " AND e.description_asset_id = '$description_asset'";
  if(!empty($sector) && $transfer !== "3") $sql .= " AND t.sector_id = $sector";
  if(!empty($manufacturer)) $sql .= " AND e.manufacturer_id = '$manufacturer'";
  if(!empty($situation)) $sql .= " AND e.situation_id = '$situation'";

  return find_by_sql($sql);
}


/*--------------------------------------------------------------*/
/* Criar gráfico de pizza para Dashboard com todos os bens
/*--------------------------------------------------------------*/
function pieChartAssetPerDescription(){
  global $db;
  $sql = "SELECT COUNT(e.description_asset_id) AS count, t_e.name FROM assets e INNER JOIN description_assets t_e ON t_e.id = e.description_asset_id GROUP BY e.description_asset_id";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Criar gráfico de pizza para Dashboard com a situação do bem
/*--------------------------------------------------------------*/
function pieChartAssetPerSituation(){
  global $db;
  $sql = "SELECT COUNT(e.situation_id) AS count,s.name FROM assets e INNER JOIN situations s ON s.id = e.situation_id GROUP BY e.situation_id";
  return find_by_sql($sql);
}

?>
