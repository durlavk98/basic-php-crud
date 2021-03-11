<?php

require_once "../functions.php";
$pdo = require_once "../database.php";

$keyword = $_GET['search'] ?? '';
if($keyword) {
  $statement = $pdo->prepare('SELECT * FROM products WHERE title LIKE :keyword ORDER BY create_date DESC');
  $statement->bindValue(':keyword',"%$keyword%");
} else {
  $statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
}

$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<?php require_once "../views/header.php"; ?>
<h1>Products CRUD</h1>

<p>
  <a href="create.php" class="btn btn-success">Create Product</a>
</p>

<form action="">
  <div class="input-group mb-3">
    <input type="text" name="search" class="form-control" placeholder="Search for products" value="<?php echo $keyword ?>">
    <div class="input-group-append">
      <button class="btn btn-outline-secondary" type="submit">Search</button>
    </div>
  </div>
</form>

<table class="table">
  <thead>
    <tr>
    <th scope="col">#</th>
    <th scope="col">Image</th>
    <th scope="col">Title</th>
    <th scope="col">Price</th>
    <th scope="col">Created At</th>
    <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $i=>$product): ?>
      <tr>
        <th scope="row"><?php echo $i+1 ?></th>
        <td>
          <img src="<?php echo $product['image'] ?>" width="50">
        </td>
        <td><?php echo $product['title'] ?></td>
        <td><?php echo $product['price'] ?></td>
        <td><?php echo $product['create_date'] ?></td>
        <td>
        <a href="update.php?id=<?php echo $product['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
        <form style="display: inline-block;" action="delete.php" method="post">
          <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
          <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
        </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
    
  </body>
</html>