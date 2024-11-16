<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\OurWork;
use App\Models\Partner;
use App\Enums\BrandEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class PartnerController extends Controller
{
    public function index()
    {
        return view('dashboard.partners.index');
    }

    public function getPartner()
    {
        $data = Partner::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function addPartner()
    {
        $section = BrandEnum::getValues(); // Get enum values
        $brands = OurWork::all();
        return view('dashboard.partners.addPartner', compact('brands', 'section'));
    }

    public function storePartner(Request $request)
    {
        try {
            // Validation
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'brand_id' => 'required|exists:our_works,id',
                'section' => 'required|in:1,2,3,4', // Validation for specific enum values
            ], [
                'image.required' => 'The image field is required.',
                'image.image' => 'The uploaded file must be an image.',
                'image.mimes' => 'The image must be a type of: jpeg, png, jpg, gif, or svg.',
                'image.max' => 'The image size must not exceed 2048 kilobytes.',
                'brand_id.required' => 'The brand ID field is required.',
                'brand_id.exists' => 'The selected brand ID does not exist.',
                'section.in' => 'The selected brand is invalid.', // Custom message for invalid enum value
            ]);

            $requestData = $request->all();

            // Process Arabic Image
            if ($request->hasFile('image')) {
                $imageNameAr = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageNameAr);
                $requestData['image'] = $imageNameAr;
            }



            Partner::create($requestData);

            toastr()->success('Partner Created Successfully');

            return redirect()->route('partner.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            foreach ($e->errors() as $error) {
                foreach ($error as $message) {
                    toastr()->error($message);
                }
            }
            return redirect()->route('partner.index');
        } catch (\Throwable $th) {
            toastr()->error('An error occurred. Please try again.');
            return redirect()->route('partner.index');
        }
    }

    public function editPartner($id)
    {
        $section = BrandEnum::getValues(); // Get enum values
        $brands = OurWork::all();
        $partner = Partner::findOrFail($id);
        return view('dashboard.partners.editPartner', compact('partner', 'brands', 'section'));
    }

    public function updatePartner(Request $request, $id)
    {
        try {
            // Validation
            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'brand_id' => 'nullable|exists:our_works,id',
                'section' => 'nullable|in:1,2,3,4', // Validation for specific enum values
            ], [
                'image.image' => 'The image must be a valid image file.',
                'image.mimes' => 'The image must be of type: jpeg, png, jpg, gif, or svg.',
                'image.max' => 'The image may not be larger than 2048 kilobytes.',
                'brand_id.exists' => 'The selected brand does not exist.',
                'section.in' => 'The selected brand is invalid.', // Custom message for invalid enum value
            ]);

            $partner = Partner::findOrFail($id);
            $requestData = $request->all();

            // Process Arabic Image
            if ($request->hasFile('image')) {
                $imageNameAr = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageNameAr);

                // Delete old Arabic image if it exists
                if ($partner->image && file_exists(public_path('images/' . $partner->image))) {
                    unlink(public_path('images/' . $partner->image));
                }
                $requestData['image'] = $imageNameAr;
            }


            $partner->update($requestData);

            toastr()->success('Partner Updated Successfully');

            return redirect()->route('partner.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            foreach ($e->errors() as $error) {
                foreach ($error as $message) {
                    toastr()->error($message);
                }
            }
            return redirect()->route('partner.index');
        } catch (\Throwable $th) {
            toastr()->error('An error occurred. Please try again.');
            return redirect()->route('partner.index');
        }
    }


    public function deletePartner($id)
    {
        try {
            $partner = Partner::findOrFail($id);
            if ($partner->image && file_exists(public_path('images/' . $partner->image))) {
                unlink(public_path('images/' . $partner->image));
            }
            $partner->delete();

            toastr()->success(__('Partner Deleted Successfully'), __('Success'));
            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            toastr()->error(__('Partner Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function updateStatus(Partner $partner)
    {
        try {
            $partner->update([
                'status' => $partner->status == 0 ? 1 : 0
            ]);

            $successMessage = $partner->status == 1 ?
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

    public function getPartnerApi(Request $request)
    {
        $query = Partner::where('status', 1);

        // Check if 'section' is sent in the request and apply filter
        if ($request->has('section')) {
            $query->where('section', $request->input('section'));
        }

        $partners = $query->get();

        return response()->json([
            'data' => $partners,
            'message' => 'Partners fetched successfully'
        ]);
    }
}
