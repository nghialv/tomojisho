<div>
  <table border="1">
    <?php
      $count = 0;
        foreach ($data as $value) {
          ++$count;
          echo "<tr>";
          echo "<th>".$count."</th>";
          echo "<th><img width='40' height='40' src='".$value['User']['avatar']."'></img></th>";
          echo "<th>".$value['User']['user_name']."</th>";
          echo "<th>".$value['User']['correct']."</th>";
          echo "<th>".$value['User']['total']."</th>";
          echo "</tr>";
        }
    ?>
  </table>

  <button id="reset" style="button" onClick="redirect();"></button>
  <script type="text/javascript">
  function redirect() { window.location.href = '/Game/welcome';}
  $(document).ready(function(){
  });
  </script>
</div>
