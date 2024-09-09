<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HomeSection;
use App\Models\HomeSlider;
use App\Models\OurWork;
use App\Models\Partner;
use App\Models\SystemSetup;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $slider = HomeSlider::where('status', 1)->get();
        $category = Category::where('status', 1)->get();
        $brands = OurWork::where('status', 1)->get();
        $content = HomeSection::first();
        $partner = Partner::where('status',1)->get();
        $gif = SystemSetup::first();
        return view('welcome', compact('slider', 'category', 'brands','content', 'partner','gif'));
    }

    public function getAllBrands()
    {
        // Fetch all brands and their categories
        $brands = OurWork::where('status', 1)->get();
        foreach ($brands as $brand) {
            $categoryIds = json_decode($brand->category_id);
            $brand->categories = Category::whereIn('id', $categoryIds)->get(['id', 'name_en', 'name_ar']);
        }
        return response()->json([
            'brands' => $brands
        ]);
    }

    public function filterByCategory($categoryId)
    {
        // Fetch brands that are associated with the selected category
        $brands = OurWork::whereJsonContains('category_id', $categoryId)->where('status', 1)->get();
        foreach ($brands as $brand) {
            $categoryIds = json_decode($brand->category_id);
            $brand->categories = Category::whereIn('id', $categoryIds)->get(['id', 'name_en', 'name_ar']);
        }
        return response()->json([
            'brands' => $brands
        ]);
    }
}
