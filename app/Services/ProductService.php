<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Exception;
use Validator;
use InvalidArgumentException;
use phpDocumentor\Reflection\Types\Null_;

class ProductService
{

    protected $ProductRepository;

    public function __construct(ProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }


    public function showProducts()
    {

        $products = $this->ProductRepository->getProducts();

        if ($products) {

            return ['data' => $products, 'message' => "product found", 'StatusCode' => 200];
        } else {
            return ['data' => $products, 'message' => "product not found", 'StatusCode' => 202];
        }
    }


    public function showSingleProduct($id)
    {

        $product = $this->ProductRepository->getSingleProduct($id);

        if ($product) {
            return ['data' => $product, 'message' => "product found", 'StatusCode' => 200];
        } else {
            return ['data' => $product, 'message' => "product not found", 'StatusCode' => 202];
        }
    }

    public function createProducts($request)
    {
        try {

            $title = $request->title;
            $description = $request->description;
            $price = $request->price;
            $image = $request->image;

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'image' => 'mimes:jpeg,jpg,png,gif|max:5120',

            ]);
            if ($validator->fails()) {
                $messages = $validator->messages();
                $errors = $messages->all();

                return ['message' => $errors, "StatusCode" => 400];
            }



            $image1 = date('Ymdhis') . '.' .  $image->getClientOriginalExtension();
            if ($image->move(public_path() . '/image/product/', $image1)) {

                $image = url('/image/product/' . $image1) ;
            }


            $store = $this->ProductRepository->storeProduct($title, $description, $price, $image);

            return ['message' => "created successfully", "StatusCode" => 200];
        } catch (Exception $e) {
            return ['message' => $e->getMessage(), "StatusCode" => 400];
        }
    }



    public function UpdateProduct($request, $id)
    {

        try {

            $title = $request->title;
            $description = $request->description;
            $price = $request->price;
            $image = $request->image;

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'price' => 'required',
                //'image' => 'mimes:jpeg,jpg,png,gif|max:5120',

            ]);
            if ($validator->fails()) {
                $messages = $validator->messages();
                $errors = $messages->all();

                return ['message' => $errors, "StatusCode" => 400];
            }

            if ($request->file('image')) {
                $image1 = date('Ymdhis') . '.' .  $image->getClientOriginalExtension();
                if ($image->move(public_path() . '/image/product/', $image1)) {

                    $image = url('/image/product/' . $image1) ;
                }
            }



            $store = $this->ProductRepository->UpdateProduct($title, $description, $price, $image, $id);

            return ['message' => "updated successfully", "StatusCode" => 200];
        } catch (Exception $e) {
            return ['message' => $e->getMessage(), "StatusCode" => 400];
        }
    }


    public function destroySingleProduct($id){

        $product = $this->ProductRepository->deleteSingleProduct($id);

        if ($product) {
            return [ 'message' => "Deleted successfully", 'StatusCode' => 200];
        } else {
            return ['message' => "product not found", 'StatusCode' => 202];
        }
    }
}
