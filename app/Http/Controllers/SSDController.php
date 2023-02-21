<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Signifly\Shopify\Shopify;
use Illuminate\Support\Facades\Validator;
use App\Models\Products;

class SSDController extends Controller
{
    /**
     * ! Auth Middleware.
     * * Middleware for checking the Authentication of user.
    */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * ! DISPLAY ALL PRODUCTS CONTROLLER.
     * * Display a listing of the Product resource.
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // // {
    //     /** 
    //      *   ! Being Used In Infinite Scolling
    //      *todo This controller will replace the Shopify Display all Product(index) in ShopifyContoller.  
    //      *   ? Does the controller needs a limit in number or not
    //      *   ? is this The right Controller for this Fucntion
    //      */
    //     $admin = auth()->user()->permission; 
    //     if($admin == 1){
    //     // * Search Query Search ALL Products in Products Table Order By Level DESC Paginated By (10)
    //     $products = Products::orderBy('level', 'DESC')->paginate(10);
		
	// 	ob_flush();
	// 	flush();
	// 	// if you're using sessions, this prevents subsequent requests
	// 	// from hanging while the background process executes
	// 	if (session_id()) {session_write_close();}

		
		
    //     return response()->json($products);
    //     }

    //     $res = [
    //         "User" => "Unauthorized"
    //     ];

	// 	ob_flush();
	// 	flush();
	// 	// if you're using sessions, this prevents subsequent requests
	// 	// from hanging while the background process executes
	// 	if (session_id()) {session_write_close();}

    //     return response()->json($res,400);
		
    // }

    //   /**
    //  * ! Search Product From Shopify Shop.
    //  * Display the specified Product From Shopify.
    //  *
    //  * @param  int  $pid
    //  * @param  \Signifly\Shopify\Shopify;  $shopify
    //  * @return \Illuminate\Http\Response
    //  */


    // public function show($pid, Shopify $shopify)
    // {
    //     //  * Get Product in Shopify w/ Product_id = $pid.
    //     $product = $shopify->getProduct($pid);

    //     //  * Get Product Variant First key[0]. 
    //     $variant = $product->variants[0];

    //     //  * Get Product Variant id. 
    //     $variant_id = $variant['id'];

    //     //  * Get Product Variant Quantity. 
    //     $inventory_quantity = $variant['inventory_quantity'];

    //     //  * Response Object. 
    //     $response = [
    //         'variant_id' => $variant_id,
    //         'inventory_quantity' => $inventory_quantity
    //     ];
		
	// 	ob_flush();
	// 	flush();
	// 	// if you're using sessions, this prevents subsequent requests
	// 	// from hanging while the background process executes
	// 	if (session_id()) {session_write_close();}
			
	
    //     //  * Return Response Object -> Json. 
    //     return response()->json($response);
		
    // }
}
