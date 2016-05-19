<?php
    

?>
      <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Day');
      data.addColumn('number', 'Total Events per Day');

      data.addRows(<?php echo($data);?>);
      
      var options = {
        title: 'Usage Per Day',
        hAxis: {
          title: 'Day',
          format: 'Day:',
          viewWindow: {
            min: [1],
            max: [31]
          }
        },
        vAxis: {
          title: 'Total Users'
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('chart_div'));
        
      chart.draw(data, options);
    }
</script>
    <div class="row">
        <div class="col-lg-4">
            <h3 class="text-center">Events Created</h3>
            <hr>
            <p class="text-center statValues"><?php echo($countedEvents);?></p>
            <h3 class="text-center">Average Events Per User</h3>
            <hr>
            <p class="text-center statValues"><?php echo($avgEventsPerUser);?></p>
        </div>
        <div class="col-lg-4">
            <h3 class="text-center">Notifcations Sent</h3>
            <hr>
            <p class="text-center statValues"><?php echo($numberOfNotificationsPast);?></p>
            <h3 class="text-center">Social Media Account</h3>
            <hr>
            <p class="text-center statValues"><?php echo($numberSocialMediaUsers);?></p>
        </div>
        <div class="col-lg-4">
            <h3 class="text-center">Total Users</h3>
            <hr>
            <p class="text-center statValues"><?php echo($numberUsers);?></p>
            <h3 class="text-center">Email Accounts</h3>
            <hr>
            <p class="text-center statValues"><?php echo($numberEmailUsers);?></p>
        </div>
    </div>
    <div class="row">
        <div id="chart_div"></div>    
    </div>
    