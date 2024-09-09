<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SystemInfo;
use Illuminate\Http\Request;

class SystemInfoController extends Controller
{
    public function editSystemInfo()
    {
        $systemInfo = SystemInfo::first();
        return view('dashboard.setting.systemInfo', compact('systemInfo'));
    }

    // Method to update the existing row
    public function updateSystemInfo(Request $request)
    {
        try {
            // Validation
            $request->validate([
                'header_btn_link' => 'required|string',
                'address_ar' => 'required|string',
                'address_en' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|numeric',
                'facebook' => 'required|url',
                'instagram' => 'required|url',
                'snapchat' => 'required|url',
                'tiktok' => 'required|url',
                'whatsapp' => 'required|url',
            ]);

            // Fetch the first record
            $systemSetup = SystemInfo::first();

            // If no record exists, create one
            if (!$systemSetup) {
                $systemSetup = new SystemInfo();
            }

            // Update system setup with new data
            $systemSetup->header_btn_link = $request->header_btn_link;
            $systemSetup->address_ar = $request->address_ar;
            $systemSetup->address_en = $request->address_en;
            $systemSetup->email = $request->email;
            $systemSetup->phone = $request->phone;
            $systemSetup->facebook = $request->facebook;
            $systemSetup->instagram = $request->instagram;
            $systemSetup->snapchat = $request->snapchat;
            $systemSetup->tiktok = $request->tiktok;
            $systemSetup->whatsapp = $request->whatsapp;

            $systemSetup->save();

            toastr()->success('System Info Updated Successfully');

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
