<title>tomojisho ranking</title>
<head>OVERALL RANKING</head>
<body>
  <table border="1">
    <?php
      $count = 0;
        foreach ($data as $value) {
          ++$count;
          echo "<tr>";
          echo "<th><img width='40' height='40' src='".$value['User']['avatar']."'></img></th>";
          echo "<th>".$count."</th>";
          echo "<th>".$value['User']['user_name']."</th>";
          echo "<th>".$value['User']['correct']."</th>";
          echo "<th>".$value['User']['total']."</th>";
          echo "</tr>";
        }
    ?>
  </table>
  <button style="button" onClick="redirect();"></button>
  <script type="text/javascript">
  $(document).ready(function(){
    function redirect() { window.location.href = '/Game/welcome';}
  });
  </script>
</body>
