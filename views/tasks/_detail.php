<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
</head>

<body>

    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Start_date</th>
                <th scope="col">Finished_date</th>
                <th scope="col" style="text-align: center;">Status</th>
                <th scope="col">Due_date</th>
                <th scope="col">Category</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?= $task['name'] ?>
                </td>
                <td>
                    <?= $task['description'] ?>
                </td>
                <td>
                    <?= $task['start_date'] ?>
                </td>
                <td>
                    <?= $task['finished_date'] ?>
                </td>
                <td>
                    <?= $task['status'] ?>
                </td>
                <td>
                    <?= $task['due_date'] ?>
                </td>
                <td>
                    <?= $task['category'] ?>
                </td>
            </tr>

        </tbody>
    </table>

</body>

</html>