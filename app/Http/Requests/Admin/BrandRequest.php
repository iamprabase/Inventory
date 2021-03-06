<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class BrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    { 
      
      $rules = [  
        'name' => 'required|unique:brands|max:191' 
      ];

      if($this->getMethod() == 'PUT' || $this->getMethod() == 'PATCH') $rules['name'] .= ',id, ' . $this->request->get("id");

      return $rules;
    }
}
