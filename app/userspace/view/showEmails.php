<?php 

    $_SESSION['update'] = $_GET['update'];
    $_SESSION['controller'] = $_GET['controller'];
?>
    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="../app/userspace/assets/css/style.css">

    <div class = "row" id="users">
    <h1 class="text-center">Users Page:</h1>
    <center><a href="../../app/userspace/download.php"><i class="fa fa-file-excel-o" aria-hidden="true"></i></i> Download Email List</a></center>
    <br>
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>User</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>User</th>
            </tr>
        </tfoot>
 
        <tbody>
          <?php
            // Counter to keep track of multidimensional array
            $counter = 0;
            foreach($events as $row){
                $user = $row['username'];
                $counter++;
                echo "<tr><td>$user</td></tdtr>";
            };
           ?>
        </tbody>
    </table>
    </div>
 
     
    <!--side bar menu option(div id = "sidebar-menu") or in right_col row to left of user page  #0099e6
    
    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
    <i class="fa fa-download" aria-hidden="true">
    </i>
    -->