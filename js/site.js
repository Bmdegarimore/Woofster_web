$(document).ready(function(){
     <!-- START COUNTDOWN TIMER http://rendro.github.io/countdown/ -->

        launchTime = new Date(); // Set launch: [year], [month], [day], [hour]...
        launchTime.setDate(launchTime.getDate()); 
              $('.countdown').countdown({
          until: launchTime, 
          format: "dhms",
          whichLabels: function(amount) { 
            var units = amount % 10; 
            var tens = Math.floor(amount % 100 / 10); 
            return (amount == 1 ? 1 : 2); 
          },
                  padZeroes: true
              });

      
        <!-- /END COUNTDOWN TIMER http://rendro.github.io/countdown/ --> 
    
    
    
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {

    // Prevent default anchor click behavior
    event.preventDefault();

    // Store hash
    var hash = this.hash;

    // Using jQuery's animate() method to add smooth page scroll
    // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
    $('html, body').animate({
      scrollTop: $(hash).offset().top
    }, 900, function(){
   
      // Add hash (#) to URL when done scrolling (default click behavior)
      window.location.hash = hash;
    });
  });
  
  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        if (pos < winTop + 600) {
          $(this).addClass("slide");
        }
    });
  });
})