<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCategoryPut extends FormRequest
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
     * Function to get the validation rules that apply to the request.
     * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param UpdateCategoryPut $request
     * @return array
     * 
     */
    public function rules()
    {
        $max="max:255";
        $category = Category::findOrFail($this->id);
        return [
            'name' => "required|unique:categories,name,{$category->id},id,deleted_at,NULL|".$max,
            'description' => ['required'],
        ];
    }

    /**
     * Function to get messages from the validation rules that apply to the request.
     * @author Luis Daniel Manuel Martínez |  luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param UpdateCategoryPut $request
     * @return array
     * 
     */
    public function messages()
    {
        return [
            'name.required'=>'The name of the category is required.',
            'name.unique'=>'This category name already exists.',
            'description.required'=>'The desription is required.',
        ];
    }

    /**
     * Response messages 
     * @author Luis Daniel Manuel Martínez |  luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param  Validator $validator
     * @throws UpdateCategoryPut
     */
    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'statusCode' => 422,
            'message'    => 'Unprocessable Entity',
            'errors'     => $validator->errors()
        ], 422);
        throw new HttpResponseException($response);
    }
}
