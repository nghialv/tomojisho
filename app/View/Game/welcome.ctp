<div id="startgame-div">
  <h1>Tomojisho</h1>
  <button onClick="window.location.href='/Game/display'"></button>
</div>
<script type="text/javascript">
  $(document).ready(function(){ 
    sessionStorage.started = 1;
    sessionStorage.totalguess = 0;
    sessionStorage.correctguess = 0;
  });
</script>
