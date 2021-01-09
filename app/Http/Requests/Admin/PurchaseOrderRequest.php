<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PurchaseOrderRequest extends FormRequest
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
        // 'name' => 'required|max:191',
        // 'contact_person' => 'required|max:191',
        // 'email' => 'required|max:100|unique:suppliers',
        // 'phone_number' => 'nullable|string|min:8|max:15|unique:suppliers',
      ];

      // if($this->getMethod() == 'PUT' || $this->getMethod() == 'PATCH'){ 
      //   $rules['email'] .= ',id, ' . $this->supplier->id;
      //   $rules['phone_number'] .= ',id, ' . $this->supplier->id;
        
      // }

      return $rules;
    }
}
