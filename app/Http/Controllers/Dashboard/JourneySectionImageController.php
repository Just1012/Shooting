<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\JourneySectionImage;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JourneySectionImageController extends Controller
{
    public function index()
    {
        return view('dashboard.homePage.sections.journeySectionImage');
    }

    public function getImages()
    {
        $data = JourneySectionImage::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function storeImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            ]);

            $requestData = $request->all();
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);
                $requestData['image'] = $imageName;
            }

            JourneySectionImage::create($requestData);

            // toastr()->success(__('Image Added Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong, please try again'), __('Error'));
            return redirect()->route('journeyImage.index');
        }
    }


    public function updateImage(Request $request, $id)
    {
        try {
            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $journeyImage = JourneySectionImage::findOrFail($id);
            $requestData = $request->all();

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);

                // Delete old image if it exists
                if ($journeyImage->image && file_exists(public_path('images/' . $journeyImage->image))) {
                    unlink(public_path('images/' . $journeyImage->image));
                }

                $requestData['image'] = $imageName;
            }

            $journeyImage->update($requestData);
            // toastr()->success(__('Image Updated Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong, please try again'), __('Error'));
            return redirect()->route('journeyImage.index');
        }
    }


    public function updateStatus(JourneySectionImage $journeySectionImage)
    {
        try {
            $journeySectionImage->update([
                'status' => $journeySectionImage->status == 0 ? 1 : 0
            ]);

            $successMessage = $journeySectionImage->status == 1 ?
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

    public function deleteImage($id)
    {
        try {
            $journeyImage = JourneySectionImage::findOrFail($id);
            if ($journeyImage->image_ar && file_exists(public_path('images/' . $journeyImage->image_ar))) {
                unlink(public_path('images/' . $journeyImage->image_ar));
            }
            if ($journeyImage->image_en && file_exists(public_path('images/' . $journeyImage->image_en))) {
                unlink(public_path('images/' . $journeyImage->image_en));
            }
            $journeyImage->delete();

            toastr()->success(__('journeyImage Deleted Successfully'), __('Success'));
            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            toastr()->error(__('Image Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }
}
