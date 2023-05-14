<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        body {
            background-color: #8BC6EC;
            background-image: linear-gradient(135deg, #FAD7A1 10%, #E96D71 100%);
        }

        .header {
            height: 100%;
            width: var(--default-layout-width);
            padding: 0 var(--default-layout-horizontal-spacer);
            display: flex;
            align-items: center;
            justify-content: space-between;

            #filters {
                margin-left: 80px
            }
        }

        #search {
            background-image: url('views/tasks/search.png');
            background-size: 1.1rem;
            background-position: 12px 15px;
            background-repeat: no-repeat;
            width: 600px;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            border-radius: 25px;
            margin-bottom: 12px;
            margin-top: 12px;
            margin-right: 200px;

        }

        .search-list {
            position: absolute;
            list-style-type: none;
            z-index: 2;
            padding: 0;
            margin: 0;
            border-radius: 15px;
        }

        .search-list .search-item .search-link {

            width: 600px;
            border: 1px solid #ddd;
            margin-right: 200px;
            margin-top: -1px;
            background-color: #f6f6f6;
            padding: 12px;
            text-decoration: none;
            font-size: 18px;
            color: black;
            display: block;

            &:hover:not(.header) {
                background-color: #eee;
            }
        }
    </style>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script>
        function fill(Value) {
            $('#search').val(Value);
            //Hiding "display" div
            $('#display').hide();
        }
        $(document).ready(function () {
            //Search
            $("#search").keyup(function () {
                //Assigning search box value to javascript variable named as "name".
                var name = $('#search').val();
                //Validating, if "name" is empty.
                if (name == "") {
                    $("#display").html("");
                }
                //If name is not empty.
                else {
                    //AJAX is called.
                    $.ajax({
                        //AJAX type is "Post".
                        type: "POST",
                        url: "index.php?controller=task&action=search",
                        data: {
                            search: name
                        },
                        success: function (html) {
                            $("#display").html(html).show();
                        }
                    });
                }
            });

            // Check all for DELETE
            $("#checkAll").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $('#delete_multiple').on("click", function () {
                var id = [];

                $(':checkbox:checked').not("#checkAll").each(function (key) {
                    id[key] = $(this).val();
                });

                if (id.length === 0) {
                    alert("Please select at least one checkbox.");
                }
                else {
                    if (confirm("Do you really want to delete these records ?")) {
                        $.ajax({
                            //AJAX type is "Post".
                            type: "POST",
                            url: "index.php?controller=task&action=destroy",
                            data: {
                                id: id
                            },
                            success: function (data) {
                                if (data == 1) {
                                    $("#success-message").html("Data deleted successfully.").slideDown();
                                    $("#error-message").slideUp();
                                    setTimeout(function () { $("#success-message").hide(); }, 5000);
                                    $(':checkbox:checked').not("#checkAll").each(function () {
                                        $(this).parent().parent().remove();
                                    });
                                }
                                else {
                                    $("#error-message").html("Can't delete data.").slideDown();
                                    $("#success-message").slideUp();
                                    setTimeout(function () { $("#error-message").hide(); }, 5000);
                                }
                            }
                        });
                    }
                }

            });

            //UPDATE btn
            $(".update-btn").on("click", function () {

                $("#updateModal").modal("show");

                $tr = $(this).closest("tr");
                //var id = $tr.children("td").children("#check").val();
                var stt = $tr.children("th").text().trim();
                var data;
                <?php foreach ($taskMenu as $key => $task): ?>
                    if (stt == <?= $key + 1 ?>) {
                        data = <?php echo json_encode($task); ?>;
                    }
                <?php endforeach ?>
                $("#update_id").val(data['id']);
                $("#name").val($tr.children("#t_name").text().trim());
                $("#description").val(data['description']);
                $("#category").val(data['category']);
                $("#start_date").val(data['start_date']);
                $("#finished_date").val(data['finished_date']);
                $("#status").val(data['status']);
                $("#due_date").val(data['due_date']);
            });

            //filter task
            $("#fetchVal").on('change', function () {
                var value = $(this).val();
                console.log(value);
                $.ajax({
                    url: "index.php?controller=task&action=filter",
                    type: "POST",
                    data: 'request=' + value,
                    beforeSend: function () {
                        $(".table-container").html("<span>Working...</span>");
                    },
                    success: function (data) {
                        $(".table-container").html(data);
                    }
                })

            });

        });
    </script>

    <div id="success-message" style="background-color: #5AF811;"></div>
    <div id="error-message" style="background-color: #F97156;"></div>

    <div class="header">

        <div id="filters">
            <select name="fetchVal" id="fetchVal">
                <option value="" disabled="" selected="">Select Filter</option>
                <option>Due date</option>
                <option>Done</option>
                <option>Doing</option>
            </select>
        </div>

        <div>
            <input type="text" id="search" placeholder="Search for names or description" />
            <div id="display"></div>
        </div>


        <!-- Suggestions will be displayed in below div. -->

    </div>
    <!-- Table -->
    <div class="table-container">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th class="col text-align-center" style="text-align: center;">
                        <input class="form-check-input" type="checkbox" value="" id="checkAll">
                    </th>
                    <th scope="col">STT</th>
                    <th scope="col">Name</th>
                    <th scope="col" style="text-align: center;">Status</th>
                    <th scope="col">Category</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($taskMenu as $key => $task): ?>
                    <tr class="table-success">
                        <td style="text-align: center;">
                            <input class="form-check-input" type="checkbox" value="<?= $task['id'] ?>" id="check">
                        </td>
                        <th scope="row">
                            <?= $key + 1 ?>
                        </th>
                        <td id="t_name">
                            <?= $task['name'] ?>
                        </td>
                        <td>
                            <select class="form-select" required>
                                <option selected disabled value="">
                                    <?= $task['status'] ?>
                                </option>
                                <option>Done</option>
                                <option>Doing</option>
                            </select>
                        </td>
                        <td>
                            <?= $task['category'] ?>
                        </td>
                        <td>
                            <a href="index.php?controller=task&action=showDetail&id=<?= $task['id'] ?>"
                                class="btn btn-success">
                                Read more
                            </a>
                            <button type="button" class="btn btn-primary update-btn">
                                Update
                            </button>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
            <thead>
                <tr>
                    <th style="text-align: center;">
                        <button type="submit" id="delete_multiple" class="btn btn-danger">Delete All</button>
                    </th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- pagination -->
    <div style="margin-top: 20px;">
        <div class="position-absolute top-90 start-50 translate-middle">
            <nav aria-label="Page navigation example">
                <ul class="pagination">

                    <li class="page-item">
                        <a class="page-link <?= ($page_no <= 1) ? ' disabled' : ''; ?>" <?= ($page_no
                                    > 1) ? ' href ="index.php?controller=task&action=show&page_no=' . $page_no - 1 . '"' : ''; ?>
                            aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($counter = 1; $counter <= $totalNoPages; $counter++) { ?>
                        <?php if ($page_no != $counter) { ?>
                            <li class="page-item"><a class="page-link"
                                    href="index.php?controller=task&action=show&page_no=<?= $counter; ?>"><?= $counter; ?></a>
                            </li>
                        <?php } else { ?>
                            <li class="page-item"><a class="page-link active">
                                    <?= $counter; ?>
                                </a></li>
                        <?php } ?>
                    <?php } ?>
                    <li class="page-item">
                        <a class="page-link<?= ($page_no >= $totalNoPages) ? ' disabled' : ''; ?>" <?= ($page_no < $totalNoPages) ? ' href ="index.php?controller=task&action=show&page_no=' . $page_no + 1 . '"' : ''; ?> aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="index.php?controller=task&action=update" method="POST">
                        <input type="hidden" name="update_id" id="update_id">
                        <div class="form-group">
                            <label for="validationServer01" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" id="validationServer01"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="validationServer02" class="form-label">Description</label>
                            <input type="text" name="description" id="description" class="form-control"
                                id="validationServer02" required>
                        </div>
                        <div class="form-group">
                            <label for="validationServer04" class="form-label">Category</label>
                            <select class="form-select" name="category" id="category" required>
                                <?php foreach ($categoryList as $key => $category): ?>
                                    <option>
                                        <?= $category['name'] ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="validationServer02" class="form-label">Start date</label>
                            <input type="date" name="start_date" class="form-control" id="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="validationServer02" class="form-label">Finished date</label>
                            <input type="date" name="finished_date" class="form-control" id="finished_date" required>
                        </div>
                        <div class="form-group">
                            <label for="validationServer04" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status" required>
                                <option selected disabled value="">Choose...</option>
                                <option>Done</option>
                                <option>Doing</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="validationServer02" class="form-label">Due date</label>
                            <input type="date" name="due_date" class="form-control" id="due_date" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="update_data" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end -->

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script> -->
</body>

</html>