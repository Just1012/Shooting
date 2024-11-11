<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\IndustryService;
use Illuminate\Http\Request;

class IndustryServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }
    public function index()
    {
        return view('dashboard.industry.index');
    }

    public function getIndustryService()
    {
        $data = IndustryService::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function addIndustryService()
    {
        return view('dashboard.industry.industryAdd');
    }

    public function storeIndustryService(Request $request)
    {
        try {

            $requestData = $request->all();
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);
                $requestData['image'] = $imageName;
            }
            IndustryService::create($requestData);

            toastr()->success(__('Industry Added Successfully'), __('Success'));

            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Try Again'));
            return redirect()->route('industry.index');
        }
    }

    public function editIndustryService(IndustryService $id)
    {
        return view('dashboard.industry.industryEdit', compact('id'));
    }

    public function updateIndustryService(Request $request, $id)
    {
        try {
            $industry = IndustryService::findOrFail($id);
            $requestData = $request->all();

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);

                // Delete old image if it exists
                if ($industry->image && file_exists(public_path('images/' . $industry->image))) {
                    unlink(public_path('images/' . $industry->image));
                }
                $requestData['image'] = $imageName;
            }

            $industry->update($requestData);
            toastr()->success(__('Industry Updated Successfully'), __('Success'));
            return redirect()->route('industry.index');
        } catch (\Throwable $th) {
            toastr()->error(__('Try Again'), __('Success'));
            return redirect()->route('industry.index');
        }
    }

    public function updateStatus(IndustryService $industry)
    {
        try {
            $industry->update([
                'status' => $industry->status == 0 ? 1 : 0
            ]);

            $successMessage = $industry->status == 1 ?
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
