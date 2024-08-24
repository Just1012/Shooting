<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Hiring;
use App\Models\HiringPage;
use Illuminate\Http\Request;

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
                Toastr()->info(__('You Are Registered Before, Wait until We Contact You'), __('Info'));
                return redirect()->back();
            }

            // Validate the request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:user_registers,email',
                'phone' => 'required|string|max:15',
                'message' => 'nullable|string',
                'section' => 'required|in:0,1', // Ensure section only accepts 0 or 1
                'file' => 'required|file|mimes:pdf,txt,doc,docx|max:10240', // Allow PDF, TXT, DOC, DOCX files, max size 10MB
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
                'section.in' => 'The section must be either 0 or 1.', // Custom message for section
                'file.required' => 'The file is required.',
                'file.mimes' => 'The file must be a PDF, TXT, DOC, or DOCX.',
                'file.max' => 'The file size may not be greater than 10MB.',
            ]);

            // Create a new user instance
            $formData = new Hiring();
            $formData->name = $request->name;
            $formData->email = $request->email;
            $formData->phone = $request->phone;
            $formData->message = $request->message;
            $formData->section = $request->section;

            // Handle file upload
            if ($request->hasFile('file')) {
                // Create a unique name for the uploaded file
                $pdfName = time() . '.' . $request->file('file')->getClientOriginalExtension();

                // Ensure the directory exists
                $uploadPath = public_path('uploads/files');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true); // Create directory if it doesn't exist
                }

                // Move the file to the uploads/files directory
                $request->file('file')->move($uploadPath, $pdfName);

                // Save the file name in the database
                $formData->file = $pdfName;
            }

            // Save the form data
            $formData->save();

            // Display success message
            Toastr()->success(__('You have registered successfully. We will contact you soon!'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $e) {
            // Display error message
            Toastr()->error(__('Sorry, please try again.'), __('Error'));
            return redirect()->back()->withInput();
        }
    }
}
