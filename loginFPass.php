<?php
print_r($_POST);

// Create a token, add to datebase, including dateTime stamp to calculate 24hr expiration, and changed boolean set to false.
// Email address with link and token
// if clicks link then site checks token, expiration, and email address
// Prompts for new password
// Once submited then password changes, changed column is set true
// User prompted with a message that password changed successfully
?>