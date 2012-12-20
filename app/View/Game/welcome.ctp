<div id="startgame-div">
  <h1>Tomojisho</h1>
  <button onClick="window.location.href='/Game/display'"></button>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    localStorage.started = 1;
    localStorage.totalguess = 0;
    localStorage.correctguess = 0;
  });
<script>
