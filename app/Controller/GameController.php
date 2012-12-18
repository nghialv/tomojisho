<?php
/*game skeleton controller*/
App::uses('AppController', 'Controller');
class GameController extends AppController {
  var $components = array('FB');

  public function beforeFilter()
  {
    if(!$this->FB->checkLogin())
    {
       $this->redirect($this->FB->facebook->getLoginUrl(array(
        'scope' => Configure::read('Facebook.scope'),
        'redirect_uri' => Configure::read('Facebook.appUrl')
        )));
    }
  }

  public function display() {
    $fb_friends = $this->FB->getFriends();
    $this->set('friends', $fb_friends);
    $this->render('/Game/index');
  }

}
?>
