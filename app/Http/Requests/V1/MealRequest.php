<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class MealRequest extends FormRequest
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
            'per_page' => 'integer',
            'page' => 'integer',
            'category' => ['sometimes', 'regex:/^(null|!null|\d+)$/i'],
            'tags' => 'sometimes|array',
            'tags.*' => 'integer',
            'with' => 'sometimes|array',
            'with.*' => 'in:ingredients,tags,category',
            'diff_time' => 'integer',
            'lang' => 'required|string|size:2',
            ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('tags') && is_string($this->tags)) {
            $this->merge([
                'tags' => explode(',', $this->tags),
            ]);
        }

        if ($this->has('with') && is_string($this->with)) {
            $this->merge([
                'with' => explode(',', $this->with),
            ]);
        }
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}
