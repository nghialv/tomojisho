<div id="ranking-div">
  <div id="ranking-table">
  <table border="1">
    <?php
      $count = 0;
        foreach ($data as $value) {
          ++$count;
          echo "<div class='ranking-line'>";
          echo "<div>".$count."</div>";
          echo "<div><img width='40' height='40' src='".$value['User']['avatar']."'></img></div>";
          echo "<div>".$value['User']['user_name']."</div>";
          echo "<div>".$value['User']['correct']."/".$value['User']['total']."</div>";
          echo "</div>";
          echo "<hr>";
        }
    ?>
  </table>
  </div>
  <div id="reset" ><button style="button" onClick="redirect();"></button></div>

  <script type="text/javascript">
  function redirect() { window.location.href = '/Game/welcome';}
  $(document).ready(function(){
  });
  </script>
</div>
