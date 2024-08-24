<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UserRegister;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class UserRegisterController extends Controller
{
    public function index()
    {
        return view('dashboard.users.userRegister');
    }

    public function dataTable()
    {
        $data = UserRegister::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }
    public function storeUser(Request $request)
    {
        try {
            // Check if the email or phone already exists
            $existingUser = UserRegister::where('email', $request->email)
                ->orWhere('phone', $request->phone)
                ->first();

            if ($existingUser) {
                Toastr()->info(__('You Are Registered Before, Wait until Call you'), __('Info'));
                return redirect()->back();
            }

            // Validate the request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:user_registers,email',
                'phone' => 'required|string|max:15',
                'message' => 'nullable|string',
                'time' => 'nullable|date_format:H:i',
                'date' => 'nullable|date_format:Y-m-d',
            ], [
                'name.required' => 'The name field is required.',
                'name.string' => 'The name must be a string.',
                'name.max' => 'The name may not be greater than 255 characters.',
                'email.required' => 'The email field is required.',
                'email.email' => 'The email must be a valid email address.',
                'email.max' => 'The email may not be greater than 255 characters.',
                'email.unique' => 'The email has already been taken.',
                'phone.required' => 'The phone field is required.',
                'phone.string' => 'The phone number must be a string.',
                'phone.max' => 'The phone number may not be greater than 15 characters.',
                'time.date_format' => 'The time must be in the format HH:MM.',
                'date.date_format' => 'The date must be in the format YYYY-MM-DD.',
            ]);

            // Create a new user
            $formData = new UserRegister();
            $formData->name = $request->name;
            $formData->email = $request->email;
            $formData->phone = $request->phone;
            $formData->message = $request->message;
            $formData->time = $request->time;
            $formData->date = $request->date;
            $formData->save();

            // Optionally, send an email (commented out for now)
            // Mail::to('expo@sfma.sa')->send(new RegisterMail());

            // Display success message
            Toastr()->success(__('You Have Registered Successfully, We will Contact with you Soon'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $e) {
            // Catch any general errors
            Toastr()->error(__('Sorry, please try again.'), __('Error'));
            return redirect()->back()->withInput();
        }
    }
}
