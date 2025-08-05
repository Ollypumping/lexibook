<?php
require_once __DIR__.'/../middleware/AuthMiddleware.php';
require_once __DIR__.'/../model/Book.php';
require_once __DIR__.'/../helpers/ResponseHelper.php';

class BookController extends AuthMiddleware {
    private $bookModel;

    public function __construct($db) {
        parent::__construct($db);
        $this->bookModel = new Book($this->db);
    }


    // GET all books
    public function display() {
        $books = $this->bookModel->getAll();
        if ($books) {
            ResponseHelper::success('Books retrieved successfully', $books);
        } else {
            ResponseHelper::error('No books found', 404);
        }
    }


    // GET specific book
    public function show($id) {
        $book = $this->bookModel->getById($id);
        if ($book) {
            ResponseHelper::success('Book found', $book);
        } else {
            ResponseHelper::error('Book not found', 404);
        }
    }

    // GET books (with pagination)
    public function index() {
        $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $id = $this->user['id'];

        $books = $this->bookModel->getPaginated($limit, $offset, $id);
        ResponseHelper::success('Books retrieved', [
            'page' => $page,
            'limit' => $limit,
            'data' => $books
        ]);
    }

    // POST/STORE books
    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['title']) || empty($data['author']) || empty($data['isbn']) || empty($data['published_year'])) {
            ResponseHelper::error('All fields are required', 400);
            
        }
        ResponseHelper::validateYear($data['published_year']);

        $created = $this->bookModel->create($data);
        if ($created) {
            ResponseHelper::success('Book created successfully');
        } else {
            ResponseHelper::error('Failed to create book', 500);
        }
    }

    // PUT/UPDATE books
    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['title']) || empty($data['author']) || empty($data['isbn']) || empty($data['published_year'])) {
            ResponseHelper::error('All fields are required', 400);
        }

        $updated = $this->bookModel->update($id, $data);
        if ($updated) {
            ResponseHelper::success('Book updated successfully');
        } else {
            ResponseHelper::error('Book not found or update failed', 404);
        }
    }

    // DELETE books
    public function delete($id) {
        $deleted = $this->bookModel->delete($id);
        if ($deleted) {
            ResponseHelper::success('Book deleted successfully');
        } else {
            ResponseHelper::error('Book not found', 404);
        }
    }
}