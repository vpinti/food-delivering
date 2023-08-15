<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('product.update');
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'price'       => ['required', 'numeric'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'price' => (int) ($this->price * 100),
        ]);
    }
}
