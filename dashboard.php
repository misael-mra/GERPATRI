<?php
require_once('includes/load.php');

$page_title = 'Dashboard';
// Verifica se o usuário tem permissão para acessar essa página
page_require_level(2);

$c_asset     = count_by_id('assets');
$c_transfer  = count_by_id('transfers');
$c_sector    = count_by_id('sectors');
$c_user      = count_by_id('users');

$pieChartAssetsPerDescription = pieChartAssetPerDescription();
$pieChartAssetsPerSituation = pieChartAssetPerSituation();

$recent_transfers    = find_recent_transfer_added('10');

?>
<?php include_once('layouts/header.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"/>

<div class="row">
  <div class="col-md-6">
    <?= display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-green">
        <i class="glyphicon glyphicon-user"></i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?= $c_user['total']; ?> </h2>
        <p class="text-muted">Usuários</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-red">
        <i class="glyphicon glyphicon-edit"></i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?= $c_asset['total']; ?> </h2>
        <p class="text-muted">Bens Cadastrados</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-blue">
        <i class="glyphicon glyphicon-transfer"></i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?= $c_transfer['total']; ?> </h2>
        <p class="text-muted">Transferências Pendentes</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-yellow">
        <i class="glyphicon glyphicon-map-marker"></i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?= $c_sector['total']; ?></h2>
        <p class="text-muted">Setores</p>
      </div>
    </div>
  </div>
</div>
<hr>
<!-- Charts -->
<div class="row" style="background-color:white;padding: 15px;">
  <div>
    <div class="col-md-6">
      <canvas id="pieChart" width="450" height="200"></canvas>
    </div>
    <div class="col-md-6">
      <canvas id="doughnutChart" width="450" height="200"></canvas>      
    </div>
  </div>
</div>
<hr>
<!-- /Charts -->
<hr>

<div class="row">   
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Transferências pendentes de análise</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr>
              <th style="max-width: 20px;">Nº Tombo</th>
              <th style="max-width: 200px;">Bem</th>
              <th style="max-width: 30px;">Responsável</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recent_transfers as  $recent_transfer): ?>
              <tr>
                <td><?= remove_junk(first_character($recent_transfer['tombo'])); ?></td>
                <td><?= remove_junk(ucfirst($recent_transfer['descrip_asset'])); ?></td>
                <td><?= remove_junk(first_character($recent_transfer['sector_id'])); ?></td>
              </tr>

            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div> 


<script>
// pie chart
var ctx = document.getElementById('pieChart');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [
    <?php foreach ($pieChartAssetsPerDescription as $count_desc_description): ?>
      "<?= $count_desc_description['name'] ?>",
    <?php endforeach; ?>
    ],
    datasets: [{
      label: 'QUANTIDADES',
      data: [
      <?php foreach ($pieChartAssetsPerDescription as $count_desc_description): ?>
        "<?= $count_desc_description['count'] ?>",
      <?php endforeach; ?>
      ],
      fill: false,              
      backgroundColor: [
      <?php foreach ($pieChartAssetsPerDescription as $count_desc_description):
        $rand1 = mt_rand(0, 255); $rand2 = mt_rand(0, 255); $rand3 = mt_rand(0, 255); ?>
        '<?= "rgba($rand1, $rand2, $rand3)" ?>',
      <?php endforeach; ?>
      ]

    }]
  },
    
});

// doughnut chart
var ctxD = document.getElementById("doughnutChart").getContext('2d');
var myLineChart = new Chart(ctxD, {
  type: 'doughnut',
  data: {
    labels: [
    <?php foreach ($pieChartAssetsPerSituation as $count_situation): ?>
      "<?= $count_situation['name'] ?>",
    <?php endforeach; ?>
    ],
    datasets: [{
      data: [
      <?php foreach ($pieChartAssetsPerSituation as $count_situation): ?>
        "<?= $count_situation['count'] ?>",
      <?php endforeach; ?>
      ],              
      backgroundColor: [
      <?php foreach ($pieChartAssetsPerSituation as $count_situation):
        $rand1 = mt_rand(0, 255); $rand2 = mt_rand(0, 255); $rand3 = mt_rand(0, 255); ?>
        '<?= "rgba($rand1, $rand2, $rand3)" ?>',
      <?php endforeach; ?>
      ]
    }]
  },
  options: {
    responsive: true
  }
});
</script>

<?php include_once('layouts/footer.php'); ?>
