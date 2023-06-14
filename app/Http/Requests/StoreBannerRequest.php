<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
         //dd($this);
         $file = $this->file('image');
         //dd($file->getClientMimeType());
        return [
            'text' => 'required',
            'image' => 'required|image|mimes:png,jpg|max:4086',
            'sort_order' => 'required|unique:banners,sort_order|gt:0',
            //dd($this),
        ];
    }
}
// 'media_name.*' => 'image|max:2048|mimes:jpg,jpeg,png,',
