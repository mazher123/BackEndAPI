<?php

namespace App\Repositories;

use App\Product;




class ProductRepository
{

    public function getProducts()
    {

        $products = Product::all();

        return $products;
    }

    public function storeProduct($title, $description, $price, $image)
    {

        $products = new Product();
        $products->title = $title;
        $products->description = $description;
        $products->price = $price;
        $products->image = $image;
        $products->Save();

        return "success";
    }


    public function getSingleProduct($id)
    {

        $product = Product::find($id);
        return $product;
    }


    public function UpdateProduct($title, $description, $price, $image, $id)
    {
        $product = Product::find($id);
        $product->title = $title;
        $product->description = $description;
        $product->price = $price;
        $product->image = $image;
        $product->Save();
    }


    public function deleteSingleProduct($id)
    {
        $product = Product::destroy($id);
        return $product;
    }
}
