<?php
  class Game extends AppModel{

    public function getFriends()
    {
      $fb_friends = $this->facebook->api('/me/friends');
      return $fb_friends;
    }
  }
?>
