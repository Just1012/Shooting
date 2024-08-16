<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function editService()
    {
        $service = Service::first();
        return view('dashboard.pages.service', compact('service'));
    }

    // Method to update the existing row
    public function updateService(Request $request)
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
                'sector_6_ar' => 'nullable|string',
                'sector_6_en' => 'nullable|string',
                'sector_7_ar' => 'nullable|string',
                'sector_7_en' => 'nullable|string',
                'sector_8_ar' => 'nullable|string',
                'sector_8_en' => 'nullable|string',
            ]);

            // Fetch the first record
            $service = Service::first();

            // If no record exists, create one
            if (!$service) {
                $service = new Service();
            }

            // Update system setup with new data
            $service->main_title_ar = $request->main_title_ar;
            $service->main_title_en = $request->main_title_en;
            $service->desc_1_ar = $request->desc_1_ar;
            $service->desc_1_en = $request->desc_1_en;
            $service->desc_2_ar = $request->desc_2_ar;
            $service->desc_2_en = $request->desc_2_en;

            // Update the sector fields
            for ($i = 1; $i <= 8; $i++) {
                $arField = "sector_{$i}_ar";
                $enField = "sector_{$i}_en";
                $service->$arField = $request->$arField;
                $service->$enField = $request->$enField;
            }

            $service->save();

            toastr()->success('Service Page Updated Successfully');

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
