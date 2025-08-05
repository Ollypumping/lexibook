<?php

class Book {
    private $conn;
    private $table = 'books';

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    // Get all books
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get book by ID
    public function getById($id) {
        $sql = "SELECT id, title, author, published_year, created_at, updated_at FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get paginated books
    public function getPaginated($limit, $offset, $id) {
        $sql = "SELECT id, title, author, published_year, created_at, updated_at FROM {$this->table} WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new book
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (title, author, isbn, published_year) 
                VALUES (:title, :author, :isbn, :published_year)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':author', $data['author']);
        $stmt->bindParam(':isbn', $data['isbn']);
        $stmt->bindParam(':published_year', $data['published_year'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Update a book
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} 
                SET title = :title, author = :author, isbn = :isbn, published_year = :published_year 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':author', $data['author']);
        $stmt->bindParam(':isbn', $data['isbn']);
        $stmt->bindParam(':published_year', $data['published_year'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Delete a book
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    

    
}