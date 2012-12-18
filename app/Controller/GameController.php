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
    $seed = time();
    var_dump($seed);
    $fnum = count($fb_friends);
    $f1 = srand($seed) % $fnum;
    
    while ($f2 != $f1) {
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
    $correctans = rand(1,2);
    $friends = $this->getRandomFriends();
    $statuses = $this->FB->getStatuses($friends[$correctans]['id']);
      
    $snum = count($statuses);
    $sindex = rand(1, $snum);

    return array("friends" => $friends, "type" => "status", "data" => $statuses[$sindex] );
  }
  
  public function display() {
    $data = $this->setDataToDisp(); 
    $this->set('data', $data);
    $this->render('/Game/index');
  }
}
?>
