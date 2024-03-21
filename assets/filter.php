<?php
$current_url = $_SERVER['REQUEST_URI'];

$segments = explode('/', $current_url);

$machine = false;

foreach ($segments as $segment) {
    if ($segment === 'machines.php') {
        $machine = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .filter {
            position: relative;
            width: fit-content;
            transition: all 0.2s linear;
        }

        .filter:hover  {
            transform: scale(1.15);
        }

        .mainbox {
            position: relative;
            width: 230px;
            height: 50px;
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            justify-content: center;
            border-radius: 160px;
            background-color: rgb(0, 0, 0);
            transition: all 0.3s ease;
        }

        .checkbox:focus {
            border: none;
            outline: none;
        }

        .checkbox:checked {
            right: 10px;
        }

        .checkbox:checked ~ .mainbox {
            width: 50px;
        }

        .checkbox:checked ~ .mainbox .search_input {
            width: 0;
            height: 0px;
        }

        .checkbox:checked ~ .mainbox .iconFilter {
            padding-right: 8px;
        }

        .checkbox {
            width: 30px;
            height: 30px;
            position: absolute;
            right: 17px;
            top: 10px;
            z-index: 9;
            cursor: pointer;
            appearance: none;
        }

        .search_input {
            height: 100%;
            width: 170px;
            background-color: transparent;
            border: none;
            outline: none;
            padding-bottom: 4px;
            padding-left: 10px;
            font-size: 1em;
            color: white;
            transition: all 0.3s ease;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .search_input::placeholder {
            color: rgba(255, 255, 255, 0.776);
        }

        .iconFilter {
            padding-top: 5px;
            width: fit-content;
            transition: all 0.3s ease;
        }

        .search_icon {
            fill: white;
            font-size: 1.3em;
        }

        @media only screen and (max-width: 1050px) {
            .filter {
                transform: scale(0.8);
            }

            .filter:hover  {
                transform: scale(0.9);
            }
        }

        @media only screen and (max-width: 500px) {
            .filter {
                transform: scale(0.6);
            }

            .filter:hover  {
                transform: scale(0.7);
            }
        }

    </style>
    <title>Filter</title>
</head>
<body>
    <div class="filter">
        <input checked="" class="checkbox" type="checkbox"> 
        <div class="mainbox">
            <div class="iconFilter">
                <svg viewBox="0 0 512 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="search_icon"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path></svg>
            </div>
        <input class="search_input" placeholder="Search <?php echo $machine ? 'Machines' : 'Employees' ?>" type="text">
        </div>
    </div>
</body>
</html>

