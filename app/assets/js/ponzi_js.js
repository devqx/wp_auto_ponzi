jQuery(document).ready(function($){
    $("#proof_form").hide();
$("#donate").click(function(){
    $("#proof_form").toggle(1100);
});

var hideconfirm = window.hideconfirm;

if(hideconfirm ==true){
    $("#confirm,#timetxt").hide();
}



});


  //*** custom javascript clock timer */
    // 1.0 set the endtime / date 


    var d = new Date();

    DayGiven = d.getDate() +1 ;

    curMonth = d.getMonth() +1 ;

    curYear = d.getFullYear();
//
    var deadline = curYear + "-" + curMonth + "-" + DayGiven;


  //** 2.0 calculate the remaining time, write a function to do so  */
  function getRemainingTime(endtime){
      var t = Date.parse(endtime) - Date.now();
      var seconds = Math.floor( (t/1000) % 60);
      var minutes = Math.floor( (t/1000/60) % 60 );
      var hours = Math.floor( (t/(1000*60*60)) - 1 );
      var days = Math.floor( t/(1000*60*60*24) );

      return {
          'total':t,
          'seconds':seconds,
          'minutes':minutes,
          'hours':hours,
          'days':days
      };

  }

//output the clock 

function updateClock(){
    clock = document.getElementById('timer');
    var t = getRemainingTime(deadline);

    //var daysSpan = clock.querySelector('.days');
    var hoursSpan = clock.querySelector('.hours');
    var minutesSpan = clock.querySelector('.minutes');
    var secondsSpan = clock.querySelector('.seconds');

    //daysSpan.innerHTML = t.days;
    hoursSpan.innerHTML = t.hours;
    minutesSpan.innerHTML = t.minutes;
    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

   
  

  if(t.total<=0){
    clearInterval(timeinterval);
    //send an ajax call to delete the user
      var user = jQuery("#user").text();
     var options = {
         type: 'POST',
         data: { expired_user : user, action: 'handle_delete_user'},
         async: true,
         crossDomain: true,
         success: function(response){
            console.log(response);
         },
         error:function(err){
            console.log(err);
         }
     };

     jQuery.ajax(ajaxurl, options);
  
  }
}





   

