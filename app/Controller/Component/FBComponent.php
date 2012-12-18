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
      return $fb_friends['data'];
    }

    function getStatuses($userid=0)
    {
      $friendStatus = $this->facebook->api(array(
                         'method' => 'fql.query',
                         'query' => 'SELECT message FROM status WHERE uid='.(string)$userid
                     ));
      return $friendStatus;
    }

    function getPhotos($userid=0)
    {
      $photos = $this->facebook->api(array(
                      'method' => 'fql.query',
                      'query' => 'SELECT src_big FROM photo WHERE aid IN (SELECT aid FROM album WHERE owner='.(string)$userid.')'
                      ));
      return $photos;
    }
  }
?>
