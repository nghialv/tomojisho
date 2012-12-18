<?php
/*game skeleton controller*/
App::uses('AppController', 'Controller');
class GameController extends AppController {

  public function display() {
    $fb_friends = $this->Game->getFriends();
    $this->set('friends', $fb_friends);
    $this->render('/Game/index');
  }

}
?>
