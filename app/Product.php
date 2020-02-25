<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductInfo;
use App\ProductAddition;
use App\Category;
use App\ProductImage;
use Storage;
use Image;

class Product extends Model
{
    protected $fillable = [
        'code_number','price','qty','min_order','max_order','recommend','image','seo_key','fb_pixel',
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function infos()
    {
        return $this->hasMany('App\ProductInfo');
    }

    public function additions()
    {
        return $this->hasMany('App\ProductAddition');
    }

    public function images()
    {
        return $this->hasMany('App\ProductImage');
    }

    public function storeProduct($request)
    {
    	$product = Product::Create([
    		'code_number' => $request['code_number'],
    		'price' => $request['price'],
    		'qty' => $request['quantity'],
    		'min_order' => $request['minimum_order'],
    		'max_order' => $request['maximum_order'],
    		'recommend' => $request['recommend'],
    	]);

        $category = Category::find(json_decode($request['category_array']));
        $product->categories()->attach($category);

        $images = json_decode($request['images']);

        foreach ($images as $key => $image) {
            $filename = uniqid().'_'.$image->name;
            
            Image::make($image->path)->encode()->save(storage_path('app/public/uploads/product_imgs/images/').$filename);

            
            $product_image = ProductImage::Create([
                'product_id' => $product->id,
                'image' => $filename,
                'sort_no' => $key+1,
            ]);


            
        }

        ProductInfo::Create([
            'product_id' => $product->id,
            'language_id' => 1,
            'name' => $request['english_name'],
            'description' => $request['english_description'],
        ]);

        ProductInfo::Create([
            'product_id' => $product->id,
            'language_id' => 2,
            'name' => $request['myanmar_name'],
            'description' => $request['myanmar_description'],
        ]);

        $english_additions = json_decode($request['english_additions']);
        foreach ($english_additions as $addition) {
            ProductAddition::Create([
                'product_id' => $product->id,
                'language_id' => 1,
                'key' => $addition->key,
                'value' => $addition->value,
            ]);
        }

        $myanmar_additions = json_decode($request['myanmar_additions']);
        foreach ($myanmar_additions as $addition) {
            ProductAddition::Create([
                'product_id' => $product->id,
                'language_id' => 2,
                'key' => $addition->key,
                'value' => $addition->value,
            ]);
        }


    	return [
            'success' => true,
            'product_id' => $product->id,
        ];
    }

    public function updateProduct($request,$id)
    {
        $product = Product::find($id);

        //product
        $product->code_number = $request['code_number'];
        $product->price = $request['price'];
        $product->qty = $request['quantity'];
        $product->min_order = $request['minimum_order'];
        $product->max_order = $request['maximum_order'];
        $product->recommend = $request['recommend'];
        $product->save();

        //product_category
        $old_category = Category::find(json_decode($request['old_category_array']));
        $product->categories()->detach($old_category);
        $new_category = Category::find(json_decode($request['category_array']));
        $product->categories()->attach($new_category);

        //product_info
        $english_info = ProductInfo::find($request['english_id']);
        $myanmar_info = ProductInfo::find($request['myanmar_id']); 
        $english_info->name = $request['english_name'];
        $english_info->description = $request['english_description'];
        $myanmar_info->name = $request['myanmar_name'];
        $myanmar_info->description = $request['myanmar_description'];
        $english_info->save();
        $myanmar_info->save();

        //product additions
        $english_additions = json_decode($request['english_additions']);
        foreach ($english_additions as $addition) {
            if($addition->create_status == 1)
            {
                ProductAddition::Create([
                    'product_id' => $product->id,
                    'language_id' => 1,
                    'key' => $addition->key,
                    'value' => $addition->value,
                ]);
            }
            
            if($addition->update_status == 1)
            {
                $product_addition = ProductAddition::find($addition->id);
                $product_addition->key = $addition->key;
                $product_addition->value = $addition->value;
                $product_addition->save();
            }            
        }
        $myanmar_additions = json_decode($request['myanmar_additions']);
        foreach ($myanmar_additions as $addition) {
            if($addition->create_status == 1)
            {
                ProductAddition::Create([
                    'product_id' => $product->id,
                    'language_id' => 2,
                    'key' => $addition->key,
                    'value' => $addition->value,
                ]);
            }
            
            if($addition->update_status == 1)
            {
                $product_addition = ProductAddition::find($addition->id);
                $product_addition->key = $addition->key;
                $product_addition->value = $addition->value;
                $product_addition->save();
            }            
        }
        $destroy_additions = json_decode($request['destroy_additions']);
        foreach ($destroy_additions as $addition_id)
        {
            $product_addition = ProductAddition::find($addition_id);
            $product_addition->delete();
        }

        //product images
        $images = json_decode($request['images']);
        foreach ($images as $key => $image) {
            if($image->create_status == 1)
            {
                $filename = uniqid().'_'.$image->name;            
                Image::make($image->path)->encode()->save(storage_path('app/public/uploads/product_imgs/images/').$filename);
                $product_image = ProductImage::Create([
                    'product_id' => $product->id,
                    'image' => $filename,
                    'sort_no' => $image->sort_no,
                ]);
            }
            else{
                $product_image = ProductImage::find($image->id);
                $product_image->sort_no = $image->sort_no;
                $product_image->save();

                if($image->update_status == 1)
                {              
                    Storage::delete('public/uploads/product_imgs/images/'.$product_image->image); 
                    $filename = uniqid().'_'.$image->name;            
                    Image::make($image->path)->encode()->save(storage_path('app/public/uploads/product_imgs/images/').$filename);
                    $product_image->image = $filename;
                    $product_image->save();
                }
            }           

        }
        $destroy_images = json_decode($request['destroy_images']);
        foreach ($destroy_images as $image_id)
        {
            $product_image = ProductImage::find($image_id);
            Storage::delete('public/uploads/product_imgs/images/'.$product_image->image); 
            $product_image->delete();
        }

        return [
            'success' =>true,
        ];
    }


}
