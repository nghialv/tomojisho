<div id="startgame-div">
  <h1>Tomojisho</h1>
  <button onClick="startGame();"></button>
</div>

<div id="loading-status-div" style=" display: none; position: fixed; top: 145px; left: 242px; width: 550px; height: 500px; z-index: 2000;text-align: center">
  <img src="../img/loading.gif" style="margin-left: 10px; height: 200px;"/>
  <p style="color: white; font-size: 20px;">質問のロード中</p>
</div>

<script type="text/javascript">
  function startGame(){
      // show loading status
      $("#popup-background").show();
      $('#loading-status-div').show();
      window.location.href="/Game/display";
    }

  $(document).ready(function(){
    sessionStorage.started = 1;
    sessionStorage.totalguess = 0;
    sessionStorage.correctguess = 0;
  });
</script>
