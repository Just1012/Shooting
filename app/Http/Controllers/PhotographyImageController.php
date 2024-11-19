<?php

namespace App\Http\Controllers;

use App\Models\PhotographyImage;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PhotographyImageController extends Controller
{
    public function index()
    {
        return view('dashboard.photographyImage.index');
    }

    public function getPhotography()
    {
        $data = PhotographyImage::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function addPhotography()
    {

        return view('dashboard.photographyImage.addPhotography');
    }

    public function storePhotography(Request $request)
    {
        try {
            // Validation
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'age' => 'required|numeric',
                'height' => 'required|numeric',
                'weight' => 'required|numeric',
                'model_number' => 'required|numeric',
            ], [
                'image.required' => 'The image field is required.',
                'image.image' => 'The image must be a valid image file.',
                'image.mimes' => 'The image must be of type: jpeg, png, jpg, gif, or svg.',
                'image.max' => 'The image may not be larger than 2048 kilobytes.',
                'age.required' => 'The age field is required.',
                'age.numeric' => 'The age must be a number.',
                'height.required' => 'The height field is required.',
                'height.numeric' => 'The height must be a number.',
                'weight.required' => 'The weight field is required.',
                'weight.numeric' => 'The weight must be a number.',
                'model_number.required' => 'The model number field is required.',
                'model_number.numeric' => 'The model number must be a number.',
            ]);

            $requestData = $request->all();

            // Process Arabic Image
            if ($request->hasFile('image')) {
                $imageNameAr = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageNameAr);
                $requestData['image'] = $imageNameAr;
            }
            PhotographyImage::create($requestData);
            toastr()->success('Image Created Successfully');
            return redirect()->route('photography.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            foreach ($e->errors() as $error) {
                foreach ($error as $message) {
                    toastr()->error($message);
                }
            }
            return redirect()->route('photography.index');
        } catch (\Throwable $th) {
            toastr()->error('An error occurred. Please try again.');
            return redirect()->route('photography.index');
        }
    }

    public function editPhotography($id)
    {
        $photography = PhotographyImage::findOrFail($id);
        return view('dashboard.photographyImage.editPhotography', compact('photography'));
    }

    public function updatePhotography(Request $request, $id)
    {
        try {
            // Validation
            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'age' => 'nullable|numeric',
                'height' => 'nullable|numeric',
                'weight' => 'nullable|numeric',
                'model_number' => 'nullable|numeric',
            ], [
                'image.image' => 'The image must be a valid image file.',
                'image.mimes' => 'The image must be of type: jpeg, png, jpg, gif, or svg.',
                'image.max' => 'The image may not be larger than 2048 kilobytes.',
                'age.numeric' => 'The age must be a number.',
                'height.numeric' => 'The height must be a number.',
                'weight.numeric' => 'The weight must be a number.',
                'model_number.numeric' => 'The model number must be a number.',
            ]);

            $photography = PhotographyImage::findOrFail($id);
            $requestData = $request->all();

            // Process Image
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);

                // Delete old image if it exists
                if ($photography->image && file_exists(public_path('images/' . $photography->image))) {
                    unlink(public_path('images/' . $photography->image));
                }
                $requestData['image'] = $imageName;
            }

            $photography->update($requestData);

            toastr()->success('Photography Updated Successfully');

            return redirect()->route('photography.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            foreach ($e->errors() as $error) {
                foreach ($error as $message) {
                    toastr()->error($message);
                }
            }
            return redirect()->route('photography.index');
        } catch (\Throwable $th) {
            toastr()->error('An error occurred. Please try again.');
            return redirect()->route('photography.index');
        }
    }

    public function deletePhotography($id)
    {
        try {
            $photography = PhotographyImage::findOrFail($id);
            if ($photography->image && file_exists(public_path('images/' . $photography->image))) {
                unlink(public_path('images/' . $photography->image));
            }
            $photography->delete();

            toastr()->success(__('Photography Deleted Successfully'), __('Success'));
            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            toastr()->error(__('Photography Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function updateStatus(PhotographyImage $photographyImage)
    {
        try {
            $photographyImage->update([
                'status' => $photographyImage->status == 0 ? 1 : 0
            ]);

            $successMessage = $photographyImage->status == 1 ?
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

    public function getPhotographyImage()
    {
        $data = PhotographyImage::all();
        return response()->json([
            'data' => $data,
            'message' => 'Images Fetched Successfully'
        ]);
    }
}
