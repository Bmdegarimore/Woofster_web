<?php ?>
    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="../app/userspace/assets/css/style.css">
    

 
    <h1 class="text-center">Users Page:</h1>
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
 
     
    
    



