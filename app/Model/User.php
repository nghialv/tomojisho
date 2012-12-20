<?php
  class User extends AppModel {
    public $name = 'User';    

    public function beforeSave() {
      return parent::beforeSave();  
    }
  }
?>

