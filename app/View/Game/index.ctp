<p>The feature of your friend</p>
  <div id="question-box">
    <?php
       echo $data['data']['message']."</br>";
    ?>
    <div style="clear:both;"></div>
  </div><br>

  <p>Q: which of your friend does this feature match with?</p><br>

  <div id="users-box">
  <div id="user1-box">
    <?php
      echo $data['friends'][1]['name']."</br>";
    ?>
  </div>

  <div id="user2-box">
    <?php
      echo $data['friends'][2]['name']."</br>";
    ?>
  </div>
  </div>

<div>
<?php
  $seed = rand(1,100000);
  if ($seed % 2 == 0)
     $seed = $seed + 1;

  $ans = $data['ans'] * $seed;
  echo '<div style="display:none" id="answer">'.$ans.'</div>';
?>

<a id="1" onClick="sendata($(this));" href='javascript:void(0);'>1を選択</a>
<a id="2" onClick="sendata($(this));" href='javascript:void(0);'>2を選択</a>
</div>

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

  $(document).ready(function() {
    if (!sessionStorage.started) { //initialize
      sessionStorage.started = 1;
      sessionStorage.totalguess = 0;
      sessionStorage.correctguess = 0;
    }

    //write point to screen
    $("body").append('<div>'+sessionStorage.correctguess+' / '+sessionStorage.totalguess+'</div>');
  });
</script>
