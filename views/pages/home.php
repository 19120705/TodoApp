<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=], initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            background-color: #8BC6EC;
            background-image: linear-gradient(135deg, #FAD7A1 10%, #E96D71 100%);
        }

        h1 {
            font-size: 2.6rem;
            color: rgb(105, 105, 105);
            margin-bottom: 50px;
            margin-top: 50px;
        }

        .wrapper {
            width: 500px;
            height: 500px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

            background-color: rgba(255, 255, 255, 0.5);
            display: flex_inline;
            justify-content: center;
            text-align: center;
            border-radius: 4px;

        }

        .button-menu {
            width: cover;
            height: cover;
            margin: none;
            color: rgb(105, 105, 105);
            font-size: 2rem;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.5);
            line-height: 5rem;

            +.button_menu {
                margin-top: 16px;
            }

            &:hover {
                background: linear-gradient(0deg, rgba(0, 0, 0, 0.06), rgba(0, 0, 0, 0.06)), #8BC6EC;
            }
        }

        a {
            text-decoration: none;
            /* padding: 20px 160px; */
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h1>Menu</h1>
        <div class="button-menu" onClick="parent.location='index.php?controller=task&action=create'"> 
            New Task
        </div>
        <div class="button-menu" onClick="parent.location='index.php?controller=task&action=show'">
            List Task
        </div>
        <div class="button-menu" onClick="parent.location='index.php?controller=task&action=show'">
            Update Task
        </div>
    </div>
</body>

</html>