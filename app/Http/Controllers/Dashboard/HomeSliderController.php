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
                'image_ar' => 'required|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov|max:20480',
                'image_en' => 'required|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov|max:20480',
            ], [
                'image_ar.required' => 'The Arabic file field is required.',
                'image_ar.mimes' => 'The Arabic file must be an image (jpeg, png, jpg, gif, svg) or video (mp4, avi, mov).',
                'image_ar.max' => 'The Arabic file may not be greater than 20 MB.',
                'image_en.required' => 'The English file field is required.',
                'image_en.mimes' => 'The English file must be an image (jpeg, png, jpg, gif, svg) or video (mp4, avi, mov).',
                'image_en.max' => 'The English file may not be greater than 20 MB.',
            ]);

            $requestData = $request->all();

            // Process Arabic File
            if ($request->hasFile('image_ar')) {
                $fileAr = $request->file('image_ar');
                $fileNameAr = time() . '_ar.' . $fileAr->getClientOriginalExtension();
                $fileAr->move(public_path('images'), $fileNameAr);
                $requestData['image_ar'] = $fileNameAr;
            }

            // Process English File
            if ($request->hasFile('image_en')) {
                $fileEn = $request->file('image_en');
                $fileNameEn = time() . '_en.' . $fileEn->getClientOriginalExtension();
                $fileEn->move(public_path('images'), $fileNameEn);
                $requestData['image_en'] = $fileNameEn;
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
                'image_ar' => 'nullable|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov|max:20480',
                'image_en' => 'nullable|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov|max:20480',
            ], [
                'image_ar.mimes' => 'The Arabic file must be an image (jpeg, png, jpg, gif, svg) or video (mp4, avi, mov).',
                'image_ar.max' => 'The Arabic file may not be greater than 20 MB.',
                'image_en.mimes' => 'The English file must be an image (jpeg, png, jpg, gif, svg) or video (mp4, avi, mov).',
                'image_en.max' => 'The English file may not be greater than 20 MB.',
            ]);

            $item = HomeSlider::findOrFail($id);
            $requestData = $request->all();

            // Process Arabic File (Image/Video)
            if ($request->hasFile('image_ar')) {
                $fileAr = $request->file('image_ar');
                $fileNameAr = time() . '_ar.' . $fileAr->getClientOriginalExtension();
                $fileAr->move(public_path('images'), $fileNameAr);

                // Delete old Arabic file if it exists
                if ($item->image_ar && file_exists(public_path('images/' . $item->image_ar))) {
                    unlink(public_path('images/' . $item->image_ar));
                }
                $requestData['image_ar'] = $fileNameAr;
            }

            // Process English File (Image/Video)
            if ($request->hasFile('image_en')) {
                $fileEn = $request->file('image_en');
                $fileNameEn = time() . '_en.' . $fileEn->getClientOriginalExtension();
                $fileEn->move(public_path('images'), $fileNameEn);

                // Delete old English file if it exists
                if ($item->image_en && file_exists(public_path('images/' . $item->image_en))) {
                    unlink(public_path('images/' . $item->image_en));
                }
                $requestData['image_en'] = $fileNameEn;
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

    public function getSliderApi()
    {
        $data = HomeSlider::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }
}
