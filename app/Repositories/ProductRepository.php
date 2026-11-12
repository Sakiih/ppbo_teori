<?php

namespace App\Repositories;

use PDO;
use App\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private PDO $db
    ) {}

    public function getAll(): array
    {
        $sql = "SELECT * FROM products ORDER BY id DESC";

        return $this->db->query($sql)->fetchAll();
    }

    public function search(string $term): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM products
             WHERE name LIKE :search
             ORDER BY id DESC"
        );

        $stmt->execute(['search' => '%' . $term . '%']);

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM products WHERE id = :id"
        );

        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): array
    {
        $sql = "INSERT INTO products
                (category_id, name, price, stock)
                VALUES (:category_id, :name, :price, :stock)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return $this->findById(
            (int) $this->db->lastInsertId()
        );
    }

    public function update(int $id, array $data): ?array
    {
        $sql = "UPDATE products
                SET category_id = :category_id,
                    name = :name,
                    price = :price,
                    stock = :stock
                WHERE id = :id";

        $data['id'] = $id;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return $this->findById($id);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM products WHERE id = :id"
        );

        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
