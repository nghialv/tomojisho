<?php
/*game skeleton controller*/
App::uses('AppController', 'Controller');
class GameController extends AppController {

  public $fb_user;
  public $fb_username;
  public $fb_friends;

   public function beforeFilter(){
    $this->fb_user = $this->facebook->getUser();

    if(empty($this->fb_user)) {
      $this->redirect($this->facebook->getLoginUrl(array(
      'scope' => Configure::read('Facebook.scope'),
      'redirect_uri' => Configure::read('Facebook.appUrl')
    )));
    } else {
      $fb_user_info = $this->facebook->api('/'.$this->fb_user);
      $this->fb_username = $fb_user_info['name'];

      $fb_friends = $this->facebook->api('/me/friends');
      $this->set('friends', $fb_friends);

      $this->set('username', $this->fb_username);
    }
  }


  public function display() {
    $this->render('/Game/index');
  }

}
?>
