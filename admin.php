<?php
define('UPLOAD_DIR', 'uploads/');
define('DATA_FILE', 'products.json');

if (!file_exists(DATA_FILE)) {
    file_put_contents(DATA_FILE, json_encode([]));
}

$data = json_decode(file_get_contents(DATA_FILE), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productname'];
    $modelId = $_POST['modelid'];
    $category = $_POST['category'];
    $productDetails = $_POST['product_details'];
    $imagePath = '';

    // Handle image upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
        $imageName = time() . '_' . basename($_FILES['product_image']['name']);
        $imagePath = UPLOAD_DIR . $imageName;

        if (!is_dir(UPLOAD_DIR)) {
            mkdir(UPLOAD_DIR, 0777, true);
        }

        move_uploaded_file($_FILES['product_image']['tmp_name'], $imagePath);
    }

    // Add or update product
    $data[$productName] = [
        'model_id' => $modelId,
        'category' => $category,
        'details' => $productDetails,
        'image' => $imagePath
    ];

    file_put_contents(DATA_FILE, json_encode($data));
    header('Location: admin.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $productName = $_GET['delete'];
    if (isset($data[$productName])) {
        // Delete associated image
        if (file_exists($data[$productName]['image'])) {
            unlink($data[$productName]['image']);
        }

        unset($data[$productName]);
        file_put_contents(DATA_FILE, json_encode($data));
    }
    header('Location: admin.html');
    exit;
}
?>
