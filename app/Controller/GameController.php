<?php
/*game skeleton controller*/
App::uses('AppController', 'Controller');
class GameController extends AppController {
  public function display() {
    $this->render('/game/index');   
  }  
}
?>
