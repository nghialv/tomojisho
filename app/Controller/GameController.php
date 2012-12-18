<?php
/*game skeleton controller*/
App::uses('AppController', 'Controller');
class GameController extends AppController {

  public $fb_user;
  public $fb_username;

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

      $friendsLists = $this->facebook->api('/me/friends');
      $this->set('friends', $friendsLists);

      $this->set('user_id', $this->fb_user);
      $this->set('user_name', $this->fb_username);
      $this->set('app_url', Configure::read('Facebook.appUrl'));
    }
  }


  public function display() {
    $this->render('/game/index');
  }

}
?>
