<h1>Tomojisho</h1>
<?php
  echo $data['friends'][1]['name']."</br>";
  echo $data['friends'][2]['name']."</br>";
  echo $data['data']['message']."</br>";
  $seed = rand(1,100000);
  if ($seed % 2 == 0)
     $seed = $seed + 1;

  $ans = $data['ans'] * $seed;
  echo '<div style="display:none" id="answer">'.$ans.'</div>';
?>
<a id="1" onClick="sendata($(this));" href='javascript:void(0);'>1を選択</a>
<a id="2" onClick="sendata($(this));" href='javascript:void(0);'>2を選択</a>
<script type="text/javascript">
  function sendata(input) {
    $.post("/Game/judge", {choose: input.attr("id"), ans: $("#answer").val()},
      function(data) {
        alert(data);
        window.location.href = "/Game/display";
      });
  } 
</script>
