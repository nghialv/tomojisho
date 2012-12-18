<?php
  var $facebook;
  var $fb_user;

  class FBComponent extends Object {
    function __construct($request=null, $response=null) {
      parent::__construct($request, $response);
      App::import('Vendor', 'facebook/src/facebook');
      $this->facebook = new Facebook(array(
            'appId' => Configure::read('Facebook.appId'),
            'secret' => Configure::read('Facebook.secret'),
            'cookie' => true,
      ));
    }

    function beforeFilterFunc(){
      $this->fb_user = $this->facebook->getUser();

      if(empty($this->fb_user)) {
        $this->redirect($this->facebook->getLoginUrl(array(
        'scope' => Configure::read('Facebook.scope'),
        'redirect_uri' => Configure::read('Facebook.appUrl')
        )));
      } else {
        $fb_user_info = $this->facebook->api('/'.$this->fb_user);
      }
    }

    function getFriends()
    {
      $this->beforeFilterFunc();
      $fb_friends = $this->facebook->api('/me/friends');
      return $fb_friends;
    }
  }
?>
