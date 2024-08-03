<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('dashboard.categories.index');
    }

    public function getCategory()
    {
        $data = Category::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function addCategory()
    {
        return view('dashboard.categories.categoryAdd');
    }

    public function storeCategory(Request $request)
    {
        try {

            $requestData = $request->all();
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);
                $requestData['image'] = $imageName;
            }
            Category::create($requestData);

            toastr()->success(__('Category Added Successfully'), __('Success'));

            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Try Again'));
            return redirect()->route('category.index');
        }
    }

    public function editCategory(Category $id)
    {
        return view('dashboard.categories.categoryEdit', compact('id'));
    }

    public function updateCategory(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $requestData = $request->all();

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);

                // Delete old image if it exists
                if ($category->image && file_exists(public_path('images/' . $category->image))) {
                    unlink(public_path('images/' . $category->image));
                }
                $requestData['image'] = $imageName;
            }

            $category->update($requestData);
            toastr()->success(__('Category Updated Successfully'), __('Success'));
            return redirect()->route('category.index');
        } catch (\Throwable $th) {
            toastr()->error(__('Try Again'), __('Success'));
            return redirect()->route('category.index');
        }
    }
    
    public function updateStatus(Category $category)
    {
        try {
            $category->update([
                'status' => $category->status == 0 ? 1 : 0
            ]);

            $successMessage = $category->status == 1 ?
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
