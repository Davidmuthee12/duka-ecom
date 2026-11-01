<?php

require __DIR__ . '/inc/all.inc.php';

$container = new \App\support\Container();
$container->bind('pdo', function() {
    return require __DIR__ . '/inc/db-connect.inc.php';
});
 
$container->bind('productRepository', function() use($container) {
    $pdo = $container->get('pdo');
    return new \App\Repository\ProductRepository($pdo);
});

$container->bind('productController', function() use ($container) {
    $productRepository = $container->get('productRepository');
    return new \App\Frontend\Controller\ProductController($productRepository);
});

$container->bind('notFoundController', function() use($container) {
    $productRepository = $container->get('productRepository');
    return new \App\Frontend\Controller\NotFoundController(
        $productRepository
    );
});

$container->bind('csrfHelper', function() {
    return new \App\Support\CSRFHelper();
});

$csrfHelper = $container->get('csrfHelper');
$csrfHelper->handle();

function csrf_token() {
    global $container;
    $csrfHelper = $container-get('csrfHelper');
    return $csrfHelper->generateToken();
}

$route = @(string) ($_GET['route'] ?? 'products');

if ($route === 'products') {
    $product = @(string) ($_GET['product'] ?? 'index');

    $productController = $container->get('productController');
    $productController->showProducts($product);
}
else {
    $notFoundController = $container->get('notFoundController');
    $notFoundController->error404();
}