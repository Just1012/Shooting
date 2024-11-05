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
        return view('dashboard.blog.index');
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
            // Validate the request data
            $request->validate([
                'title_ar' => 'required|string|max:255',
                'title_en' => 'required|string|max:255',
                'body_ar' => 'required|string',
                'body_en' => 'required|string',
                'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png|max:10240', // Optional image with validation
                'main_image' => 'nullable|file|mimes:jpg,jpeg,png|max:10240', // Optional image with validation
                'meta_image' => 'nullable|file|mimes:jpg,jpeg,png|max:10240', // Optional image with validation
                'meta_title' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'keywords.*' => 'string',  // Each keyword should be a string
                'categories_id' => 'required|array',
                'headings.*' => 'string|max:255', // Each heading should be a string
            ]);

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

        $currentPage = $request->currentPage;
        $perPage = 6;
        $blogs = Blog::where('status', 1)->paginate($perPage, ['*'], 'page', $currentPage);
        return response()->json([
            'data' => $blogs->items(),
            'pagination' => [
                'count' => $blogs->count(),
                'current_page' => $blogs->currentPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
                'total_pages' => $blogs->lastPage(),
            ],
            'message' => 'found data'
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
                    'meta_title',
                    'meta_description',
                    'keywords',
                    'meta_image',
                    'created_at',
                    'updated_at'
                ]);
            });
            // Return the brand details with attached categories
            return response()->json([
                'data' => $singleBlog,
                'latest_blogs' => $latestBlogs,
                'message' => 'Found Blog Single with categories',
            ]);
        } else {
            return response()->json([
                'message' => 'Blog not found',
            ], 404);
        }
    }
}
