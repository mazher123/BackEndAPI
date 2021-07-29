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
}
