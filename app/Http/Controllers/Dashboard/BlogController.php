<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Blog;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class BlogController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('dashboard.blog.index', compact('category'));
    }

    public function getBlog(Request $request)
    {
        $status = $request->input('status');
        $blogsQuery = Blog::query()->where('is_deleted', 0);

        if (!is_null($status) && $status !== '') {
            $blogsQuery->where('status', $status);
        }

        $data = $blogsQuery->get()->map(function ($blog) {
            // Decode the categories JSON array to an array of IDs, or use an empty array if it's null or invalid
            $categoryIds = is_string($blog->categories_id) ? json_decode($blog->categories_id, true) : [];

            // Check if $categoryIds is a valid array, otherwise set it to an empty array
            if (!is_array($categoryIds)) {
                $categoryIds = [];
            }

            // Determine the field name based on the locale
            $nameField = App::getLocale() == 'ar' ? 'name_ar' : 'name_en';
            // Fetch the category names based on the IDs, if any
            $categoryNames = Category::whereIn('id', $categoryIds)->pluck($nameField)->toArray();

            return [
                'id' => $blog->id,
                'thumbnail' => asset('images/' . $blog->thumbnail),
                'title' => App::getLocale() == 'ar' ? $blog->title_ar : $blog->title_en,
                'status' => $blog->status,
                'created_at' => $blog->created_at->format('Y-m-d'),
                'categories' => $categoryNames, // Include category names instead of IDs
            ];
        });

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function addBlog()
    {
        $categories = Category::all();
        return view('dashboard.blog.blogAdd', compact('categories'));
    }

    public function storeBlog(Request $request)
    {
        try {
            $messages = [
                'title_ar.required' => 'The Arabic title is required.',
                'title_en.required' => 'The English title is required.',
                'body_ar.required' => 'The Arabic body is required.',
                'body_en.required' => 'The English body is required.',
                'thumbnail.required' => 'The thumbnail is required.',
                'main_image.required' => 'The  main image is required.',
                'thumbnail.mimes' => 'The thumbnail must be a file of type: jpg, jpeg, png.',
                'thumbnail.max' => 'The thumbnail may not be greater than 10MB.',
                'main_image.mimes' => 'The main image must be a file of type: jpg, jpeg, png.',
                'main_image.max' => 'The main image may not be greater than 10MB.',
                'meta_image.mimes' => 'The meta image must be a file of type: jpg, jpeg, png.',
                'meta_image.max' => 'The meta image may not be greater than 10MB.',
                'categories_id.required' => 'Please select at least one category.',
                'keywords.*.string' => 'Each keyword must be a valid string.',
                'headings.*.string' => 'Each heading must be a valid string.',
                'headings.*.max' => 'Each heading may not exceed 255 characters.',

                // Conditional messages for image titles and alt texts
                'thumbnail_title.required_with' => 'The thumbnail title is required when uploading a thumbnail image.',
                'thumbnail_alt.required_with' => 'The thumbnail alt text is required when uploading a thumbnail image.',
                'main_image_title.required_with' => 'The main image title is required when uploading a main image.',
                'main_image_alt.required_with' => 'The main image alt text is required when uploading a main image.',
                'meta_image_title.required_with' => 'The meta image title is required when uploading a meta image.',
                'meta_image_alt.required_with' => 'The meta image alt text is required when uploading a meta image.',
            ];

            // Validate the request data, including the new fields conditionally
            $request->validate([
                'title_ar' => 'required|string|max:255',
                'title_en' => 'required|string|max:255',
                'body_ar' => 'required|string',
                'body_en' => 'required|string',
                'thumbnail' => 'required|file|mimes:jpg,jpeg,png|max:10240',
                'main_image' => 'required|file|mimes:jpg,jpeg,png|max:10240',
                'meta_image' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
                'meta_title' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'keywords.*' => 'nullable|string',
                'categories_id' => 'required|array',
                'headings.*' => 'nullable|string|max:255',

                // Conditional validations
                'thumbnail_title' => 'nullable|string|max:255',
                'thumbnail_alt' => 'nullable|string',
                'main_image_title' => 'nullable|string',
                'main_image_alt' => 'nullable|string',
                'meta_image_title' => 'nullable|string|max:255',
                'meta_image_alt' => 'nullable|string',
            ], $messages);

            $requestData = $request->all();
            $requestData['categories_id'] = json_encode($request->input('categories_id'));
            $requestData['headings'] = json_encode($request->input('headings'));


            // Handle thumbnail image upload
            if ($request->hasFile('thumbnail')) {
                $thumbnailName = time() . '_thumbnail.' . $request->thumbnail->getClientOriginalExtension();
                $request->thumbnail->move(public_path('images'), $thumbnailName);
                $requestData['thumbnail'] = $thumbnailName;
            }

            // Handle main image upload
            if ($request->hasFile('main_image')) {
                $mainImageName = time() . '_main_image.' . $request->main_image->getClientOriginalExtension();
                $request->main_image->move(public_path('images'), $mainImageName);
                $requestData['main_image'] = $mainImageName;
            }

            // Handle meta image upload
            if ($request->hasFile('meta_image')) {
                $mainImageName = time() . '_meta_image.' . $request->meta_image->getClientOriginalExtension();
                $request->meta_image->move(public_path('images'), $mainImageName);
                $requestData['meta_image'] = $mainImageName;
            }

            // Convert keywords to JSON format if provided
            if ($request->has('keywords')) {
                $requestData['keywords'] = json_encode($request->keywords);
            }

            // Create the blog post
            Blog::create($requestData);

            // Success message
            toastr()->success(__('Blog Added Successfully'), __('Success'));
            return redirect()->route('blog.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Collect validation errors for toastr
            foreach ($e->errors() as $errorMessages) {
                foreach ($errorMessages as $errorMessage) {
                    toastr()->error($errorMessage);
                }
            }
            return redirect()->back()->withInput();
        } catch (\Throwable $th) {

            toastr()->error(__('Try Again'));
            return redirect()->back()->withInput(); // Preserve input data on error
        }
    }

    public function editBlog(Blog $id)
    {
        $categories = Category::all();
        return view('dashboard.blog.blogEdit', compact('id', 'categories'));
    }

    public function updateBlog(Request $request, $id)
    {
        try {
            // Find the blog by its ID or throw a 404 error
            $blog = Blog::findOrFail($id);
            // Get all request data
            $requestData = $request->all();
            $requestData['categories_id'] = json_encode($request->input('categories_id'));
            $requestData['headings'] = json_encode($request->input('headings'));
            // Handle keywords as JSON
            if ($request->has('keywords')) {
                $requestData['keywords'] = json_encode($request->input('keywords'));
            }

            // Handle thumbnail image upload
            if ($request->hasFile('thumbnail')) {
                $thumbnailName = time() . '_thumbnail.' . $request->thumbnail->getClientOriginalExtension();
                $request->thumbnail->move(public_path('images'), $thumbnailName);
                if ($blog->thumbnail && file_exists(public_path('images/' . $blog->thumbnail))) {
                    unlink(public_path('images/' . $blog->thumbnail));
                }
                $requestData['thumbnail'] = $thumbnailName;
            }

            // Handle main image upload
            if ($request->hasFile('main_image')) {
                $mainImageName = time() . '_main_image.' . $request->main_image->getClientOriginalExtension();
                $request->main_image->move(public_path('images'), $mainImageName);
                if ($blog->main_image && file_exists(public_path('images/' . $blog->main_image))) {
                    unlink(public_path('images/' . $blog->main_image));
                }
                $requestData['main_image'] = $mainImageName;
            }

            // Handle meta image upload
            if ($request->hasFile('meta_image')) {
                $mainImageName = time() . '_meta_image.' . $request->meta_image->getClientOriginalExtension();
                $request->meta_image->move(public_path('images'), $mainImageName);
                if ($blog->meta_image && file_exists(public_path('images/' . $blog->meta_image))) {
                    unlink(public_path('images/' . $blog->meta_image));
                }
                $requestData['meta_image'] = $mainImageName;
            }

            if ($request->has('created_at')) {
                $requestData['created_at'] = Carbon::createFromFormat('Y-m-d H:i', $request->input('created_at'));
            }
            $blog->update($requestData);
            toastr()->success(__('Blog Updated Successfully'), __('Success'));
            return redirect()->route('blog.index');
        } catch (\Throwable $th) {

            // Error message
            toastr()->error(__('Try Again'), __('Error'));

            return redirect()->back()->withInput();
        }
    }

    public function updateStatus(Blog $blog)
    {
        try {
            $blog->update([
                'status' => $blog->status == 0 ? 1 : 0
            ]);

            $successMessage = $blog->status == 1 ?
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

    public function filter(Request $request)
    {
        $category = $request->input('category');
        $status = $request->input('status');
        $query = Blog::query()->where('is_deleted', 0);

        // Filter by category if provided
        if (!empty($category)) {
            $query->whereJsonContains('categories_id', $category);
        }

        // Filter by status if provided
        if (!is_null($status) && $status !== '') {
            $query->where('status', $status);
        }

        $filteredBlogs = $query->get()->map(function ($blog) {
            // Decode the categories JSON array to an array of IDs
            $categoryIds = is_string($blog->categories_id) ? json_decode($blog->categories_id, true) : [];

            // Check if $categoryIds is a valid array, otherwise set it to an empty array
            if (!is_array($categoryIds)) {
                $categoryIds = [];
            }

            // Determine the field name based on the locale
            $nameField = App::getLocale() == 'ar' ? 'name_ar' : 'name_en';

            // Fetch the category names based on the IDs
            $categoryNames = Category::whereIn('id', $categoryIds)->pluck($nameField)->toArray();

            return [
                'id' => $blog->id,
                'thumbnail' => asset('images/' . $blog->thumbnail),
                'title' => App::getLocale() == 'ar' ? $blog->title_ar : $blog->title_en,
                'status' => $blog->status,
                'created_at' => $blog->created_at->format('Y-m-d'),
                'categories' => $categoryNames, // Include category names instead of IDs
            ];
        });

        return response()->json([
            'data' => $filteredBlogs,
            'message' => 'Data found',
        ]);
    }

    public function blogTest($id)
    {
        $blog = Blog::where('id', $id)->first();
        if ($blog) {
            return view('dashboard.blog.blogTest', compact('blog'));
        } else {
            // Error message
            toastr()->error(__('Blog Not Found'), __('Error'));
            return redirect()->back()->withInput();
        }
    }

    // Soft Delete Functions
    public function softDeleteBlog($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            $blog->is_deleted = 1;
            $blog->save();

            toastr()->success(__('Blog Moved to trash Successfully'), __('Success'));
            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            toastr()->error(__('Blog Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function blogTrash()
    {
        return view('dashboard.blog.blogTrash');
    }

    public function getBlogForTrash(Request $request)
    {
        $status = $request->input('status');
        $blogsQuery = Blog::query()->where('is_deleted', 1);

        if (!is_null($status) && $status !== '') {
            $blogsQuery->where('status', $status);
        }

        $data = $blogsQuery->get()->map(function ($blog) {
            // Decode the categories JSON array to an array of IDs, or use an empty array if it's null or invalid
            $categoryIds = is_string($blog->categories_id) ? json_decode($blog->categories_id, true) : [];

            // Check if $categoryIds is a valid array, otherwise set it to an empty array
            if (!is_array($categoryIds)) {
                $categoryIds = [];
            }

            // Determine the field name based on the locale
            $nameField = App::getLocale() == 'ar' ? 'name_ar' : 'name_en';
            // Fetch the category names based on the IDs, if any
            $categoryNames = Category::whereIn('id', $categoryIds)->pluck($nameField)->toArray();

            return [
                'id' => $blog->id,
                'thumbnail' => asset('images/' . $blog->thumbnail),
                'title' => App::getLocale() == 'ar' ? $blog->title_ar : $blog->title_en,
                'status' => $blog->status,
                'created_at' => $blog->created_at->format('Y-m-d'),
                'categories' => $categoryNames, // Include category names instead of IDs
            ];
        });

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function restoreBlog($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            $blog->is_deleted = 0;
            $blog->save();

            toastr()->success(__('Blog Restored Successfully'), __('Success'));
            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            toastr()->error(__('Blog Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function deleteBlog($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            if ($blog->thumbnail && file_exists(public_path('images/' . $blog->thumbnail))) {
                unlink(public_path('images/' . $blog->thumbnail));
            }
            if ($blog->main_image && file_exists(public_path('images/' . $blog->main_image))) {
                unlink(public_path('images/' . $blog->main_image));
            }
            if ($blog->meta_image && file_exists(public_path('images/' . $blog->meta_image))) {
                unlink(public_path('images/' . $blog->meta_image));
            }
            $blog->delete();

            toastr()->success(__('Blog Deleted Successfully'), __('Success'));
            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            toastr()->error(__('Blog Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }


    // Blog Api
    public function getBlogApi(Request $request)
    {
        $category = $request->category; // Get category from the request
        $currentPage = $request->currentPage ?: 1; // Default to page 1 if not provided
        $perPage = 6; // Number of items per page

        // Base query to filter blogs by status
        $query = Blog::where('status', 1);

        // Apply category filter if a specific category ID is provided
        if (!empty($category)) {
            $query->whereJsonContains('categories_id', $category);
        }

        // Paginate the filtered results
        $blogs = $query->paginate($perPage, ['*'], 'page', $currentPage);

        // Return paginated data and additional pagination info
        return response()->json([
            'data' => $blogs->items(), // Current page data
            'pagination' => [
                'count' => $blogs->count(), // Items on the current page
                'current_page' => $blogs->currentPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(), // Total items
                'total_pages' => $blogs->lastPage(), // Total number of pages
            ],
            'message' => 'Blogs fetched successfully'
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

    public function getSingleBlogApi($id)
    {
        // Fetch the brand details and its related OurWork
        $singleBlog = Blog::where('status', 1)->where('id', $id)->first();

        if ($singleBlog) {
            // Extract and decode the category_id from the related OurWork
            $categoryIds = json_decode($singleBlog->categories_id, true);

            // If there are category IDs, fetch the categories
            if (!empty($categoryIds)) {
                $categories = Category::whereIn('id', $categoryIds)->get();
            } else {
                $categories = collect([]);  // Return an empty collection if no category IDs
            }

            // Attach the categories to the ourWork relation
            $singleBlog->categories = $categories;

            // Fetch the latest 3 blogs, excluding the current one
            $latestBlogs = Blog::where('status', 1)->where('id', '!=', $id)->latest()->take(3)->get();
            // Hide the unwanted fields from each blog in the latestBlogs collection
            $latestBlogs->each(function ($blog) {
                $blog->makeHidden([
                    'body_ar',
                    'body_en',
                    'thumbnail',
                    'main_image',
                    'status',
                    'categories_id',

                    'meta_description',
                    'keywords',
                    'meta_image',
                    'created_at',
                    'updated_at',
                    'is_deleted',
                    'headings',
                    'thumbnail_title',
                    'thumbnail_alt',
                    'main_image_title',
                    'main_image_alt',
                    'meta_image_title',
                    'meta_image_alt',
                ]);
            });

            // Process the 'headings' field to ensure it is an array of strings
            $headings = json_decode($singleBlog->headings, true);
            if ($headings && is_array($headings)) {
                // Convert each item in the headings array to a string if it's not already
                $headings = array_map('strval', $headings);
            } else {
                // If there are no headings or it's not an array, return an empty array
                $headings = [];
            }

            // Attach the processed headings to the blog object
            $singleBlog->headings = $headings;
            // Fetch the previous blog (one with an id less than the current blog)
            $previousBlogId = Blog::where('status', 1)
                ->where('id', '<', $id)
                ->orderBy('id', 'desc') // Get the highest ID less than current one
                ->pluck('id') // Fetch only the 'id' field
                ->first(); // Get the first result (if any)

            // Fetch the next blog (one with an id greater than the current blog)
            $nextBlogId = Blog::where('status', 1)
                ->where('id', '>', $id)
                ->orderBy('id', 'asc') // Get the lowest ID greater than current one
                ->pluck('id') // Fetch only the 'id' field
                ->first(); // Get the first result (if any)

            // Return the brand details with attached categories
            return response()->json([
                'data' => $singleBlog,
                'latest_blogs' => $latestBlogs,
                'previous_blog' => $previousBlogId ? $previousBlogId : false, // If no previous blog, return false
                'next_blog' => $nextBlogId ? $nextBlogId : false, // If no next blog, return false
                'message' => 'Found Blog Single with categories',
            ]);
        } else {
            return response()->json([
                'message' => 'Blog not found',
            ], 404);
        }
    }

    public function blogFilterApi(Request $request)
    {
        $category = $request->input('category');
        $status = $request->input('status');
        $query = Blog::query()->where('is_deleted', 0);

        // Filter by category if provided
        if (!empty($category)) {
            $query->whereJsonContains('categories_id', $category);
        }

        // Filter by status if provided
        if (!is_null($status) && $status !== '') {
            $query->where('status', $status);
        }

        $filteredBlogs = $query->get()->map(function ($blog) {
            // Decode the categories JSON array to an array of IDs
            $categoryIds = is_string($blog->categories_id) ? json_decode($blog->categories_id, true) : [];

            // Check if $categoryIds is a valid array, otherwise set it to an empty array
            if (!is_array($categoryIds)) {
                $categoryIds = [];
            }

            // Determine the field name based on the locale
            $nameField = App::getLocale() == 'ar' ? 'name_ar' : 'name_en';

            // Fetch the category names based on the IDs
            $categoryNames = Category::whereIn('id', $categoryIds)->pluck($nameField)->toArray();

            return [
                'id' => $blog->id,
                'thumbnail' => asset('images/' . $blog->thumbnail),
                'title' => App::getLocale() == 'ar' ? $blog->title_ar : $blog->title_en,
                'status' => $blog->status,
                'created_at' => $blog->created_at->format('Y-m-d'),
                'categories' => $categoryNames, // Include category names instead of IDs
            ];
        });

        return response()->json([
            'data' => $filteredBlogs,
            'message' => 'Data found',
        ]);
    }
}
