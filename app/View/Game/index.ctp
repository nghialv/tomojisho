  <div id="question-box">
    <?php
      if ($data['type'] == "status")
        echo '"'.$data['data']['message'].'"'."</br>";
      else if ($data['type'] == "image")
        echo '<img src="'.$data['data']['src_big'].'"/></br>';
    ?>
    <div style="clear:both;"></div>
  </div><br>

  <p id="question-p">Q: which of your friend does this feature match with?</p><br>

  <div id="users-box">
  <div id="1" class="user1-box user-box" onClick="sendata($(this));" href='javascript:void(0);'>
    <?php
      echo '<img src="'.$data["friends"][1]["avatar"].'"/>';
      echo $data['friends'][1]['name']."</br>";
    ?>
  </div>
  <div id="countdown">200</div>
  <div id="2" class="user2-box user-box" onClick="sendata($(this));" href='javascript:void(0);'>
    <?php
      echo '<img src="'.$data["friends"][2]["avatar"].'"/>';
      echo $data['friends'][2]['name']."</br>";
    ?>
  </div>
  </div>

<div id="feedback"></div>
<div id="reset" ><button style="button" onClick="reset();">Reset game</button></div>
<div id="score">0/0</div>

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
        if (sessionStorage.started) { //if initilized
          if (data === '"true"') {
            sessionStorage.correctguess = parseInt(sessionStorage.correctguess) + 1;
            $("#feedback").html("Congratulation, you're right");
            var selector = ".user-box#"+(3-input.attr("id"));
            $(selector).fadeOut("slow",0,function(){});
          }
          else {
            $("#feedback").html("Sorry, you're wrong");
            input.fadeOut("slow",0,function(){});
          }
          sessionStorage.totalguess = parseInt(sessionStorage.totalguess) + 1;
        }
        $("#score").html(sessionStorage.correctguess+"/"+sessionStorage.totalguess);
        window.location.href = "/Game/display";
      });
  }

  function reset() {
    sessionStorage.started = 1;
    sessionStorage.totalguess = 0;
    sessionStorage.correctguess = 0;
    window.location.href = "/Game/display";
  }

  function triggerend() {
    endeffect(-1);
  }

  function endeffect(correctans) {
      $.post("/Game/judge", {choose: 1, ans: $("#answer").html()},
        function(data) {
          if (correctans === -1){
            if (data === '"true"') correctans = 1;
            else correctans = 2;
          }
          var selector = ".user-box#"+(3-correctans);
          $(selector).fadeOut("slow", 0, function(){
            //update score
            sessionStorage.totalguess = parseInt(sessionStorage.totalguess)+1;
            $("#score").html(sessionStorage.correctguess+"/"+sessionStorage.totalguess);
            window.location.href = "/Game/display";
          });
        }
      );
  }


  $(document).ready(function() {
    //start timer
    var interval = setInterval(function(){
      $("#countdown").html(parseInt($("#countdown").html()) - 1);
      if(parseInt($("#countdown").html()) <= 0) {
        sessionStorage.totalguess = parseInt(sessionStorage.totalguess)+1;
        clearInterval(interval);
        triggerend();
      }
    }, 1000);


    if (!sessionStorage.started) { //initialize
      sessionStorage.started = 1;
      sessionStorage.totalguess = 0;
      sessionStorage.correctguess = 0;
    }

    //write point to screen
    sessionStorage.started = parseInt(sessionStorage.started) + 1;
    if (parseInt(sessionStorage.started) > 20) {
      $.colorbox({html:"Your point is".sessionStorage.correctguess."/".sessionStorage.totalguess});
      clearInterval(interval);
    }

    $("#score").html(sessionStorage.correctguess+"/"+sessionStorage.totalguess);
  });
</script>
