<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\HomeSlider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class HomeSliderController extends Controller
{
    public function index()
    {
        return view('dashboard.homePage.slider.index');
    }

    public function getSlider()
    {
        $data = HomeSlider::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function addSlider()
    {
        return view('dashboard.homePage.slider.addSlider');
    }

    public function storeSlider(Request $request)
    {
        try {
            // Validation
            $request->validate([
                'image_ar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                'image_en' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            ], [
                'image_ar.required' => 'The Arabic image field is required.',
                'image_ar.image' => 'The Arabic image must be an image file.',
                'image_ar.mimes' => 'The Arabic image must be a file of type: jpeg, png, jpg, gif, svg.',
                'image_ar.max' => 'The Arabic image may not be greater than 10 MB.',
                'image_en.required' => 'The English image field is required.',
                'image_en.image' => 'The English image must be an image file.',
                'image_en.mimes' => 'The English image must be a file of type: jpeg, png, jpg, gif, svg.',
                'image_en.max' => 'The English image may not be greater than 10 MB.',
            ]);

            $requestData = $request->all();

            // Process Arabic Image
            if ($request->hasFile('image_ar')) {
                $imageNameAr = time() . '_ar.' . $request->image_ar->getClientOriginalExtension();
                $request->image_ar->move(public_path('images'), $imageNameAr);
                $requestData['image_ar'] = $imageNameAr;
            }

            // Process English Image
            if ($request->hasFile('image_en')) {
                $imageNameEn = time() . '_en.' . $request->image_en->getClientOriginalExtension();
                $request->image_en->move(public_path('images'), $imageNameEn);
                $requestData['image_en'] = $imageNameEn;
            }

            HomeSlider::create($requestData);

            toastr()->success('Slider Created Successfully');

            return redirect()->route('slider.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            foreach ($e->errors() as $error) {
                foreach ($error as $message) {
                    toastr()->error($message);
                }
            }
            return redirect()->route('slider.index');
        } catch (\Throwable $th) {
            toastr()->error('An error occurred. Please try again.');
            return redirect()->route('slider.index');
        }
    }

    public function editSlider($id)
    {
        $slider = HomeSlider::findOrFail($id);
        return view('dashboard.homePage.slider.editSlider', compact('slider'));
    }

    public function updateSlider(Request $request, $id)
    {
        try {
            // Validation
            $request->validate([
                'image_ar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                'image_en' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            ], [
                'image_ar.image' => 'The Arabic image must be an image file.',
                'image_ar.mimes' => 'The Arabic image must be a file of type: jpeg, png, jpg, gif, svg.',
                'image_ar.max' => 'The Arabic image may not be greater than 10 MB.',
                'image_en.image' => 'The English image must be an image file.',
                'image_en.mimes' => 'The English image must be a file of type: jpeg, png, jpg, gif, svg.',
                'image_en.max' => 'The English image may not be greater than 10 MB.',
            ]);

            $item = HomeSlider::findOrFail($id);
            $requestData = $request->all();

            // Process Arabic Image
            if ($request->hasFile('image_ar')) {
                $imageNameAr = time() . '_ar.' . $request->image_ar->getClientOriginalExtension();
                $request->image_ar->move(public_path('images'), $imageNameAr);

                // Delete old Arabic image if it exists
                if ($item->image_ar && file_exists(public_path('images/' . $item->image_ar))) {
                    unlink(public_path('images/' . $item->image_ar));
                }
                $requestData['image_ar'] = $imageNameAr;
            }

            // Process English Image
            if ($request->hasFile('image_en')) {
                $imageNameEn = time() . '_en.' . $request->image_en->getClientOriginalExtension();
                $request->image_en->move(public_path('images'), $imageNameEn);

                // Delete old English image if it exists
                if ($item->image_en && file_exists(public_path('images/' . $item->image_en))) {
                    unlink(public_path('images/' . $item->image_en));
                }
                $requestData['image_en'] = $imageNameEn;
            }

            $item->update($requestData);

            toastr()->success('Slider Updated Successfully');

            return redirect()->route('slider.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            foreach ($e->errors() as $error) {
                foreach ($error as $message) {
                    toastr()->error($message);
                }
            }
            return redirect()->route('slider.index');
        } catch (\Throwable $th) {
            toastr()->error('An error occurred. Please try again.');
            return redirect()->route('slider.index');
        }
    }


    public function deleteSlider($id)
    {
        try {
            $slider = HomeSlider::findOrFail($id);
            if ($slider->image_ar && file_exists(public_path('images/' . $slider->image_ar))) {
                unlink(public_path('images/' . $slider->image_ar));
            }
            if ($slider->image_en && file_exists(public_path('images/' . $slider->image_en))) {
                unlink(public_path('images/' . $slider->image_en));
            }
            $slider->delete();

            toastr()->success(__('Slider Deleted Successfully'), __('Success'));
            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            toastr()->error(__('Slider Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function updateStatus(HomeSlider $homeSlider)
    {
        try {
            $homeSlider->update([
                'status' => $homeSlider->status == 0 ? 1 : 0
            ]);

            $successMessage = $homeSlider->status == 1 ?
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
}
