<?php

namespace App\Http\Controllers\Dashboard;


use App\Models\SystemSetup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;



class SystemSetupController extends Controller
{
    public function editSystemSetup()
    {
        $systemSetup = SystemSetup::first();
        return view('dashboard.setting.systemSetup', compact('systemSetup'));
    }

    // Method to update the existing row
    public function updateSystemSetup(Request $request)
    {
        try {
            // Validation
            $request->validate([
                'header_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'footer_gif' => 'nullable|image|mimes:gif|max:2048',
                'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'footer_quote_ar' => 'nullable|string|max:255',
                'footer_quote_en' => 'nullable|string|max:255',
            ], [
                'header_logo.image' => 'The header logo must be an image file.',
                'header_logo.mimes' => 'The header logo must be a file of type: jpeg, png, jpg, gif.',
                'header_logo.max' => 'The header logo may not be greater than 2048 kilobytes.',

                'footer_gif.image' => 'The footer GIF must be an image file.',
                'footer_gif.mimes' => 'The footer GIF must be a file of type: gif.',
                'footer_gif.max' => 'The footer GIF may not be greater than 2048 kilobytes.',

                'footer_logo.image' => 'The footer logo must be an image file.',
                'footer_logo.mimes' => 'The footer logo must be a file of type: jpeg, png, jpg.',
                'footer_logo.max' => 'The footer logo may not be greater than 2048 kilobytes.',

                'footer_quote_ar.string' => 'The footer quote (AR) must be a string.',
                'footer_quote_ar.max' => 'The footer quote (AR) may not be greater than 255 characters.',

                'footer_quote_en.string' => 'The footer quote (EN) must be a string.',
                'footer_quote_en.max' => 'The footer quote (EN) may not be greater than 255 characters.',
            ]);

            // Retrieve or create the SystemSetup instance
            $systemSetup = SystemSetup::first() ?? new SystemSetup();

            // Function to delete the old file
            $deleteOldFile = function ($filePath) {
                if ($filePath && Storage::exists('public/images/' . $filePath)) {
                    Storage::delete('public/images/' . $filePath);
                }
            };

            // Update or create the fields
            if ($request->hasFile('header_logo')) {
                // Delete the old header logo
                $deleteOldFile($systemSetup->header_logo);

                // Store the new header logo
                $headerLogoPath = $request->file('header_logo')->store('images', 'public');
                $systemSetup->header_logo = basename($headerLogoPath);
            }

            if ($request->hasFile('footer_gif')) {
                // Delete the old footer GIF
                $deleteOldFile($systemSetup->footer_gif);

                // Store the new footer GIF
                $footerGifPath = $request->file('footer_gif')->store('images', 'public');
                $systemSetup->footer_gif = basename($footerGifPath);
            }

            if ($request->hasFile('footer_logo')) {
                // Delete the old footer logo
                $deleteOldFile($systemSetup->footer_logo);

                // Store the new footer logo
                $footerLogoPath = $request->file('footer_logo')->store('images', 'public');
                $systemSetup->footer_logo = basename($footerLogoPath);
            }

            // Update text fields
            $systemSetup->footer_quote_ar = $request->input('footer_quote_ar');
            $systemSetup->footer_quote_en = $request->input('footer_quote_en');

            // Save the system setup
            $systemSetup->save();

            toastr()->success('System Setup Updated Successfully');

            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            foreach ($e->errors() as $error) {
                foreach ($error as $message) {
                    toastr()->error($message);
                }
            }
            return redirect()->back()->withInput();
        } catch (\Throwable $th) {
            toastr()->error('An error occurred. Please try again.');
            return redirect()->back()->withErrors(['error' => $th->getMessage()])->withInput();
        }
    }
}
