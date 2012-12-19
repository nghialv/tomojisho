<p>The feature of your friend</p>
  <div id="question-box">
    <?php
       echo $data['data']['message']."</br>";
    ?>
    <div style="clear:both;"></div>
  </div><br>

  <p>Q: which of your friend does this feature match with?</p><br>

  <div id="users-box">
  <div id=" 1" class="user1-box" onClick="sendata($(this));" href='javascript:void(0);'>
    <?php
      echo '<img src="'.$data["friends"][1]["avatar"].'"/>';
      echo $data['friends'][1]['name']."</br>";
    ?>
  </div>

  <div id="2" class="user2-box" onClick="sendata($(this));" href='javascript:void(0);'>
    <?php
      echo '<img src="'.$data["friends"][2]["avatar"].'"/>';
      echo $data['friends'][2]['name']."</br>";
    ?>
  </div>
  </div>

<div id="reset" ><button style="button" onClick="reset();">Reset game</button></div>
<div id="timer">20</div>
<?php
  $seed = rand(1,100000);
  if ($seed % 2 == 0)
     $seed = $seed + 1;

  $ans = $data['ans'] * $seed;
  echo '<div style="display:none" id="answer">'.$ans.'</div>';
?>

<script type="text/javascript">
  function sendata(input) {
    $.post("/Game/judge", {choose: input.attr("id"), ans: $("#answer").html()},
      function(data) {
        alert(data);

        if (sessionStorage.started) { //if initilized
          if (data === '"true"') {
            sessionStorage.correctguess = parseInt(sessionStorage.correctguess) + 1;
          }
          sessionStorage.totalguess = parseInt(sessionStorage.totalguess) + 1;
        }
        window.location.href = "/Game/display";
      });
  }

  function reset() {
    sessionStorage.started = 1;
    sessionStorage.totalguess = 0;
    sessionStorage.correctguess = 0;
    window.location.href = "/Game/display";
  }

  function nexttrigger() {
    alert("trigger");    
  }
  
  $(document).ready(function() {
    //timer
    var interval = setInterval(function(){
      var curtime = parseInt($("timer").html());
      curtime--;
      if(curtime <= 0) {
        clearInterval(interval);
        nexttrigger();
      }
      $("timer").html(curtime);
    }, 1000);

    var curtime = $("timer").html();

    if (!sessionStorage.started) { //initialize
      sessionStorage.started = 1;
      sessionStorage.totalguess = 0;
      sessionStorage.correctguess = 0;
    }

    //write point to screen
    $("body").append('<div>'+sessionStorage.correctguess+' / '+sessionStorage.totalguess+'</div>');
  });
</script>
