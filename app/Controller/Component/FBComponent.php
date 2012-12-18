<?php
  class FBComponent extends Object {
    var $facebook;
    var $fb_user;

    function __construct($request=null, $response=null) {
      parent::__construct($request, $response);
      App::import('Vendor', 'facebook/src/facebook');
      $this->facebook = new Facebook(array(
            'appId' => Configure::read('Facebook.appId'),
            'secret' => Configure::read('Facebook.secret'),
            'cookie' => true,
      ));
    }

    function checkLogin(){
      $this->fb_user = $this->facebook->getUser();
      if(empty($this->fb_user))
        return false;
      return true;
    }

    function getFriends()
    {
      $fb_friends = $this->facebook->api('/me/friends');
      return $fb_friends;
    }
  }
?>
