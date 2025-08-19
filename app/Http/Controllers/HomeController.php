<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Slider;

class HomeController extends Controller
{
    public function errorPage()
    {
        return view('errors.404');
    }

    public function sendMail()
    {
        $to_name = "SUNHOUSE Test";
        $to_email = "hqtien.work@gmail.com";

        $data = [
            "name" => "Mail từ tài khoản Khách hàng",
            "body" => "Mail gửi về vấn đề hàng hóa"
        ];

        Mail::send('pages.send_mail', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email)->subject('Test thử gửi mail google');
            $message->from($to_email, $to_name);
        });
    }

    public function index(Request $request)
    {
        $slider = Slider::query()
            ->where('slider_status', 1)
            ->orderByDesc('slider_id')
            ->take(4)
            ->get();

        $meta_desc = "Chuyên bán những phụ kiện ,thiết bị, đồ gia dụng";
        $meta_keywords = "sunhouse,thiet bi dien,nha bep,gia dung";
        $meta_title = "Website Thương mại điện tử SUNHOUSE [Demo]";
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')
            ->where('category_status', 0)
            ->orderByDesc('category_id')
            ->get();

        $brand_product = DB::table('tbl_brand')
            ->where('brand_status', 0)
            ->orderByDesc('brand_id')
            ->get();

        $all_product = DB::table('tbl_product')
            ->where('product_status', 0)
            ->inRandomOrder()
            ->paginate(6);

        return view('pages.home', compact(
            'cate_product',
            'brand_product',
            'all_product',
            'meta_desc',
            'meta_keywords',
            'meta_title',
            'url_canonical',
            'slider'
        ));
    }

    public function search(Request $request)
    {
        $slider = Slider::query()
            ->where('slider_status', 1)
            ->orderByDesc('slider_id')
            ->take(4)
            ->get();

        $meta_desc = "Tìm kiếm sản phẩm";
        $meta_keywords = "Tìm kiếm sản phẩm";
        $meta_title = "Tìm kiếm sản phẩm";
        $url_canonical = $request->url();

        $keywords = $request->input('keywords_submit');

        $cate_product = DB::table('tbl_category_product')
            ->where('category_status', 0)
            ->orderByDesc('category_id')
            ->get();

        $brand_product = DB::table('tbl_brand')
            ->where('brand_status', 0)
            ->orderByDesc('brand_id')
            ->get();

        $search_product = DB::table('tbl_product')
            ->where('product_name', 'like', '%' . $keywords . '%')
            ->get();

        return view('pages.sanpham.search', compact(
            'cate_product',
            'brand_product',
            'search_product',
            'meta_desc',
            'meta_keywords',
            'meta_title',
            'url_canonical',
            'slider'
        ));
    }
}
