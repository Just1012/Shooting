<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\OurWork;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BrandImage;
use App\Models\OurWorkDetails;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class OurWorkController extends Controller
{
    // Our Work Index View
    public function index()
    {
        return view('dashboard.brands.index');
    }

    // Get Our Works For dataTable
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

            toastr()->success(__('Brand Added Successfully'), __('Success'));
            return redirect()->route('brand.index');
        } catch (\Throwable $th) {

            toastr()->error(__('Try Again'));
            return redirect()->back()->withInput();
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

    // Our Work Details And Images Update
    public function brandDetails($id)
    {
        // Find the OurWorkDetails record or create a new instance
        $brandExists = OurWorkDetails::where('our_work_id', $id)->first();

        // Find the OurWorkDetails record or create a new instance
        $brand = BrandImage::where('our_work_id', $id)->get();

        return view('dashboard.brands.brandDetails', compact('brand', 'brandExists'));
    }

    public function brandDetailsUpdate(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'title_color' => 'required|string',
            'title_back_color' => 'required|string',
            'details_color' => 'required|string',
            'details_back_color' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update or create the OurWorkDetails entry for the given ID
        $brandDetails = OurWorkDetails::updateOrCreate(
            ['our_work_id' => $id],
            [
                'title_color' => $request->input('title_color'),
                'title_back_color' => $request->input('title_back_color'),
                'details_color' => $request->input('details_color'),
                'details_back_color' => $request->input('details_back_color'),
            ]
        );

        // Handle image removal
        if ($request->has('remove_images')) {
            foreach ($request->input('remove_images') as $imageId) {
                $image = BrandImage::find($imageId);

                if ($image) {
                    // Delete the image from storage
                    Storage::disk('public')->delete($image->image);
                    // Delete the image record from the database
                    $image->delete();
                }
            }
        }

        // Handle image replacement and addition
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                // Check if the key is numeric, indicating an existing image ID
                // Add a new image
                $path = $image->store('images', 'public');
                // Create a new image record
                BrandImage::create([
                    'image' => $path,
                    'our_work_id' => $id,
                ]);
            }
        }

        return redirect()->route('brand.index')->with('success', 'Brand details updated successfully!');
    }

    // Our Work Status update
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

    // Apis Part For Our Works
    public function getBrandApi(Request $request)
    {
        $currentPage = $request->currentPage;
        $perPage = 12;
        $brand = OurWork::paginate($perPage, ['*'], 'page', $currentPage);
        $allCategoryIds = $brand->pluck('category_id')
            ->map(fn($categoryIds) => json_decode($categoryIds, true))  // Decode each category_id
            ->filter()
            ->flatten()
            ->unique()
            ->toArray();
        $categories = Category::whereIn('id', $allCategoryIds)->get()->keyBy('id');
        $brandData = $brand->map(function ($item) use ($categories) {
            $categoryIds = json_decode($item->category_id, true);
            $item->categories = $categories->only($categoryIds)->values();
            unset($item->category_id);
            return $item;
        });
        return response()->json([
            'data' => $brandData,
            'pagination' => [
                'count' => $brand->count(),
                'current_page' => $brand->currentPage(),
                'per_page' => $brand->perPage(),
                'total' => $brand->total(),
                'total_pages' => $brand->lastPage(),
            ],
            'message' => 'found data'
        ]);
    }

    public function getBrandDetailsApi(Request $request)
    {
        // Fetch the brand details and its related OurWork
        $brandDetails = OurWorkDetails::with('ourWork')->where('our_work_id', $request->brand_id)->first();

        if ($brandDetails) {
            // Extract and decode the category_id from the related OurWork
            $categoryIds = json_decode($brandDetails->ourWork->category_id, true);

            // If there are category IDs, fetch the categories
            if (!empty($categoryIds)) {
                $categories = Category::whereIn('id', $categoryIds)->get();
            } else {
                $categories = collect([]);  // Return an empty collection if no category IDs
            }

            // Attach the categories to the ourWork relation
            $brandDetails->ourWork->categories = $categories;

            // Optionally, remove category_id and some images from the output
            unset(
                $brandDetails->ourWork->category_id,
                $brandDetails->main_image,
                $brandDetails->image_1,
                $brandDetails->image_2,
                $brandDetails->image_3,
                $brandDetails->image_4,
                $brandDetails->image_5,
                $brandDetails->image_6
            );

            // Return the brand details with attached categories
            return response()->json([
                'data' => $brandDetails,
                'message' => 'found brand details with categories',
            ]);
        } else {
            return response()->json([
                'message' => 'brand not found',
            ], 404);
        }
    }

    public function getBrandImagesApi($id)
    {
        $brandImage = BrandImage::where('our_work_id', $id)->get();
        if (!$brandImage) {
            return response()->json([
                'message' => 'Not Found Data'
            ]);
        }
        return response()->json([
            'data' => $brandImage,
            'message' => 'Images Featched Successfully'
        ]);
    }

    // Get Our Work For Services Page
    public function getBrandApiForService(Request $request)
    {
        $perPage = 12;
        $category = $request->input('service');
        $currentPage = $request->input('currentPage', 1); // Default to page 1 if not provided

        // Initialize query
        $query = OurWork::query();

        // Apply category filter if a specific category ID is provided
        if (!empty($category)) {
            $query->whereJsonContains('category_id', $category);
        }

        // Paginate the results
        $brand = $query->paginate($perPage, ['*'], 'page', $currentPage);

        // Check if there are no results and format response accordingly
        if ($brand->isEmpty()) {
            return response()->json([
                'data' => [],
                'pagination' => [
                    'count' => 0,
                    'current_page' => $currentPage,
                    'per_page' => $perPage,
                    'total' => 0,
                    'total_pages' => 1,
                ],
                'message' => 'No data found'
            ]);
        }

        // Extract all unique category IDs from the filtered brands
        $allCategoryIds = $brand->pluck('category_id')
            ->map(fn($categoryIds) => json_decode($categoryIds, true))  // Decode each category_id
            ->filter()
            ->flatten()
            ->unique()
            ->toArray();

        // Fetch categories by these unique IDs
        $categories = Category::whereIn('id', $allCategoryIds)->get()->keyBy('id');

        // Map through the brands and attach their associated categories
        $brandData = $brand->map(function ($item) use ($categories) {
            $categoryIds = json_decode($item->category_id, true);
            $item->categories = $categories->only($categoryIds)->values(); // Attach only relevant categories
            unset($item->category_id); // Remove original category_id field
            return $item;
        });

        // Return the response with populated data and pagination
        return response()->json([
            'data' => $brandData,
            'pagination' => [
                'count' => $brand->count(),
                'current_page' => $brand->currentPage(),
                'per_page' => $brand->perPage(),
                'total' => $brand->total(),
                'total_pages' => $brand->lastPage(),
            ],
            'message' => 'Data found'
        ]);
    }
}
