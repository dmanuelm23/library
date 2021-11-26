<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBookPost extends FormRequest
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
     * @param StoreBookPost $request
     * @return array
     * 
     */
    public function rules()
    {
        $max="max:255";

        return [
            'name' => ['required','unique:books,name,NULL,id,deleted_at,NULL', $max],
            'author' => ['required', $max],
            'publication_date' => ['required', 'date', $max],
            'category_id' => ['required', $max],
            
        ];
    }

    /**
     * Function to get messages from the validation rules that apply to the request.
     * @author Luis Daniel Manuel Martínez |  luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param StoreBookPost $request
     * @return array
     * 
     */
    public function messages()
    {
        return [
            'name.required'=>'The name of the book is required.',
            'name.unique'=>'This book name already exists.',
            'author.required'=>'The author is required.',
            'publication_date.required'=>'Publication date is required.',
            'publication_date.date'=>'The wrong date.',
            'category_id.required'=>'Category is required.',
        ];
    }

    /**
     * Response messages 
     * @author Luis Daniel Manuel Martínez |  luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param  Validator $validator
     * @throws StoreBookPost
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
