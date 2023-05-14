<?php

class TaskController extends BaseController
{
    private $taskModel;
    private $categoryModel;
    public function __construct()
    {
        $this->loadModel('TaskModel');
        $this->taskModel = new TaskModel;
        $this->loadModel('CategoryModel');
        $this->categoryModel = new CategoryModel;
    }

    public function index()
    {
        $tasks = $this->taskModel->getAllTask();
        $numbers = $this->taskModel->getNumberOfTask();
        return $this->view('tasks.index', [
            'tasks' => $tasks,
            'numbers' => $numbers
        ]);
    }
    public function show()
    {
        if (isset($_GET['page_no']) && $_GET['page_no'] == !"") {
            $page_no = $_GET['page_no'];
        } else {
            $page_no = 1;
        }
        $total_records_per_page = 6;

        $offset = ($page_no - 1) * $total_records_per_page;


        $total_records = $this->taskModel->getNumberOfTask();

        $total_no_of_pages = ceil($total_records / $total_records_per_page);

        $taskMenu = $this->taskModel->getAllTask(['*'], [], [$offset, $total_records_per_page]);

        $categoryList = $this->categoryModel->getAllCategory();

        foreach ($taskMenu as &$item) {
            $category = $this->categoryModel->getOneCategory($item['category_id']);
            unset($item["category_id"]);
            $item += ['category' => $category['name']];
        }
        $this->view(
            'tasks.show',
            [
                'totalNoPages' => $total_no_of_pages,
                'page_no' => $page_no,
                'taskMenu' => $taskMenu,
                'categoryList' => $categoryList,
            ]
        );
    }
    public function showDetail()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $task = $this->taskModel->getOneTask($id);

            $category = $this->categoryModel->getOneCategory($task['category_id']);
            $task += ['category' => $category['name']];
            $this->view(
                'tasks._detail',
                [
                    'task' => $task,
                ]
            );
        }
    }
    public function create()
    {
        $categoryList = $this->categoryModel->getAllCategory();
        if (isset($_POST['name'])) {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'category_id' => $this->categoryModel->getId($_POST['category'])['id'],
                'due_date' => $_POST['due_date'],
            ];
            $this->taskModel->createOneTask($data);
            echo "<pre></pre>";
            print_r("Create success");
        }

        $this->view('tasks.create', [
            'categoryList' => $categoryList,
        ]);

    }
    public function update()
    {
        if (isset($_POST['update_id'])) {
            $id = $_POST['update_id'];
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'start_date' => $_POST['start_date'],
                'finished_date' => $_POST['finished_date'],
                'status' => $_POST['status'],
                'category_id' => $this->categoryModel->getId($_POST['category'])['id'],
                'due_date' => $_POST['due_date'],
            ];
            $this->taskModel->updateOneTask($id, $data);
            header("Location:" . $_SERVER['HTTP_REFERER']);
            echo "<script> alert('Data Updated'); </script>";
        }

    }

    public function destroy()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $result = $this->taskModel->deleteTask($id);
            if ($result) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }
    public function search()
    {
        if (isset($_POST['search'])) {
            //Search box value assigning to $Name variable.
            $Name = $_POST['search'];
            $result = $this->taskModel->searchTask($Name);
            echo '<ul class="search-list">';
            //Fetching result from database.
            foreach ($result as $item) {
                ?>
                <li class="search-item" onclick='fill("<?php echo $item['name']; ?>")'>
                    <a class="search-link" href="index.php?controller=task&action=showDetail&id=<?= $item['id'] ?>">
                        <?php echo $item['name']; ?>
                    </a>
                </li>
                <!-- Below php code is just for closing parenthesis. Don't be confused. -->
                <?php
            }
        }
    }
    public function filter()
    {
        if (isset($_POST['request'])) {
            $request = $_POST['request'];
            $result = $this->taskModel->filter($request);
            ?>
            <table class="table table-hover">
                <?php
                if ($result) {
                    ?>
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

                    <?php
                } else {
                    echo "Sorry! No record found";
                }

                ?>
                <tbody>
                    <?php foreach ($result as $key => $task): ?>
                        <?php $category = $this->categoryModel->getOneCategory($task['category_id']);
                        unset($task["category_id"]);
                        $task += ['category' => $category['name']]; ?>
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
                                <a href="index.php?controller=task&action=showDetail&id=<?= $task['id'] ?>" class="btn btn-success">
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
            <?php
        }

    }

}