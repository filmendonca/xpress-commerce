<?php 

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Product;

class HomeController extends Controller {

	public function __construct()
	{
		$this->middleware('web');
	}

	public function index()
	{

        $prods = Product::inRandomOrder()
        ->limit(3)
		->get();

		$prods2 = Product::orderBy('created_at', 'DESC')
        ->limit(3)
		->get();

		return view('welcome', ["products" => $prods, 'others' => $prods2]);
	}

}