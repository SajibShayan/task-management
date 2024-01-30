<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTaskRequest extends FormRequest
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
        $rules = [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:incomplete,complete']
        ];
    
        if ($this->isMethod('PUT')) {
            $rules['title'][] = Rule::unique('tasks')->ignore($this->route('task')->id);
        } else {
            $rules['title'][] = Rule::unique('tasks');
        }
    
        return $rules;
    }
}
