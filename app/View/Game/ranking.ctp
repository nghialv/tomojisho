<title>tomojisho ranking</title>
<head>OVERALL RANKING</head>
<body>
  <table border="1">
    <?php
      echo "<tr>";
        foreach ($data as $value) {
          echo "<th>".$value['User']['user_name']."</th>";
          echo "<th>".$value['User']['correct']."</th>";
          echo "<th>".$value['User']['total']."</th>";
        }
      echo "</tr>";
    ?>
  </table>
</body>
