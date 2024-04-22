<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'unique:posts,title|max:255|required',
            'content' => 'required'
        ];
    }

    public function messages(): array 
    {
        return [
            'title.unique' => "È già presente un post con lo stesso titolo",
            'title.max' => "Il titolo deve avere massimo :max caratteri",
            'title.required' => 'Devi inserire un titolo',
            'content.required' => 'Devi inserire il contenuto'
        ];
    }
}
