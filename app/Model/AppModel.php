<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
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

  public function beforeFilter(){
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
}
