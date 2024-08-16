<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class HomeSectionController extends Controller
{
    public function editHomeSection()
    {
        $sections = HomeSection::first();
        return view('dashboard.homePage.sections.sections', compact('sections'));
    }

    // Method to update the existing row
    public function updateHomeSection(Request $request)
    {

            // Validation with custom messages
            $request->validate([
                'header_section_ar' => 'nullable|string',
                'header_section_en' => 'nullable|string',
                'goals_title_ar'    => 'nullable|string|max:255',
                'goals_title_en'    => 'nullable|string|max:255',
                'goals_desc_ar'     => 'nullable|string',
                'goals_desc_en'     => 'nullable|string',
                'vision_title_ar'   => 'nullable|string|max:255',
                'vision_title_en'   => 'nullable|string|max:255',
                'vision_desc_ar'    => 'nullable|string',
                'vision_desc_en'    => 'nullable|string',
                'journey_title_ar'  => 'nullable|string|max:255',
                'journey_title_en'  => 'nullable|string|max:255',
                'journey_desc_ar'   => 'nullable|string',
                'journey_desc_en'   => 'nullable|string',
                'team_title_ar'     => 'nullable|string|max:255',
                'team_title_en'     => 'nullable|string|max:255',
                'team_desc_ar'      => 'nullable|string',
                'team_desc_en'      => 'nullable|string',

                // Validation for images
                'goals_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // max 2MB
                'vision_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',          // max 2MB, only GIF
                'journey_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // max 2MB
            ], [
                // Custom messages for image validation
                'goals_image.image' => 'The Goals Image must be an image file.',
                'goals_image.mimes' => 'The Goals Image must be a file of type: jpeg, png, jpg, gif, svg.',
                'goals_image.max'   => 'The Goals Image must not be larger than 2MB.',
                'vision_image.image' => 'The Vision Image must be an image file.',
                'vision_image.mimes' => 'The Vision Image must be a file of type: jpeg, png, jpg, gif, svg.',
                'vision_image.max'   => 'The Vision Image must not be larger than 2MB.',
                'journey_image.image' => 'The Journey Image must be an image file.',
                'journey_image.mimes' => 'The Journey Image must be a file of type: jpeg, png, jpg, gif, svg.',
                'journey_image.max'   => 'The Journey Image must not be larger than 2MB.',

            ]);

            // Fetch the first record or create a new one
            $Sections = HomeSection::first() ?? new HomeSection();

            // Function to delete the old file
            $deleteOldFile = function ($filePath) {
                if ($filePath && Storage::exists('public/images/' . $filePath)) {
                    Storage::delete('public/images/' . $filePath);
                }
            };

            // Update system setup with new data
            $Sections->header_section_ar = $request->header_section_ar;
            $Sections->header_section_en = $request->header_section_en;

            $Sections->goals_title_ar = $request->goals_title_ar;
            $Sections->goals_title_en = $request->goals_title_en;
            $Sections->goals_desc_ar = $request->goals_desc_ar;
            $Sections->goals_desc_en = $request->goals_desc_en;

            $Sections->vision_title_ar = $request->vision_title_ar;
            $Sections->vision_title_en = $request->vision_title_en;
            $Sections->vision_desc_ar = $request->vision_desc_ar;
            $Sections->vision_desc_en = $request->vision_desc_en;

            $Sections->journey_title_ar = $request->journey_title_ar;
            $Sections->journey_title_en = $request->journey_title_en;
            $Sections->journey_desc_ar = $request->journey_desc_ar;
            $Sections->journey_desc_en = $request->journey_desc_en;

            $Sections->team_title_ar = $request->team_title_ar;
            $Sections->team_title_en = $request->team_title_en;
            $Sections->team_desc_ar = $request->team_desc_ar;
            $Sections->team_desc_en = $request->team_desc_en;

            // Update or create the fields
            if ($request->hasFile('goals_image')) {
                // Delete the old header logo
                $deleteOldFile($Sections->goals_image);

                // Store the new header logo
                $headerLogoPath = $request->file('goals_image')->store('images', 'public');
                $Sections->goals_image = basename($headerLogoPath);
            }

            if ($request->hasFile('vision_image')) {
                // Delete the old footer GIF
                $deleteOldFile($Sections->vision_image);

                // Store the new footer GIF
                $footerGifPath = $request->file('vision_image')->store('images', 'public');
                $Sections->vision_image = basename($footerGifPath);
            }

            if ($request->hasFile('journey_image')) {
                // Delete the old footer logo
                $deleteOldFile($Sections->journey_image);

                // Store the new footer logo
                $footerLogoPath = $request->file('journey_image')->store('images', 'public');
                $Sections->journey_image = basename($footerLogoPath);
            }

            // Save the changes
            $Sections->save();

            toastr()->success('Home Sections Updated Successfully');
            return redirect()->back();
            try {
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation exception handling
            foreach ($e->errors() as $fieldErrors) {
                foreach ($fieldErrors as $message) {
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
