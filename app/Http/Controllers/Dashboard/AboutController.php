<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function editAbout()
    {
        $about = About::first();
        return view('dashboard.pages.about', compact('about'));
    }

    // Method to update the existing row
    public function updateAbout(Request $request)
    {
        try {
            // Validation
            $request->validate([
                'main_title_ar' => 'nullable|string',
                'main_title_en' => 'nullable|string',
                'desc_1_ar' => 'nullable|string',
                'desc_1_en' => 'nullable|string',
                'desc_2_ar' => 'nullable|string',
                'desc_2_en' => 'nullable|string',
            ]);

            // Fetch the first record
            $about = About::first();

            // If no record exists, create one
            if (!$about) {
                $about = new About();
            }

            // Update system setup with new data
            $about->main_title_ar = $request->main_title_ar;
            $about->main_title_en = $request->main_title_en;
            $about->desc_1_ar = $request->desc_1_ar;
            $about->desc_1_en = $request->desc_1_en;
            $about->desc_2_ar = $request->desc_2_ar;
            $about->desc_2_en = $request->desc_2_en;

            $about->save();

            toastr()->success('About Page Updated Successfully');

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
