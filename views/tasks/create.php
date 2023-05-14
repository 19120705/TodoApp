<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <script>
        function validateForm() {
            var data = [];
            let name = document.forms["createForm"]["name"].value;
            let description = document.forms["createForm"]["description"].value;
            let category = document.forms["createForm"]["category"].id;
            let due_date = document.forms["createForm"]["due_date"].value;
            if (x == "") {
                alert("Name must be filled out");
                return false;
            }
            data['name'] = name;
            data['description'] = description;
            data['category'] = category;
            data['due_date'] = due_date;
            return data;
        }
    </script>
    <form class="row g-3" name="createForm" action="index.php?controller=task&action=create"
        onsubmit="return validateForm()" method="post">
        <div class="col-md-4">
            <label for="validationServer01" class="form-label">Name</label>
            <input type="text" pattern="[a-zA-Z0-9]+" name="name" class="form-control" id="validationServer01" value="" required>
        </div>
        <div class="col-md-4">
            <label for="validationServer02" class="form-label">Description</label>
            <input type="text" pattern="[a-zA-Z0-9]+" name="description" class="form-control" id="validationServer02" value="" required>
        </div>

        <div class="col-md-3">
            <label for="validationServer04" class="form-label">Category</label>
            <select class="form-select" name="category" id="validationServer04" required>
                <?php foreach ($categoryList as $key => $category): ?>
                    <option>
                        <?= $category['name'] ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="validationServer02" class="form-label">Due date</label>
            <input type="date" name="due_date" class="form-control" id="validationServer02" value="" required>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Submit form</button>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>