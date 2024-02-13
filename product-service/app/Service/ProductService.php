<?php

namespace App\Service;

use App\Exceptions\ProductNotFoundException;
use App\Repository\ProductRepository;
use App\Http\Requests\ProductRequest;
use App\Interfaces\ProductServiceInterface;

class ProductService 
{

 public function __construct(private ProductRepository $productRepository){}

 public function create(ProductRequest $request){
    $data = ['name' => $request->name,'description' => $request->description,'price' => $request->price];
    return $this->productRepository->save($data);
 }

 public function updateProduct(int $productId, ProductRequest $request){
  return $this->productRepository->update($productId, $request);
}


 public function getProducts(){
  try{
    return $this->productRepository->findAll();

  }catch (ProductNotFoundException $exception) {

    return response()->json([
        'error' => 'Product Not Found',
        'message' => $exception->getMessage(),
    ], 404);

  } catch (\Exception $exception) {
    
      return response()->json([
          'error' => 'Product Not Found',
          'message' => $exception->getMessage(),
      ], 500);
  }
  
 }

 public function getProduct(int $id){
    try{

      return $this->productRepository->findById($id);

    }catch (ProductNotFoundException $exception) {

      return response()->json([
          'error' => 'Product Not Found',
          'message' => $exception->getMessage(),
      ], 404);

    } catch (\Exception $exception) {
      
        return response()->json([
            'error' => 'Product Not Found',
            'message' => $exception->getMessage(),
        ], 500);
    }
 }

 public function getProductPrice(int $id){
  try{
    return $this->productRepository->findPrice($id);
  }catch (ProductNotFoundException $exception) {

    return response()->json([
        'error' => 'Product Not Found',
        'message' => $exception->getMessage(),
    ], 404);

  } catch (\Exception $exception) {
    
      return response()->json([
          'error' => 'Product Not Found',
          'message' => $exception->getMessage(),
      ], 500);
  }
}

 public function existsById(int $id){
   return $this->productRepository->existsById($id);
 }
}