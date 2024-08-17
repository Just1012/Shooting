<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\OurWork;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OurWorkDetails;
use Illuminate\Support\Facades\Storage;

class OurWorkController extends Controller
{
    public function index()
    {
        return view('dashboard.brands.index');
    }

    public function getBrand()
    {
        $data = OurWork::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function addBrand()
    {
        $category = Category::all();
        return view('dashboard.brands.brandAdd', compact('category'));
    }

    public function storeBrand(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'brand_name_ar' => 'required|string|max:255',
                'brand_name_en' => 'required|string|max:255',
                'category_id' => 'required|array',
                'year' => 'required|digits:4', // Assuming the year is a string like "2024"
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
            ]);

            $requestData = $request->all();
            $requestData['category_id'] = json_encode($request->input('category_id'));
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);
                $requestData['image'] = $imageName;
            }
            $brand = OurWork::create($requestData);

            if ($brand) {
                $brandDetails = OurWorkDetails::create([
                    'our_work_id' => $brand->id,
                ]);
            }

            toastr()->success(__('Brand Added Successfully'), __('Success'));

            return redirect()->route('brandDetails', ['id' => $brand->id]);
        } catch (\Throwable $th) {
            toastr()->error(__('Try Again'));
            return redirect()->route('brand.index');
        }
    }

    public function editBrand(OurWork $id)
    {
        $category = Category::all();
        return view('dashboard.brands.brandEdit', compact('id', 'category'));
    }

    public function updateBrand(Request $request, $id)
    {
        try {
            // Validate the request data
            $request->validate([
                'brand_name_ar' => 'required|string|max:255',
                'brand_name_en' => 'required|string|max:255',
                'category_id' => 'required|array',
                'year' => 'required|digits:4',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
            ]);

            $brand = OurWork::findOrFail($id); // Find the brand to update

            $requestData = $request->all();
            $requestData['category_id'] = json_encode($request->input('category_id'));

            if ($request->hasFile('image')) {
                // Delete the old image
                if ($brand->image && file_exists(public_path('images/' . $brand->image))) {
                    unlink(public_path('images/' . $brand->image));
                }

                // Upload the new image
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);
                $requestData['image'] = $imageName;
            }

            // Update the brand data
            $brand->update($requestData);

            toastr()->success(__('Brand Updated Successfully'), __('Success'));

            return redirect()->route('brand.index');
        } catch (\Throwable $th) {
            toastr()->error(__('Try Again'));
            return redirect()->route('brand.index');
        }
    }


    public function updateStatus(OurWork $ourWork)
    {
        try {
            $ourWork->update([
                'status' => $ourWork->status == 0 ? 1 : 0
            ]);

            $successMessage = $ourWork->status == 1 ?
                'تم التفعيل  بنجاح' :
                'تم إلغاء التفعيل  بنجاح';

            // Generate the toastr script
            $toastrScript = "toastr.success('{$successMessage}', 'تم بنجاح');";

            return response()->json(['toastrScript' => $toastrScript]);
        } catch (\Throwable $th) {
            $toastrScript = "toastr.error('حدث خطأ ما، يرجى إعادة المحاولة', 'خطأ !');";
            return response()->json(['toastrScript' => $toastrScript], 404);
        }
    }

    public function brandDetails($id)
    {
        $brand = OurWorkDetails::where('our_work_id', $id)->first();
        if (!$brand) {
            toastr()->error(__('This is Not Found'), __('Error'));
            return redirect()->back();
        } else {
            return view('dashboard.brands.brandDetails', compact('brand'));
        }
    }

    // Method to update the existing row
    public function brandDetailsUpdate(Request $request, $id)
    {
        // Validation with custom messages
        $request->validate([
            // Validation for images
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_5' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_6' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // max 2MB
        ], [
            // Custom messages for image validation
            'main_image.image'  => 'The Main Image must be an image file.',
            'main_image.mimes'  => 'The Main Image must be a file of type: jpeg, png, jpg, gif, svg.',
            'main_image.max'    => 'The Main Image must not be larger than 2MB.',
            'image_1.image'     => 'The Image 1 must be an image file.',
            'image_1.mimes'     => 'The Image 1 must be a file of type: jpeg, png, jpg, gif, svg.',
            'image_1.max'       => 'The Image 1 must not be larger than 2MB.',
            'image_2.image'     => 'The Image 2 Image must be an image file.',
            'image_2.mimes'     => 'The Image 2 Image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image_2.max'       => 'The Image 2 Image must not be larger than 2MB.',
            'image_3.image'     => 'The Image 3 must be an image file.',
            'image_3.mimes'     => 'The Image 3 must be a file of type: jpeg, png, jpg, gif, svg.',
            'image_3.max'       => 'The Image 3 must not be larger than 2MB.',
            'image_4.image'     => 'The Image 4 Image must be an image file.',
            'image_4.mimes'     => 'The Image 4 Image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image_4.max'       => 'The Image 4 Image must not be larger than 2MB.',
            'image_5.image'     => 'The Image 5 must be an image file.',
            'image_5.mimes'     => 'The Image 5 must be a file of type: jpeg, png, jpg, gif, svg.',
            'image_5.max'       => 'The Image 5 must not be larger than 2MB.',
            'image_6.image'     => 'The Image 6 Image must be an image file.',
            'image_6.mimes'     => 'The Image 6 Image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image_6.max'       => 'The Image 6 Image must not be larger than 2MB.',
        ]);

        // Fetch the first record or create a new one
        // Fetch the existing brand details
        $brand = OurWorkDetails::where('our_work_id', $id)->first();

        if (!$brand) {
            toastr()->error(__('Brand details not found'), __('Error'));
            return redirect()->back();
        }
        // Function to delete the old file
        $deleteOldFile = function ($filePath) {
            if ($filePath && Storage::exists('public/images/' . $filePath)) {
                Storage::delete('public/images/' . $filePath);
            }
        };

        if ($request->hasFile('main_image')) {
            // Delete the old header logo
            $deleteOldFile($brand->main_image);
            // Store the new header logo
            $headerLogoPath = $request->file('main_image')->store('images', 'public');
            $brand->main_image = basename($headerLogoPath);
        }

        if ($request->hasFile('image_1')) {
            // Delete the old header logo
            $deleteOldFile($brand->image_1);
            // Store the new header logo
            $headerLogoPath = $request->file('image_1')->store('images', 'public');
            $brand->image_1 = basename($headerLogoPath);
        }

        if ($request->hasFile('image_2')) {
            // Delete the old header logo
            $deleteOldFile($brand->image_2);
            // Store the new header logo
            $headerLogoPath = $request->file('image_2')->store('images', 'public');
            $brand->image_2 = basename($headerLogoPath);
        }
        if ($request->hasFile('image_3')) {
            // Delete the old header logo
            $deleteOldFile($brand->image_3);
            // Store the new header logo
            $headerLogoPath = $request->file('image_3')->store('images', 'public');
            $brand->image_3 = basename($headerLogoPath);
        }

        if ($request->hasFile('image_4')) {
            // Delete the old header logo
            $deleteOldFile($brand->image_4);
            // Store the new header logo
            $headerLogoPath = $request->file('image_4')->store('images', 'public');
            $brand->image_4 = basename($headerLogoPath);
        }
        if ($request->hasFile('image_5')) {
            // Delete the old header logo
            $deleteOldFile($brand->image_5);
            // Store the new header logo
            $headerLogoPath = $request->file('image_5')->store('images', 'public');
            $brand->image_5 = basename($headerLogoPath);
        }

        if ($request->hasFile('image_6')) {
            // Delete the old header logo
            $deleteOldFile($brand->image_6);
            // Store the new header logo
            $headerLogoPath = $request->file('image_6')->store('images', 'public');
            $brand->image_6 = basename($headerLogoPath);
        }
        // Save the changes
        $brand->save();

        toastr()->success('Brand Details Updated Successfully');
        return redirect()->route('brand.index');
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
