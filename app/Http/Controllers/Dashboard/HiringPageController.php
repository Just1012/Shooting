<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HiringPage;
use Illuminate\Http\Request;

class HiringPageController extends Controller
{
    public function editHiringPage()
    {
        $hiringPage = HiringPage::first();
        return view('dashboard.pages.hiringPgae', compact('hiringPage'));
    }

    // Method to update the existing row
    public function updateHiringPage(Request $request)
    {
        try {
            // Validation
            $request->validate([
                'head_sentence_ar' => 'nullable|string',
                'head_sentence_en' => 'nullable|string',

                'welcome_title_ar' => 'nullable|string',
                'welcome_title_en' => 'nullable|string',

                'hiring_title_ar' => 'nullable|string',
                'hiring_title_en' => 'nullable|string',
                'hiring_desc_ar' => 'nullable|string',
                'hiring_desc_en' => 'nullable|string',

                'training_title_ar' => 'nullable|string',
                'training_title_en' => 'nullable|string',
                'training_desc_ar' => 'nullable|string',
                'training_desc_en' => 'nullable|string',

                // Image validation
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // max 2MB
            ], [
                'head_sentence_ar.string' => 'The Arabic headline must be a string.',
                'head_sentence_en.string' => 'The English headline must be a string.',
                'welcome_title_ar.string' => 'The Arabic title must be a string.',
                'welcome_title_en.string' => 'The English title must be a string.',
                'hiring_title_ar.string' => 'The Arabic hiring title must be a string.',
                'hiring_title_en.string' => 'The English hiring title must be a string.',
                'hiring_desc_ar.string' => 'The Arabic hiring description must be a string.',
                'hiring_desc_en.string' => 'The English hiring description must be a string.',
                'training_title_ar.string' => 'The Arabic training title must be a string.',
                'training_title_en.string' => 'The English training title must be a string.',
                'training_desc_ar.string' => 'The Arabic training description must be a string.',
                'training_desc_en.string' => 'The English training description must be a string.',
                'image.image' => 'Please upload a valid image.',
                'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
                'image.max' => 'The image size should not exceed 2MB.',
            ]);

            // Fetch the first record
            $hiringPage = HiringPage::firstOrNew();

            // Update fields
            $hiringPage->head_sentence_ar = $request->head_sentence_ar;
            $hiringPage->head_sentence_en = $request->head_sentence_en;
            $hiringPage->welcome_title_ar = $request->welcome_title_ar;
            $hiringPage->welcome_title_en = $request->welcome_title_en;
            $hiringPage->hiring_title_ar = $request->hiring_title_ar;
            $hiringPage->hiring_title_en = $request->hiring_title_en;
            $hiringPage->hiring_desc_ar = $request->hiring_desc_ar;
            $hiringPage->hiring_desc_en = $request->hiring_desc_en;
            $hiringPage->training_title_ar = $request->training_title_ar;
            $hiringPage->training_title_en = $request->training_title_en;
            $hiringPage->training_desc_ar = $request->training_desc_ar;
            $hiringPage->training_desc_en = $request->training_desc_en;

            // Handle image upload
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $hiringPage->image = $imageName;
            }

            // Save the data
            $hiringPage->save();

            toastr()->success('Hiring Page Updated Successfully');
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

    public function getHiringPageApi()
    {
        $hiringPage = HiringPage::first();
        unset(
            $hiringPage->head_sentence_ar,
            $hiringPage->head_sentence_en,
            $hiringPage->welcome_title_ar,
            $hiringPage->welcome_title_en,
            $hiringPage->hiring_title_ar,
            $hiringPage->hiring_title_en,
            $hiringPage->hiring_desc_ar,
            $hiringPage->hiring_desc_en,
            $hiringPage->training_title_ar,
            $hiringPage->training_title_en,
            $hiringPage->training_desc_ar,
            $hiringPage->training_desc_en,
        );
        return response()->json($hiringPage);
    }
}
