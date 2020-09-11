<?php

namespace App\Http\Traits;

trait FlashMessage{
  protected $errorMessages = array();

  protected $successMessages = array();

  protected function setFlashMessage($message, $type){
    // dd($type);
    $model = 'successMessages';

    switch($type){
      case 'success':
        $model = 'successMessages';
      break;

      case 'error':
        $model = 'errorMessages';
      break;

      default: 
        $model = 'successMessages';
      break;
    }
    if(is_array($message)){
      foreach($message as $msg){
        array_push($this->$model, $msg);
      }
    }else{
      array_push($this->$model, $message);
    }
  }

  protected function getFlashMessage(){
    return array(
      'success' => $this->successMessages,
      'error' => $this->errorMessages,
    );
  }

  protected function displayFlashMessage(){
    session()->flash('error', $this->errorMessages);
    session()->flash('success', $this->successMessages);
  }
}