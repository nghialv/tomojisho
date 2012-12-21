<title>tomojisho ranking</title>
<head>OVERALL RANKING</head>
<body>
  <table border="1">
    <?php
      $count = 0;
        foreach ($data as $value) {
          echo "<tr>";
          echo "<th><img src='".$value['User']['user_name']."'></img></th>";
          echo "<th>".$value['User']['user_name']."</th>";
          echo "<th>".$value['User']['correct']."</th>";
          echo "<th>".$value['User']['total']."</th>";
          echo "</tr>";
        }
    ?>
  </table>
</body>
