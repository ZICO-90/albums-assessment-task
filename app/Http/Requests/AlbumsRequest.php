<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
class AlbumsRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [ 'album' => 'required|min:3|max:255|string',
                'file.*' => 'required|mimetypes:image/jpeg,image/x-png,image/jpg,image/png',
                'name_photos.*' => 'required|min:3|max:255|string',
        ];
    }
    public function messages(): array
            {
                return [
                     'required' => ':attribute : هذا الحقل مطلوب',
                     'min' =>  'يجب ان ألا يقل :attribute عن :min أحرف',        
                     'mimetypes' => ':attribute : يجب أن يكون ملفًا من النوع (png , jpg )'

                ];
            }
            /**
             * @return array<string>
             */
            public function attributes(): array
            {
                return [
                    'album' => 'اسم الالبوم',
                    'file' => 'مرفقات الصور',
                    'name_photos.*' => 'اسماء الصورة',
                ];
            }


            public function response(array $errors)
            {
                if ($this->expectsJson()) {
                    
                    return new JsonResponse($errors, 422);
                }
                
            }
}
