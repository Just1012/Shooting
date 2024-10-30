<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
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
        return view('dashboard.partners.addPartner');
    }

    public function storePartner(Request $request)
    {
        try {
            // Validation
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'image.required' => 'The Arabic image field is required.',
                'image.image' => 'The Arabic image must be an image file.',
                'image.mimes' => 'The Arabic image must be a file of type: jpeg, png, jpg, gif, svg.',
                'image.max' => 'The Arabic image may not be greater than 2048 kilobytes.',
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
        $partner = Partner::findOrFail($id);
        return view('dashboard.partners.editPartner', compact('partner'));
    }

    public function updatePartner(Request $request, $id)
    {
        try {
            // Validation
            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ], [
                'image.image' => 'The Arabic image must be an image file.',
                'image.mimes' => 'The Arabic image must be a file of type: jpeg, png, jpg, gif, svg.',
                'image.max' => 'The Arabic image may not be greater than 2048 kilobytes.',
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
    
    public function getPartnerApi()
    {
        $partner = Partner::where('status',1)->get();
        return response()->json([
            'data' => $partner,
            'message' => 'Partener fetched  successfully'
        ]);
    }
}
