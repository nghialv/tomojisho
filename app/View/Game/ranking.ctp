<div id="ranking-div">
  <div id="ranking-table">
  <table border="1">
    <?php
      $count = 0;
        foreach ($data as $value) {
          ++$count;
          echo "<div class='ranking-line'>";
          echo "<div style='float:left; margin: 10px;'>".$count."</div>";
          echo "<div style='float:left;'><img width='40' height='40' src='".$value['User']['avatar']."'></img></div>";
          echo "<div style='float:left; margin: 10px;'>".$value['User']['user_name']."</div>";
          echo "<div style='float:right; margin: 10px;'>".$value['User']['correct']."/".$value['User']['total']."</div>";
          echo "</div>";
          echo "<hr>";
        }
    ?>
  </table>
  </div>
</div>
<div id="reset" ><button style="button" onClick="redirect();"></button></div>

<script type="text/javascript">
  function redirect() { window.location.href = '/Game/welcome';}
    $(document).ready(function(){
  });
</script>
