<?php

namespace App\Repository;

use PDO;
use App\Model\ProductModel;

class ProductRepository {

    public function __construct(private PDO $pdo) {}

    public function fetchAllProducts(): array {
        $stmt = $this->pdo->prepare('SELECT * FROM `products` ORDER BY `id` ASC');
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, ProductModel::class);
        var_dump($entries);
        return $entries;
    }

    public function fetchBySlug(string $slug): ?ProductModel {
        $stmt = $this->pdo->prepare('SELECT * FROM `products` WHERE `slug` = :slug');
        $stmt->bindValue(':slug',$slug);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, ProductModel::class);
        $entry = $stmt->fetch();
        if (!empty($entry)) {
            return $entry;
        }
        else {
            return null;
        }
    }
}