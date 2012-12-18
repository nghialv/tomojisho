<?php
/*game skeleton controller*/
App::uses('AppController', 'Controller');
class GameController extends AppController {
  var $components = array('FB');

  public function display() {
    $fb_friends = $this->FB->getFriends();
    $this->set('friends', $fb_friends);
    $this->render('/Game/index');
  }

}
?>
