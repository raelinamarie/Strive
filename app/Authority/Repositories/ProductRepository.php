<?php namespace Authority\Repositories;

use Authority\Interfaces\ProductInterface;
use \Product;

/**
 * Class CategoryRepository
 * @package Authority\Repositories
 */
class ProductRepository implements ProductInterface {
    protected $validator;
    protected $product;

    /**
     * @param CategoryValidator $validator
     * @param Category $category
     */
    public function __construct(Product $product) {
        $this->product = $product;
    }

    public function findById($product_id){
        return $this->product->find($product_id);
    }
    public function findByIds(array $product_ids){
        return 'code goes here';
    }
    public function findByName($product_name){
        return $this->product->whereName($product_name)->first();
    }
    public function findByNames(array $product_name){
        return 'code goes here';
    }
    public function getAll(){
        return $this->product->all();
    }
}