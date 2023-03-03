<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;



class ProductController extends Controller
{
    /**
     * ! Auth Middleware.
     * * Middleware for checking the Authentication of user.
     */
    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['show']]);
        // $this->middleware('auth:api');
    }

    /**
     * ! DISPLAY ALL PRODUCTS CONTROLLER.
     * * Display a listing of the Product resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //  $headers = apache_request_headers();
        //  $beartoken = $headers['Authorization'];
        //  $actvtoken = auth()->user()->active_token;
        $admin = auth()->user()->permission;

        // if($beartoken == "Bearer $actvtoken"){

        if ($admin === 1) {


            /*   ! For Development Purpose. 
                *todo This controller will replace the Shopify Display all Product(index) in ShopifyContoller.  
                *todo Must be Paginated by 10.
                *   ? Does the controller needs a limit in number or not
                *   ? is this The right Controller for this Fucntion
                */
            // * Search Query Search ALL Products in Products Table
            $products = Products::orderBy('level', 'DESC')->paginate(10);


            // ob_flush();
            // flush();
            // // if you're using sessions, this prevents subsequent requests
            // // from hanging while the background process executes
            // if (session_id()) {
            //     session_write_close();
            // }

            //    $data = $this->paginate($products);


            return response()->json($products);
        } else {
            $res = [
                "Msg" => "User Unauthorized"
            ];

            // ob_flush();
            // flush();
            // // if you're using sessions, this prevents subsequent requests
            // // from hanging while the background process executes
            // if (session_id()) {
            //     session_write_close();
            // }
            return response()->json($res, 400);
        }



        // }else{

        //     $mg = [
        //         "Msg" => "Auth Token Not Valid"
        //     ];


        //     ob_flush();
        //     flush();
        //     // if you're using sessions, this prevents subsequent requests
        //     // from hanging while the background process executes
        //     if (session_id()) {session_write_close();}
        //     return response()->json($mg,400);
        // }

    }

    /**
     ! Pagination Scripts Function For Shopify
     * Paginate the Shopipy store resource result by (n) .
     * @param  $items, $perPage, $page, $options
     * @return \Illuminate\Http\Response
     */
    public function paginate($items, $perPage = 22, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator(array_values($items->forPage($page, $perPage)
            ->toArray()), $items->count(), $perPage, $page, $options);
    }

    /**
     * ! SEARCH ENGINE CONTROLLER.
     * * Display the specified resource by Search Term.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // $headers = apache_request_headers();
        // $beartoken = $headers['Authorization'];
        // $actvtoken = auth()->user()->active_token;


        // if ($beartoken == "Bearer $actvtoken") {
            // * Search Query Search Mulltiple Table For Pattern
            $products = Products::where('generic_name', 'LIKE', "%$slug%")
                ->orWhere('keywords', 'LIKE', "%$slug%")   
                ->orWhere('category', 'LIKE', "%$slug%") 
                ->orWhere('grams', 'LIKE', "%$slug%")
                // ->orWhere('product_name', 'LIKE', "%$slug%")
                ->orderBy('level', 'DESC')->limit(3)
                ->get();


            // * Error Handler If Empty
            if ($products->isEmpty()) {

                $response =  [

                    ['Msg' => 'Product Not Found']

                ];


                // // if you're using sessions, this prevents subsequent requests
                // // from hanging while the background process executes
                // if (session_id()) {
                //     session_write_close();
                // }
                // ob_flush();
                // flush();
                // // if you're using sessions, this prevents subsequent requests
                // // from hanging while the background process executes
                // if (session_id()) {
                //     session_write_close();
                // }


                return ($response);
            }

            // ob_flush();
            // flush();
            // // if you're using sessions, this prevents subsequent requests
            // // from hanging while the background process executes
            // if (session_id()) {
            //     session_write_close();
            // }
                
            // $res = str_replace(']', '}', $products);
            // $res2 = str_replace('[', '{', $res);
            
            // $json = json_encode($res2);
            
            // $jsonData = stripslashes($json);
            
            // // $str = str_replace('"', '', $jsonData);
                    
            // // if the first char is a " then remove it
            // if(strpos($jsonData,'"')===0)$jsonData=substr($jsonData,1,(strlen($jsonData)-1));

            // // if the last char is a " then remove it
            // if(strripos($jsonData,'"')===(strlen($jsonData)-1))$jsonData=substr($jsonData,0,-1);


            $obj = json_decode (json_encode ($products), FALSE);


            return response($obj,200);
        // } else {

        //     $mg = [
        //         "Msg" => "Auth Token Not Valid"
        //     ];

        //     return response()->json($mg, 400);
        // }
    }


    /**
     * ! INSERT NEW PRODUCT CONTROLLER.
     * * Store a newly created Product in storage/database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $admin = auth()->user()->permission;
        if ($admin === 1) {
            // * Input Parameters = Asigned Variable
            $generic_name = $request->input('generic_name');
            $grams = $request->input('grams');
            $product_name = $request->input('product_name');
            $category = $request->input('category');
            $product_id = $request->input('product_id');
            $variant_id = $request->input('variant_id');
            $price = $request->input('price');
            $compare_at_price = $request->input('compare_at_price');
            $level = $request->input('level');
            $keyword = $request->input('keyword');

            // * Success Response
            $product = new Products([
                'generic_name' => $generic_name,
                'grams' => $grams,
                'product_name' => $product_name,
                'category' => $category,
                'product_id' => $product_id,
                'variant_id' => $variant_id,
                'price' => $price,
                'compare_at_price' => $compare_at_price,
                'level' => $level,
                'keyword' => $keyword
            ]);

            // * if OK save
            if ($product->save()) {

                // ob_flush();
                // flush();
                // // if you're using sessions, this prevents subsequent requests
                // // from hanging while the background process executes
                // if (session_id()) {
                //     session_write_close();
                // }
            }
            return response()->json($product);
        }

        $res = [
            "User" => "Unauthorized"
        ];


        // ob_flush();
        // flush();
        // // if you're using sessions, this prevents subsequent requests
        // // from hanging while the background process executes
        // if (session_id()) {
        //     session_write_close();
        // }


        return response()->json($res, 400);
    }



    public function search( $generic_name, $product)
    {
        // $headers = apache_request_headers();
        // $beartoken = $headers['Authorization'];
        // $actvtoken = auth()->user()->active_token;


        // if ($beartoken == "Bearer $actvtoken") {
            // * Search Query Search Mulltiple Table For Pattern
            $products = Products::where('generic_name', 'LIKE', "%$generic_name%")
            ->where('keywords', 'LIKE', "%$product%")->limit(10)
             ->orWhere('product_name', 'LIKE', "%$product%")
             ->get();


            // * Error Handler If Empty
            if ($products->isEmpty()) {

                $response =  [

                    ['Msg' => 'Product Not Found']

                ];


                // // if you're using sessions, this prevents subsequent requests
                // // from hanging while the background process executes
                // if (session_id()) {
                //     session_write_close();
                // }
                // ob_flush();
                // flush();
                // // if you're using sessions, this prevents subsequent requests
                // // from hanging while the background process executes
                // if (session_id()) {
                //     session_write_close();
                // }


                return ($response);
            }

            // ob_flush();
            // flush();
            // // if you're using sessions, this prevents subsequent requests
            // // from hanging while the background process executes
            // if (session_id()) {
            //     session_write_close();
            // }

            return response()->json($products,200);
        // } else {

        //     $mg = [
        //         "Msg" => "Auth Token Not Valid"
        //     ];

        //     return response()->json($mg, 400);
        // }
    }




















    // ! Controllers Not in use for now ----------------------------------------------------------------------------->

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
