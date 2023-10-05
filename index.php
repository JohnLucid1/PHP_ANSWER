<?php
header("Content-Type: application/json");

$host = "postgres"; // INFO : the name of the container
$port = "5432";
$db_name = "habrdb";
$user = "postgres";
$pass  = "mysecretpassword";

// Задание: https://github.com/fugr-ru/php-laravel 
// api/v1/notebook/?page=2&limit=10

try {
  // Establish database connection
  $conn = new PDO("pgsql:host=$host;port=$port;dbname=$db_name;user=$user;password=$pass");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  // Handle database connection error
  http_response_code(500);
  echo  json_encode(array("error" => "Database Connection Error: " . $e->getMessage()));
  die();
}

// Validate input data 
function validateNotebookData($data)
{
  return !empty($data->full_name) && !empty($data->phone_number) && !empty($data->email);
}


$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    // Handle GET request to fetch notebooks
  case "GET":
    $page = isset($_GET['page']) ? max(1, intval($_GET["page"])) : 1;
    $limit = isset($_GET["limit"]) ? max(1, intval($_GET["limit"])) : 10;
    $offset = ($page - 1) * $limit;

    if (isset($_GET['id'])) {
      $id = intval($_GET['id']);
      $stmt = $conn->prepare("SELECT * FROM notebook WHERE id = :id");
      $stmt->bindParam(":id", $id);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($user) {
        echo json_encode($user);
      } else {
        // Notebook not found
        http_response_code(404);
        echo json_encode(array("error" => "notebook not found"));
      }
    } else {
      // Fetch all notebooks
      $stmt = $conn->prepare("SELECT * FROM notebook LIMIT :limit OFFSET :offset");
      $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
      $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
      $stmt->execute();
      $notebooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($notebooks);
    }
    break;

  case "POST":
    // Handle POST request to create or update a user
    $data = json_decode(file_get_contents("php://input"));

    if (validateNotebookData($data)) {
      $full_name = $data->full_name;
      $company = $data->company ?? null;
      $phone_number = $data->phone_number;
      $email = $data->email;
      $birth_date = $data->birth_date ?? null;
      $photo = $data->photo ?? null;

      if (isset($_GET["id"])) {
        // Update existing user 
        $id = intval($_GET['id']);
        $stmt = $conn->prepare("UPDATE notebook SET full_name = :full_name, company = :company, phone_number = :phone_number, email = :email, birth_date = :birth_date, photo = :photo WHERE id = :id");
        $stmt->bindParam(":id", $id);
      } else {
        // Create new user
        $stmt = $conn->prepare("INSERT INTO notebook (full_name, company, phone_number, email, birth_date, photo) VALUES (:full_name, :company, :phone_number, :email, :birth_date, :photo)");
      }
      $stmt->bindParam(':full_name', $full_name);
      $stmt->bindParam(':company', $company);
      $stmt->bindParam(':phone_number', $phone_number);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':birth_date', $birth_date);
      $stmt->bindParam(':photo', $photo);

      try {
        if ($stmt->execute()) {
          // Notebook created or updated successfully
          if (isset($_GET["id"])) {

            http_response_code(200);
            echo json_encode(array("message" => "Notebook updated successfully"));
          } else {

            http_response_code(201);
            echo json_encode(array("message" => "Notebook created successfully"));
          }
        } else {
          // Database error
          http_response_code(500);
          echo json_encode(array("message" => "Unable to create/update user"));
        }
      } catch (Exception $e) {
        // Database error
        http_response_code(500);
        echo json_encode(array("error" => "Database Error: " . $e->getMessage()));
      }
    } else {
      // Invalid input data
      http_response_code(400);
      echo json_encode(array("error" => "invalid input data"));
    }
    break;

  case "DELETE":
    // Handle DELETE request to delete a user
    if (isset($_GET["id"])) {
      $id = intval($_GET["id"]);
      $stmt = $conn->prepare("DELETE FROM notebook WHERE id = :id");
      $stmt->bindParam(":id", $id);
      try {
        if ($stmt->execute()) {
          // Notebook deleted successfully
          http_response_code(200);
          echo json_encode(array("message" => "Notebook deleted successfully"));
        } else {
          //Database error
          http_response_code(500);
          echo json_encode(array("error" => "Unable to delete user"));
        }
      } catch (Exception $e) {
        // Database error
        http_response_code(500);
        echo json_encode(array("error" => "Database Error: " . $e->getMessage()));
      }
    } else {
      // Invalid request
      http_response_code(400);
      echo json_encode(array("error" => "Inavlid request"));
    }
    break;

  default:
    // Invalid request method
    http_response_code(405);
    echo json_encode(array("error" => "Method not allowed"));
}

$conn = null;
