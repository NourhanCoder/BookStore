<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\CartController;

$cartObject = new CartController();

$action = isset($_GET['action']) ? $_GET['action'] : null;

if ($_SERVER['REQUEST_METHOD'] == "POST" && $action == "add") {
    $cartObject->addItem($_POST['id'], $_POST['name'], $_POST['price'], $_POST['image']);
    header("Location: index.php?page=cart");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $action == "update") {
    $cartObject->updateQty($_POST['update_id'], $_POST['qty']);
    header("Location: index.php?page=cart");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $action == "remove") {
    $cartObject->removeItem($_POST['remove_id']);
    header("Location: index.php?page=cart");
    exit;
}


$items = $cartObject->getItems();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Your Cart</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><img src=public/assets/images/<?= $item['image'] ?> width="50"></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['price'] ?></td>
                            <td>
                                <form action="index.php?page=cart&action=update" method="POST" class="d-flex align-items-center">
                                    <input type="hidden" name="update_id" value="<?= $item['id'] ?>">
                                    <input type="number" name="qty" value="<?= $item['qty'] ?>" class="form-control me-2" style="width: 70px;">
                                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                                </form>
                            </td>
                            <td><?= $item['qty'] * $item['price'] ?></td>
                            <td>
                                <form action="index.php?page=cart&action=remove" method="POST">
                                    <input type="hidden" name="remove_id" value="<?= $item['id'] ?>">
                                    <button class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Your cart is empty</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
   
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php include "includes/footer.php";