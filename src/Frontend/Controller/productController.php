<?php

namespace App\Frontend\Controller;

use App\Repository\ProductRepository;

class ProductController extends AbstractController {

    public function __construct(ProductRepository $productRepository) {
        parent::__construct($productRepository);
    }

    public function showProducts() {
        $product = $this->productRepository->fetchAllProducts();

        // if (empty($product)) {
        //     $this->error404();
        //     return;
        // }

        $this->render('pages/showProduct', [
            'product' => $product
        ]);
    }
}