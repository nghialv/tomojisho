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
    $f1 = rand(1, count($fnum)-1);
    $f2 = rand($f1+1, count($fnum));
    
    //return friends info
    return array( 1=>$fb_friends[$f1],
                  2=>$fb_friends[$f2]);
  }
 
  private function setDataToDisp() {
    $correctans = rand(1,2);
    $friends = $this->getRandomFriends();
    $statuses = $this->FB->getStatuses($friends[$correctans]['id']);
    var_dump($statuses[0]);
      
    $snum = count($statuses);
    var_dump($snum);

    $sindex = rand(1, $snum);
    var_dump($sindex);

    $correctstas = $statuses[$sindex];
    var_dump($correctans);

    return array("friends" => $friends, "type" => "status", "data" => $correctans );
  }
  
  public function display() {
    
    $data = $this->setDataToDisp(); 
    $this->set('data', $data);
    $this->render('/Game/index');
  }
}
?>
