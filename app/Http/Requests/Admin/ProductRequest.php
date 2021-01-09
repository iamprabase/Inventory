<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProductRequest extends FormRequest
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
        'name' => 'required|max:191',
        'sku' => 'required|unique:products|max:100',
        'available_quantity' => 'required|integer|min:0',
        'quantity_level_reminder' => 'required|integer|min:0',
        'price' => "required|regex:/^\d+(\.\d{1,2})?$/",
        'purchase_price' => "required|regex:/^\d+(\.\d{1,2})?$/"
      ];

      if($this->getMethod() == 'PUT' || $this->getMethod() == 'PATCH'){ 
        $rules['sku'] .= ',id, ' . $this->product->id;
      }

      return $rules;
    }
}
