<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class BlogController extends Controller
{
    public function index()
    {
        return view('dashboard.blog.index');
    }

    public function getBlog()
    {
        $data = Blog::all();
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
            ]);

            $requestData = $request->all();
            $requestData['categories_id'] = json_encode($request->input('categories_id'));

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

    public function getBlogApi(Request $request)
    {

        $currentPage = $request->currentPage;
        $perPage = 6;
        $blogs = Blog::paginate($perPage, ['*'], 'page', $currentPage);
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
        $singleBlog = Blog::where('id', $id)->first();

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
            $latestBlogs = Blog::where('id', '!=', $id)->latest()->take(3)->get();
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
                'message' => 'brand not found',
            ], 404);
        }
    }
}
