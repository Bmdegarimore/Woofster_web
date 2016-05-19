<!-- Custom JS -->
        <!--<script src="$_SERVER['DOCUMENT_ROOT'].'app/userspace/assets/js/nprogress.js'"></script>
        <script src="$_SERVER['DOCUMENT_ROOT'].'app/userspace/assets/js/custom.js'"></script>-->
              
        <!--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->
        <script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
       


        <script>
            $(document).ready(function()
            {
                //Grabs all events and puts into jsonarray
                var jsonEvents = <?php echo json_encode($events, JSON_PRETTY_PRINT) ?>;
               
                $('#example').DataTable( {
                "scrollY":        "30em",
                "scrollCollapse": false,
                "paging":         false
                } );
  
            } );
        </script>
</body>

