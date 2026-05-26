<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreErrorLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:10000'],
            'stack_trace' => ['nullable', 'string', 'max:50000'],
            'error_type' => ['nullable', 'string', 'max:255'],
            'severity_level' => ['nullable', 'string', 'in:debug,info,warning,error,fatal'],
            'device_model' => ['nullable', 'string', 'max:255'],
            'os_version' => ['nullable', 'string', 'max:255'],
            'flutter_version' => ['nullable', 'string', 'max:255'],
            'app_version' => ['nullable', 'string', 'max:255'],
            'custom_payload' => ['nullable', 'array'],
            'timestamp' => ['nullable', 'date'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'severity_level' => $this->input('severity_level', 'error'),
        ]);
    }
}
