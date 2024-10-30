<?php

namespace App\Services;

use App\Models\EngineerCategory;
use Exception;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;

class UserService
{
    public function storeUser($request)
    {
        try {
            $requestData = $request->all();
            $oldImage = User::find($requestData['id'] ?? null)->image ?? null;



            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);
                $requestData['image'] = $imageName;

                if ($oldImage && file_exists(public_path('images/' . $oldImage))) {
                    unlink(public_path('images/' . $oldImage));
                }
            }

            if ($requestData['password'] == null) {
                unset($requestData['password']);
            }

            $user = User::updateOrCreate(
                ['id' => $requestData['id'] ?? null],
                $requestData
            );

          

            $successMessage = $requestData['id'] ? 'تم تعديل المستخدم بنجاح' : 'تم إضافة المستخدم بنجاح';
            toastr()->success($successMessage, 'تم بنجاح');

            return [$successMessage, $user['role_id']];
        } catch (\Throwable $th) {
            toastr()->error('أعد المحاولة', 'خطاء');
            return 'أعد المحاولة';
        }
    }


    public function getUser()
    {
        $data = User::all();
        return $data;
    }
}
