<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    public function editIndustry()
    {
        $industry = Industry::first();
        return view('dashboard.pages.industry', compact('industry'));
    }

    // Method to update the existing row
    public function updateIndustry(Request $request)
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
                'sector_1_ar' => 'nullable|string',
                'sector_1_en' => 'nullable|string',
                'sector_2_ar' => 'nullable|string',
                'sector_2_en' => 'nullable|string',
                'sector_3_ar' => 'nullable|string',
                'sector_3_en' => 'nullable|string',
                'sector_4_ar' => 'nullable|string',
                'sector_4_en' => 'nullable|string',
                'sector_5_ar' => 'nullable|string',
                'sector_5_en' => 'nullable|string',
            ]);

            // Fetch the first record
            $industry = Industry::first();

            // If no record exists, create one
            if (!$industry) {
                $industry = new Industry();
            }

            // Update system setup with new data
            $industry->main_title_ar = $request->main_title_ar;
            $industry->main_title_en = $request->main_title_en;
            $industry->desc_1_ar = $request->desc_1_ar;
            $industry->desc_1_en = $request->desc_1_en;
            $industry->desc_2_ar = $request->desc_2_ar;
            $industry->desc_2_en = $request->desc_2_en;

            $industry->secondary_title_ar = $request->secondary_title_ar;
            $industry->secondary_title_en = $request->secondary_title_en;

            // Update the sector fields
            for ($i = 1; $i <= 5; $i++) {
                $arField = "sector_{$i}_ar";
                $enField = "sector_{$i}_en";
                $industry->$arField = $request->$arField;
                $industry->$enField = $request->$enField;
            }

            $industry->save();

            toastr()->success('Industry Page Updated Successfully');

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
