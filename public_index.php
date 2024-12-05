<?php

require_once __DIR__ . '/vendor/autoload.php';
require 'vendor/autoload.php';

use App\Controllers\PropertyController;
use App\Controllers\TenantController;
use App\Controllers\LeaseAgreementController;
use Dotenv\Dotenv;
use App\Database\Database;


try {
    $db = Database::getConnection();
    echo "Database connection successful!";
} catch (Exception $e) {
    echo "Database connection failed: " . $e->getMessage();
}

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();


// Set up error handling
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Set up CORS headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

// Parse the URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// Define the endpoints and controllers
$endpoints = [
    'properties' => new PropertyController(),
    'tenants' => new TenantController(),
    'lease-agreements' => new LeaseAgreementController()
];

// Route the request to the appropriate controller
$resource = $uri[1] ?? null;
$id = $uri[2] ?? null;

if (!array_key_exists($resource, $endpoints)) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$controller = $endpoints[$resource];

// Handle the request
$method = $_SERVER['REQUEST_METHOD'];
try {
    switch ($method) {
        case 'GET':
            if ($id) {
                $response = $controller->getById($id);
            } else {
                $response = $controller->getAll();
            }
            echo json_encode($response);
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $id = $controller->create($data);
            echo json_encode(['id' => $id]);
            break;
        case 'PUT':
            if (!$id) {
                throw new Exception("ID is required for PUT request");
            }
            $data = json_decode(file_get_contents("php://input"), true);
            $success = $controller->update($id, $data);
            echo json_encode(['success' => $success]);
            break;
        case 'DELETE':
            if (!$id) {
                throw new Exception("ID is required for DELETE request");
            }
            $success = $controller->delete($id);
            echo json_encode(['success' => $success]);
            break;
        default:
            header("HTTP/1.1 405 Method Not Allowed");
            exit();
    }
} catch (Exception $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(['error' => $e->getMessage()]);
}

