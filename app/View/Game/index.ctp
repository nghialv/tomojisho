  <div id="question-box">
    <?php
      if ($data['type'] == "status")
        echo '"'.$data['data']['message'].'"'."</br>";
      else if ($data['type'] == "image")
        echo '<img src="'.$data['data']['src_big'].'"/></br>';
    ?>
    <div style="clear:both;"></div>
  </div><br>

  <p id="question-p">
  <?php
    if ($data['type'] == "status")
        echo 'Q: だれが上のステータスを投稿しましたか?';
    else if ($data['type'] == "image")
        echo 'Q: だれが上の写真をアップロードしましたか?';
  ?>
  </p><br>
  <div id="users-box">
  <a href="#feedback">
    <div id="1" class="user1-box user-box" onClick="sendata($(this));" href='javascript:void(0);'>
      <?php
        echo '<img src="'.$data["friends"][1]["avatar"].'"/>';
        echo $data['friends'][1]['name']."</br>";
      ?>
    </div>
  </a>
  <div id="countdown">100</div>

  <a href="#feedback">
    <div id="2" class="user2-box user-box" onClick="sendata($(this));" href='javascript:void(0);'>
      <?php
        echo '<img src="'.$data["friends"][2]["avatar"].'"/>';
        echo $data['friends'][2]['name']."</br>";
      ?>
    </div>
  </a>
  </div>

<div id="loading-status-div" style=" display: none; position: fixed; top: 145px; left: 242px; width: 550px; height: 500px; z-index: 2000;text-align: center">
  <img src="../img/loading.gif" style="margin-left: 10px; height: 200px;"/>
  <p style="color: white; font-size: 20px;">次の質問のローディング中</p>
</div>

<div id="feedback"></div>
<div id="reset" ><button style="button" onClick="reset();"></button></div>
<div id="score">0/0</div>
<div id="popup-background"></div>
<div id="popup-content">
  <div id="popup-content-main">
    <div id="endgame-point"></div>
    <button style="button" id="posttofacebook" onClick="posttofacebook();"></button>
    <div id="reset2" ><button style="button" onClick="reset();"></button></div>
  </div>
</div>

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
            $(selector).fadeOut();
            $("#countdown").fadeOut();
          }
          else {
            $("#feedback").html("Sorry, you're wrong");
            input.fadeOut();
            $("#countdown").fadeOut();
          }
          sessionStorage.totalguess = parseInt(sessionStorage.totalguess) + 1;

          // show loading status
          $("#popup-background").show();
          $('#loading-status-div').show();
        }
        $("#score").html(sessionStorage.correctguess+"/"+sessionStorage.totalguess);
        window.location.href = "/Game/display";
      });
  }

  function reset() {
    sessionStorage.started = 1;
    sessionStorage.totalguess = 0;
    sessionStorage.correctguess = 0;
    window.location.href = "/Game/welcome";
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
            $("#countdown").fadeOut();
            $("#score").html(sessionStorage.correctguess+"/"+sessionStorage.totalguess);
            window.location.href = "/Game/display";
          });
        }
      );
  }

  function posttofacebook() {
      $.post("/Game/endgame", {correct: sessionStorage.correctguess, total: sessionStorage.totalguess},
        function(data) {
          window.location.href = "/Game/welcome";
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
    else {
      sessionStorage.started = parseInt(sessionStorage.started) + 1;
      if (parseInt(sessionStorage.started)-1 > 3) {
        clearInterval(interval);
        $("#endgame-point").html(sessionStorage.correctguess + "/" + sessionStorage.totalguess);
        $("#popup-background").show();
        if (parseInt(sessionStorage.correctguess) < parseInt(sessionStorage.totalguess/2)) {
          $("#popup-content").css({'background': 'url(../img/wrong.png)', 'background-size':'530px 350px'});
        }
        else {
          $("#popup-content").css({'background': 'url(../img/right.png)', 'background-size':'530px 350px'});
        }

        $("#popup-content").show();
      }
    }
    //write point to screen
    $("#score").html(sessionStorage.correctguess + "/" + sessionStorage.totalguess);
  });
</script>
