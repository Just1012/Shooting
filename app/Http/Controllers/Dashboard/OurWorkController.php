<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\OurWork;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BrandImage;
use App\Models\IndustryService;
use App\Models\OurWorkDetails;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;



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
        $data = OurWork::orderBy('priority')->get();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function addBrand()
    {
        $category = Category::all();
        $industry = IndustryService::all();
        return view('dashboard.brands.brandAdd', compact('category', 'industry'));
    }

    public function storeBrand(Request $request)
    {
        try {
            $request->validate([
                'brand_name_ar' => 'required|string|max:255',
                'brand_name_en' => 'required|string|max:255',
                'category_id' => 'required|array',
                'industry_id' => [
                    'required_if:category_id,8',
                    'array',
                    function ($attribute, $value, $fail) use ($request) {
                        if (is_array($request->category_id) && in_array(8, $request->category_id) && empty($value)) {
                            $fail(__('The industry field is required when category includes 8.'));
                        }
                    },
                ],
                'year' => 'required|digits:4',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,mp4,avi,mov|max:20480', // Allow images and videos, max 20MB
                'type' => 'required|in:0,1',
                'priority' => 'required|numeric|min:0|unique:our_works,priority',
            ], [
                'image.mimes' => 'The image must be of type: jpeg, png, jpg, gif, mp4, avi, mov.',
                'image.max' => 'The file size may not exceed 20MB.',
                'priority.unique' => 'The priority has already been taken.',
            ]);

            $requestData = $request->all();
            $requestData['category_id'] = json_encode($request->input('category_id'));
            $requestData['industry_id'] = json_encode($request->input('industry_id'));

            // Handle image/video upload
            if ($request->hasFile('image')) {
                $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $fileName);
                $requestData['image'] = $fileName;
            }

            $brand = OurWork::create($requestData);
            OurWorkDetails::create([
                'title_color' => '#fff',
                'title_back_color' => '#fff',
                'details_back_color' => '#fff',
                'details_color' => '#fff',
                'our_work_id' => $brand->id,
            ]);

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
        $industry = IndustryService::all();
        return view('dashboard.brands.brandEdit', compact('id', 'category', 'industry'));
    }

    public function updateBrand(Request $request, $id)
    {
        try {
            $request->validate([
                'brand_name_ar' => 'required|string|max:255',
                'brand_name_en' => 'required|string|max:255',
                'category_id' => 'required|array',
                'industry_id' => [
                    'required_if:category_id,8',
                    'array',
                    function ($attribute, $value, $fail) use ($request) {
                        if (is_array($request->category_id) && in_array(8, $request->category_id) && empty($value)) {
                            $fail(__('The industry field is required when category includes 8.'));
                        }
                    },
                ],
                'year' => 'required|digits:4',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,mp4,avi,mov|max:20480', // Allow images and videos, max 20MB
                'type' => 'required|in:0,1',
                'priority' => 'required|numeric|min:0|unique:our_works,priority,' . $id,
            ], [
                'image.mimes' => 'The image must be of type: jpeg, png, jpg, gif, mp4, avi, mov.',
                'image.max' => 'The file size may not exceed 20MB.',
                'priority.unique' => 'The priority has already been taken.',
            ]);

            $brand = OurWork::findOrFail($id);
            $requestData = $request->all();
            $requestData['category_id'] = json_encode($request->input('category_id'));
            $requestData['industry_id'] = json_encode($request->input('industry_id'));

            // Handle image/video upload and old file deletion
            if ($request->hasFile('image')) {
                if ($brand->image && file_exists(public_path('images/' . $brand->image))) {
                    unlink(public_path('images/' . $brand->image));
                }
                $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $fileName);
                $requestData['image'] = $fileName;
            }

            $brand->update($requestData);

            toastr()->success(__('Brand Updated Successfully'), __('Success'));
            return redirect()->route('brand.index');
        } catch (\Throwable $th) {
            toastr()->error(__('Try Again'));
            return redirect()->back()->withInput();
        }
    }


    // Our Work Details And Images Update
    public function brandDetails($id)
    {
        // Find the OurWorkDetails record or create a new instance
        $brandExists = OurWorkDetails::where('our_work_id', $id)->first();

        if (!$brandExists) {
            $brandExists = OurWorkDetails::create([
                'title_color' => '#fff',
                'title_back_color' => '#fff',
                'details_back_color' => '#fff',
                'details_color' => '#fff',
                'our_work_id' => $id,
            ]);
        }
        $brand = BrandImage::where('our_work_id', $id)->orderBy('priority')->get();

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
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'priorities.*' => 'nullable|numeric',
            'new_priorities.*' => 'nullable|numeric',
        ]);

        // Update or create the OurWorkDetails entry
        OurWorkDetails::updateOrCreate(
            ['our_work_id' => $id],
            [
                'title_color' => $request->input('title_color'),
                'title_back_color' => $request->input('title_back_color'),
                'details_color' => $request->input('details_color'),
                'details_back_color' => $request->input('details_back_color'),
            ]
        );

        // Update existing image priorities
        if ($request->has('priorities')) {
            foreach ($request->input('priorities') as $imageId => $priority) {
                $image = BrandImage::find($imageId);
                if ($image) {
                    $image->update(['priority' => $priority]);
                }
            }
        }

        // Handle image removal
        if ($request->has('remove_images')) {
            foreach ($request->input('remove_images') as $imageId) {
                $image = BrandImage::find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->image); // Remove from storage
                    $image->delete(); // Remove from database
                }
            }
        }

        // Handle new images and their priorities
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $key => $image) {
                $path = $image->store('images', 'public');
                BrandImage::create([
                    'image' => $path,
                    'our_work_id' => $id,
                    'priority' => $request->input('new_priorities')[$key] ?? 0,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Brand details updated successfully!');
    }

    public function deleteBrand($id)
    {
        try {
            $brand = OurWork::findOrFail($id);
            if ($brand->image && file_exists(public_path('images/' . $brand->image))) {
                unlink(public_path('images/' . $brand->image));
            }
            $brand->delete();

            toastr()->success(__('Brand Deleted Successfully'), __('Success'));
            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            toastr()->error(__('Brand Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
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
        $brandImage = BrandImage::where('our_work_id', $id)->orderBy('priority')->get();
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

        if ($category == 8) {
            $query = OurWork::query()->where('type', 1);
        } else {
            $query = OurWork::query();
        }

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

        // Extract all unique industry IDs from the filtered brands
        $allIndustryIds = $brand->pluck('industry_id')
            ->map(fn($industryIds) => json_decode($industryIds, true))  // Decode each category_id
            ->filter()
            ->flatten()
            ->unique()
            ->toArray();

        // Fetch categories by these unique IDs
        $categories = Category::whereIn('id', $allCategoryIds)->get()->keyBy('id');

        // Fetch industries by these unique IDs
        $industries = IndustryService::whereIn('id', $allIndustryIds)->get()->keyBy('id');


        if ($category == 8) {
            // Map through the brands and attach their associated categories
            $brandData = $brand->map(function ($item) use ($industries) {
                $industryIds = json_decode($item->industry_id, true);
                $item->categories = $industries->only($industryIds)->values(); // Attach only relevant industries
                unset(
                    $item->industry_id,
                    $item->category_id
                ); // Remove original category_id field
                return $item;
            });
        } else {
            // Map through the brands and attach their associated categories
            $brandData = $brand->map(function ($item) use ($categories) {
                $categoryIds = json_decode($item->category_id, true);
                $item->categories = $categories->only($categoryIds)->values(); // Attach only relevant categories
                unset($item->category_id); // Remove original category_id field
                return $item;
            });
        }



        // Return the response with populated data and pagination
        return response()->json([
            'data' => $brandData->sortBy('priority')->values(),
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
    public function getBrandApiForIndustry(Request $request)
    {
        $perPage = 12;
        $category = $request->input('industry');
        $currentPage = $request->input('currentPage', 1); // Default to page 1 if not provided

        $query = OurWork::query()->where('type', 1);

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

        // Extract all unique industry IDs from the filtered brands
        $allIndustryIds = $brand->pluck('industry_id')
            ->map(fn($industryIds) => json_decode($industryIds, true))  // Decode each category_id
            ->filter()
            ->flatten()
            ->unique()
            ->toArray();

        // Fetch categories by these unique IDs
        $categories = Category::whereIn('id', $allCategoryIds)->get()->keyBy('id');

        // Fetch industries by these unique IDs
        $industries = IndustryService::whereIn('id', $allIndustryIds)->get()->keyBy('id');

        // Map through the brands and attach their associated categories
        $brandData = $brand->map(function ($item) use ($industries) {
            $industryIds = json_decode($item->industry_id, true);
            $item->categories = $industries->only($industryIds)->values(); // Attach only relevant industries
            unset(
                $item->industry_id,
                $item->category_id
            ); // Remove original category_id field
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
