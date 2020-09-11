<?php

namespace App\Http\Controllers;

use App\Http\Traits\FlashMessage;
use Illuminate\Http\Request;

class BaseController extends Controller
{
  use FlashMessage;

  protected $data = null;

  protected function setPageTitle($title, $subtitle){
    view()->share([
      'title' => $title,
      'subtitle' => $subtitle
    ]);
  }

  protected function showErrorPage($code, $message){
    $data['message'] = $message;
    return response()->view('errors.'.$code, $data, $code);
  }

  protected function responseJson($error = false, $responseCode = 200, $message = [], $data = null){
    return response()->json([
      'error' => $error,
      'statusCode' => $responseCode,
      'message' => $message,
      'data' => $data
    ]);
  }

  protected function responseRedirect($route, $message, $type = 'success', $error = false, $withOldInputError = false){
    $this->setFlashMessage($message, $type);
    $this->displayFlashMessage();

    if($withOldInputError){
      return redirect()->back()->withError();
    }

    return redirect()->route($route);
  }

  protected function resposeRedirectBack($message, $type = 'success', $error = false, $withOldInputError = false){
    $this->setFlashMessage($message, $type);
    $this->displayFlashMessage();

    return redirect()->route($route);
  }
}
