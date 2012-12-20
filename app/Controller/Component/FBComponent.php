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
      if(!$this->checkToken())
        return false;
      return true;
    }

    function checkToken()
    {
      $u = $this->facebook->api(array(
                         'method' => 'fql.query',
                         'query' => 'SELECT uid2 FROM friend WHERE uid1= me() LIMIT 1'
                     ));
      if(empty($u))
        return false;
      return true;
    }

    function getCurrentUser()
    {
      $u = $this->facebook->api('/me');
      $avatar = $this->getAvatar($u['id']);
      $current_user = array('id' => $u['id'], 'name' => $u['name'], 'avatar' => $avatar);
      return $current_user;
    }

    function getFriends()
    {
      $fb_friends = $this->facebook->api('/me/friends');
      return $fb_friends['data'];
    }

    function getStatuses($userid=0)
    {
      $uid = (string)$userid;
      if($userid==0)
        $uid = 'me()';

     //$date = DateTime::createFromFormat('j-M-Y', '1-Jan-2011');
     //$from = $date->format('U');

      $status = $this->facebook->api(array(
                         'method' => 'fql.query',
                         'query' => 'SELECT message FROM status WHERE uid='.$uid.'ORDER BY time DESC LIMIT 10'
                     ));
      return $status;
    }

    function getPhotos($userid=0)
    {
      $uid = (string)$userid;
      if($userid==0)
        $uid = 'me()';

      //$date = DateTime::createFromFormat('j-M-Y', '1-Jan-2011');
      //$from = $date->format('U');

      $photos = $this->facebook->api(array(
                      'method' => 'fql.query',
                      'query' => 'SELECT src_big FROM photo WHERE aid IN (SELECT aid FROM album WHERE owner='.$uid.')'.'ORDER BY created DESC LIMIT 10'
                      ));
      return $photos;
    }

    // birthday_date, current_address
    function getUserInfor($userid=0, $field)
    {
      $uid = (string)$userid;
      if($userid==0)
        $uid = 'me()';

      $infor = $this->facebook->api(array(
                         'method' => 'fql.query',
                         'query' => 'SELECT '.$field.' FROM user WHERE uid='.$uid
                     ));
      return $infor[0][$field];
    }

    function getAvatar($userid=0)
    {
      $uid = (string)$userid;
      if($userid==0)
        $uid = 'me()';
      $avatar = $this->facebook->api(array(
                         'method' => 'fql.query',
                         'query' => 'SELECT pic_big FROM profile WHERE id='.$uid
                     ));
      return $avatar[0]['pic_big'];
    }

    function postToWall($message)
    {
      $this->facebook->api("/me/feed", "post", array('message' => $message));
    }
  }
?>
