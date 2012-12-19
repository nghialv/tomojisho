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

    //return friends info
    return array( 1=>$fb_friends[$f1],
                  2=>$fb_friends[$f2]);
  }
 
  private function setDataToDisp() {
    $MAX_LOOP = 100;
    $error = -1;
    $count = 0;
    $data = NULL;

    while ($error == -1) {
      try {
        $correctans = rand(1,2);
        $error = 0;
        $count += 1;

        if($count >= $MAX_LOOP) break;
        $friends = $this->getRandomFriends();
        $statuses = $this->FB->getStatuses($friends[$correctans]['id']);
          
        $snum = count($statuses);
        $sindex = rand(1, $snum-1);
        if(!isset($statuses[$sindex]))
          $error = -1;
      }
      catch (Exception $e) {
        $error = -1; 
        var_dump($statuses);
      }
    }
    return array("friends" => $friends, "type" => "status", "data" => $data, "ans" => $correctans);
  }
  
  public function display() {
    $data = $this->setDataToDisp(); 
    $this->set('data', $data);
    $this->render('/Game/index');
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
}
?>
