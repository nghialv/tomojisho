<?php

App::import('Component', 'FB');
App::uses('AppController', 'Controller');

class GameController extends AppController {
  var $FB=NULL;
  /*
  public function __contruct($resquest=null, $respond=null)
  {
    parent::__construct($request, $response);
    $this->FB = new FBComponent();
  }
  */

  public function beforeFilter()
  {
    if(!isset($this->FB))
      $this->FB = new FBComponent();

    if(!$this->FB->checkLogin())
    {
       $this->redirect($this->FB->facebook->getLoginUrl(array(
        'scope' => Configure::read('Facebook.scope'),
        'redirect_uri' => Configure::read('Facebook.appUrl')
        )));
    }
  }

  private function getRandomFriends() {
    $fb_friends = $this->FB->getFriends();

    //gen random number
    $fnum = count($fb_friends);
    $f1 = time() % $fnum;
    $f2 = $f1;

    while ($f2 == $f1) {
      if ($f1 <= $fnum/2)
        $f2 = rand($f1+1, $fnum);
      else
        $f2 = rand(1, $f1-1);
    }
    $ava1 = $this->FB->getAvatar($fb_friends[$f1]['id']);
    $ava2 = $this->FB->getAvatar($fb_friends[$f2]['id']);

    $fb_friends[$f1]['avatar'] = $ava1;
    $fb_friends[$f2]['avatar'] = $ava2;

    //return friends info
    return array( 1=>$fb_friends[$f1],
                  2=>$fb_friends[$f2]);
  }

  private function setDataToDisp() {
    $MAX_LOOP = 100;
    $CRITERION = array(1=>"image", 2=>"status");
    
    $error = -1;
    $count = 0;
    $data = NULL;
    $criter = $CRITERION[rand(1, count($CRITERION))];
    $features = NULL;
    
    while ($error == -1) {
      try {
        $correctans = rand(1,2);
        $error = 0;
        $count += 1;

        if($count >= $MAX_LOOP) break;
        $friends = $this->getRandomFriends();
        if ($criter == "status")             
          $features = $this->FB->getStatuses($friends[$correctans]['id']);
        else if ($criter == "image")
          $features = $this->FB->getPhotos($friends[$correctans]['id']);
        
        $snum = count($features);
        $sindex = rand(1, $snum-1);
        
        if(!isset($features[$sindex]))
          $error = -1;
        else
          $data = $features[$sindex];
      }
      catch (Exception $e) {
        $error = -1;
        var_dump($features);
      }
    }
    return array("friends" => $friends, "type" => $criter, "data" => $data, "ans" => $correctans);
  }

  public function display() {
    $data = $this->setDataToDisp();
    $this->set('data', $data);
    $this->render('/Game/index');
  }

  public function welcome() {
    $this->render('/Game/welcome');
  }

  public function judge() {
    $this->autoLayout = false;

    $choose = $_POST['choose'];
    $ans = $_POST['ans'];
    if ($choose % 2 == $ans % 2) {
      $this->set('data', 'true');
      $this->render('/Game/serialize');
    }
    else {
      $this->set('data', 'false');
      $this->render('/Game/serialize');
    }
  }

  public function endgame(){
    $correct = $_POST['correct'];
    $total = $_POST['total'];
    
    $message = "has just got ".$correct."/".$total;
    $this->FB->postToWall($message);
    $me = $this->FB->fb_user;
    $this->User->save(array(
        'user_id' => $me['id'],
        'user_name' => $me['name'],
        'correct' => $correct,
        'total' => $total
    ));

    $this->render('/Game/welcome');
  }
}
?>
