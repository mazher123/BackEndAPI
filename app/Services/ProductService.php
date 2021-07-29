<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Exception;
use Validator;
use InvalidArgumentException;

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
                'title' => 'required|max:100',
                'description' => 'required|max:150',
                'price' => 'required|max:150',
                'image' => 'mimes:jpeg,jpg,png,gif|max:5120',

            ]);
            if ($validator->fails()) {
                $messages = $validator->messages();
                $errors = $messages->all();

                return ['message' => $errors, "StatusCode" => 200];
            }


            $image1 = date('Ymdhis') . '.' .  $image->getClientOriginalExtension();
            if ($image->move(public_path() . '/image/product/', $image1)) {

                $image = '/image/product/' . $image1;
            }


            $store = $this->ProductRepository->storeProduct($title, $description, $price, $image);

            return ['message' => "created successfully", "StatusCode" => 200];
        } catch (Exception $e) {
            return ['message' => $e->getMessage(), "StatusCode" => 400];
        } catch (\Illuminate\Validation\ValidationException $e) {

            $arrError = $e->errors();

            foreach ($arrError as $key => $value) {
                $arrImplode[] = implode(', ', $arrError[$key]);
            }
            $message = implode(', ', $arrImplode);
            /**
             * Populate the respose array for the JSON
             */
            $arrResponse = array(
                'result' => 0,
                'reason' => $message,
                'data' => array(),
                'statusCode' => $e->status,
            );
        }
    }



    public function editProducts()
    {
    }
}
