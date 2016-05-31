
var isCorrectSize = false;
var bothMatch = false;
var isValidEmail = false;
var isValidPassword = false;
$('.password-group').hide();
document.getElementById('submit').disabled = true;

var passwordRequirement= function(password){
        // Regex Cases
        const LOWERCASE = /^(?=.*[a-z])/;
        const UPPERCASE = /^(?=.*[A-Z])/;
        const NUMERIC = /^(?=.*\d)/;
        const SPECIAL_CHARACTER = /^(?=.*[$@$!%*?&])/;
        
        // Confirm met all criterias
        var isLower = false;
        var isUpper = false;
        var isNumeric = false;
        var isSpecial = false;
        var isLength = false;
        
        //Checks Password to verify it has Upper, Lower, Number
        if (password.length >= 8) {
            isLength = true;
            $('#length').hide();
        }else{
            isLength = false;
            $('#length').show();
        }
        
        if (LOWERCASE.test(password)) {
             isLower = true;
            $('#lowercase').hide();
        }else{
            isLower = false;
            $('#lowercase').show();
        }
        
        if (UPPERCASE.test(password)) {
            isUpper = true;
            $('#uppercase').hide();
        }else{
            isUpper = false;
            $('#uppercase').show();
        }
        
        if (NUMERIC.test(password)) {
            isNumeric = true;
            $('#numeric').hide();
        }else{
            isNumeric = false;
            $('#numeric').show();
        }
        
        if (SPECIAL_CHARACTER.test(password)) {
            isSpecial = true;
            $('#specialCharacter').hide();
        }else{
            isSpecial = false;
            $('#specialCharacter').show();
        }
        
        // Checks to make sure all requirements met for new password
        if(isLength && isLower && isUpper && isNumeric && isSpecial ){
            $('#requirements').hide();
            $("#check2").removeClass("glyphicon glyphicon-asterisk glyphicon-remove incorrect");
            $("#check2").addClass("glyphicon glyphicon glyphicon-ok correct");
            
            return true;
        }else{
            $('#requirements').show();
            $("#check2").removeClass("glyphicon glyphicon-asterisk  glyphicon-ok correct");
            $("#check2").addClass("glyphicon glyphicon-remove incorrect");
            return false;
        }
    }
   
function checkAllValid(){
    // Disables change button until requirements met
    if (isValidPassword && isValidEmail) {
        document.getElementById('submit').disabled = false;
    } else {
        document.getElementById('submit').disabled = true; 
    }
} 
var emailRequirement= function(email){
    if(email.match("^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$")){
        $('#emailExample').hide();
        $("#check1").removeClass("glyphicon glyphicon-asterisk glyphicon-remove incorrect");
        $("#check1").addClass("glyphicon glyphicon glyphicon-ok correct");
        return true;
    } else{
        $('#emailExample').show();
        $("#check1").removeClass("glyphicon glyphicon-asterisk  glyphicon-ok correct");
        $("#check1").addClass("glyphicon glyphicon-remove incorrect");
        return false;
    }
}
        
    

// If user starts to type or paste a password, then password requirements are checked. 
$("#password").bind("keyup change",function(){
    var password = $("#password").val();
    isValidPassword = passwordRequirement(password);
    checkAllValid();
    
    
});

// If user starts to type or paste a email, then email requirements are checked.
$("#email").bind("keyup change", function(){
    var email = $("#email").val();
    isValidEmail = emailRequirement(email);
    if (isValidEmail) {
        $('.password-group').show();
    }else{
        $('.password-group').hide(); 
    }
    checkAllValid();

});

// Allows user to click and hold the eye icon to see the password for a moment.
$('#show').mousedown(function(){
    document.getElementById('password').setAttribute("type", "text"); 
});

// Allows user to release the eye icon to hide the password.
$('#show').mouseup(function(){
    document.getElementById('password').setAttribute("type", "password"); 
});





