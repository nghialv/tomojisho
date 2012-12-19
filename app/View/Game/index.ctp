<p>The feature of your friend</p>
  <div id="box1">
    <?php
       echo $data['data']['message']."</br>";
    ?>
  </div><br>

  <p>Q: which of your friend does this feature match with?</p><br>

  <div id="box2">
    <?php
      echo $data['friends'][1]['name']."</br>";
    ?>
  </div>

  <div id="box3">
    <?php
      echo $data['friends'][2]['name']."</br>";
    ?>
  </div>


<?php
  $seed = rand(1,100000);
  if ($seed % 2 == 0)
     $seed = $seed + 1;

  $ans = $data['ans'] * $seed;
  echo '<div style="display:none" id="answer">'.$ans.'</div>';
?>

<a id="1" onClick="sendata($(this));" href='javascript:void(0);'>1を選択</a>
<a id="2" onClick="sendata($(this));" href='javascript:void(0);'>2を選択</a>
<script type="text/javascript">
  $(document).ready(function() {
    if (!sessionStorage.started) { //initialize
      sessionStorage.started = 1;
      sessionStorage.totalguess = 0;
      sessionStorage.correctguess = 0;
    }

    //write point to screen
    $("body").append('<div>'+sessionStorage.correctguess+' / '+sessionStorage.totalguess+'</div>');

    function sendata(input) {
      $.post("/Game/judge", {choose: input.attr("id"), ans: $("#answer").html()},
        function(data) {
          alert(data);

          if (sessionStorage.started) { //if initilized
            if (data === 'true') {
              sessionStorage.correctguess = Integer.parseInt(sessionStorage.correctguess) + 1;
            }
            sessionStorage.totalguess = Integer.parseInt(sessionStorage.totalguess) + 1;
          }
          window.location.href = "/Game/display";
        });
    }
  });
</script>
