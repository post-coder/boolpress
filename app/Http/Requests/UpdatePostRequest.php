<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title' => 'max:255|required',
            'content' => 'required',
            'cover_image' => 'file|max:1024|nullable|mimes:jpg,bmp,png',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id'
        ];
    }

    public function messages(): array 
    {
        return [
            'title.max' => "Il titolo deve avere massimo :max caratteri",
            'title.required' => 'Devi inserire un titolo',

            'content.required' => 'Devi inserire il contenuto',

            'cover_image.mimes' => "Il file deve essere un'immagine",
            'cover_image.max' => "La dimensione del file non deve superare i 1024 KB",

            'category_id.exists' => 'Che pollo'
        ];
    }
}
