<?php

App::import('Component', 'FB');
App::uses('AppController', 'Controller');

class GameController extends AppController {
  var $FB;

  /*
  public function __contruct($resquest=null, $respond=null)
  {
    parent::__construct($request, $response);
    $this->FB = new FBComponent();
  }
  */
  public function beforeFilter()
  {
    $this->FB = new FBComponent();

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
    $fb_status = $this->FB->getStatuses($fb_friends['data'][0]['id']);
    $this->set('friends', $fb_friends);
    $this->set('statuses', $fb_status);
    $this->render('/Game/index');
  }
}
?>
