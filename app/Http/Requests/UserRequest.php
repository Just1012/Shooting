<?php

namespace App\Http\Requests;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
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
    public function rules()
    {
        return [
            'id'        => 'nullable|exists:users,id',
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email,' . $this->id,
            'password'  => 'nullable|string|min:8|required_if:id,null',
            'role_id'   => 'required|exists:roles,id',

        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'         => 'حقل الاسم مطلوب.',
            'name.string'           => 'يجب أن يكون الاسم نصًا.',
            'name.max'              => 'قد لا يكون الاسم أكبر من :max أحرف.',

            'email.required'        => 'حقل البريد الإلكتروني مطلوب.',
            'email.email'           => 'يجب أن يكون البريد الإلكتروني عنوان بريد إلكتروني صالح.',
            'email.max'             => 'قد لا يكون البريد الإلكتروني أكبر من :max حرف.',
            'email.unique'          => 'تم استخدام هذا البريد الإلكتروني بالفعل.',

            'password.string'       => 'يجب أن تكون كلمة المرور نصًا.',
            'password.min'          => 'يجب أن تتكون كلمة المرور من ما لا يقل عن :min أحرف.',
            'password.required_if'  => 'حقل كلمة المرور مطلوب عندما لا يتم تقديم الهوية.',

            'role_id.required'      => 'حقل معرف الدور مطلوب.',
            'role_id.exists'        => 'الدور المحدد غير صالح.',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errorMessages = $validator->errors()->all();

        // Display each error message with Toastr
        foreach ($errorMessages as $errorMessage) {
            toastr()->error($errorMessage, 'Error');
        }

        parent::failedValidation($validator);
    }
}
