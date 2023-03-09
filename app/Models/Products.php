<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Products extends Model

{
     /**
    * ! The table associated with the model.
    *
    * @var string
    */
    protected $table = 'products';



    //!Public Data
    protected $fillable = ['generic_name','grams','product_name','category','product_id','variant_id','price','compare_at_price','level','keywords'];
    //!Hidden Data
    protected $hidden = ['keywords','created_at','updated_at','compare_at_price','level','id' ,'price'];

}

/**
 * * The Product Model Handles Products Table in the Database
 */

 // ? Is It still in the process of expansion
 