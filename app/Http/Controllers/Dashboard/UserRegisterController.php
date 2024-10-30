<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UserRegister;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;



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

        // If user exists, check if they registered more than 24 hours ago
        if ($existingUser) {
            $registrationTime = Carbon::parse($existingUser->created_at);
            $currentTime = Carbon::now();

            if ($registrationTime->diffInHours($currentTime) < 24) {
                // User registered within the last 24 hours
                return response()->json([
                    'status' => 'info',
                    'message' => __('You have registered before, please wait 24 hours to register again.')
                ], 200);
            }
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user_registers,email',
            'phone' => 'required|string|max:15',
            'message' => 'nullable|string',
            'time' => 'nullable|date_format:H:i',
            'date' => 'nullable|date_format:Y-m-d',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'phone.required' => 'The phone field is required.',
            'phone.string' => 'The phone number must be a string.',
            'phone.max' => 'The phone number may not be greater than 15 characters.',
            'time.date_format' => 'The time must be in the format HH:MM.',
            'date.date_format' => 'The date must be in the format YYYY-MM-DD.',
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create a new user
        $formData = new UserRegister();
        $formData->name = $request->name;
        $formData->email = $request->email;
        $formData->phone = $request->phone;
        $formData->message = $request->message;
        $formData->time = $request->time;
        $formData->date = $request->date;
        $formData->save();

        // Return success response
        return response()->json([
            'status' => 'success',
            'data' => $formData,
            'message' => __('You have registered successfully. We will contact you soon.')
        ], 200);

    } catch (\Throwable $e) {
        // Catch any general errors
        return response()->json([
            'status' => 'error',
            'message' => __('Sorry, please try again.'),
            'error' => $e->getMessage() // Optional: Include error details for debugging
        ], 500);
    }
}
}
