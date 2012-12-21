<title>tomojisho ranking</title>
<head>OVERALL RANKING</head>
<body>
  <table border="1">
    <?php
      $count = 0;
      echo "<tr>";
        foreach ($data as $value) {
          echo ++$count;
          echo "<th>".$value['User']['user_name']."</th>";
          echo "<th>".$value['User']['correct']."</th>";
          echo "<th>".$value['User']['total']."</th>";
        }
      echo "</tr>";
    ?>
  </table>
</body>
