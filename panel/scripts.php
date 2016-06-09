<!-- Custom JS -->
        <!--<script src="$_SERVER['DOCUMENT_ROOT'].'app/userspace/assets/js/nprogress.js'"></script>
        <script src="$_SERVER['DOCUMENT_ROOT'].'app/userspace/assets/js/custom.js'"></script>-->
        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function()
            {
                $('#example').DataTable( {
                "scrollY":        "30em",
                "scrollCollapse": false,
                "paging":         false
                } );
                //Based on the GET passed determines which selection is set to current
                $("#<?php echo($activeSelection); ?>").addClass("current-page");
            } );
        </script>
</body>

