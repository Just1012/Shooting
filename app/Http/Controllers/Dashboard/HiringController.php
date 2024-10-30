<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Hiring;
use App\Models\HiringPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class HiringController extends Controller
{
    public function index()
    {
        return view('dashboard.users.userHiring');
    }

    public function dataTable()
    {
        $data = Hiring::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }
 public function storeUser(Request $request)
{
    try {
        // Check if the email or phone already exists
        $existingUser = Hiring::where('email', $request->email)
            ->orWhere('phone', $request->phone)
            ->first();

        if ($existingUser) {
            return response()->json([
                'status' => 'info',
                'message' => __('You Are Registered Before, Wait until We Contact You.')
            ], 200);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:hiring,email',
            'phone' => 'required|string|max:15',
            'message' => 'nullable|string',
            'section' => 'required|in:0,1', // Ensure section only accepts 0 or 1
            'file' => 'required|file|mimes:pdf,txt,doc,docx|max:10240', // Allow PDF, TXT, DOC, DOCX files, max size 10MB
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'phone.required' => 'The phone field is required.',
            'section.in' => 'The section must be either 0 or 1.',
            'file.required' => 'The file is required.',
            'file.mimes' => 'The file must be a PDF, TXT, DOC, or DOCX.',
            'file.max' => 'The file size may not be greater than 10MB.',
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create a new user instance
        $formData = new Hiring();
        $formData->name = $request->name;
        $formData->email = $request->email;
        $formData->phone = $request->phone;
        $formData->message = $request->message;
        $formData->section = $request->section;

        // Handle file upload
        if ($request->hasFile('file')) {
            // Store the file in the 'public/uploads/files' directory
            $filePath = $request->file('file')->store('uploads/files', 'public');

            // Save the file path in the database
            $formData->file = $filePath;
        }

        // Save the form data
        $formData->save();

        // Return success response
        return response()->json([
            'status' => 'success',
            'data' => $formData,
            'message' => __('You have registered successfully. We will contact you soon!')
        ], 200);
    } catch (\Throwable $e) {
        // Return error response
        return response()->json([
            'status' => 'error',
            'message' => __('Sorry, please try again.'),
            'error' => $e->getMessage() // Optional: Include error details for debugging
        ], 500);
    }
}
}
