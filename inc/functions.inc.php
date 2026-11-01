<?php

function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// function render($view, $params) {
//     extract($params);

//     ob_start();
//     require __DIR__ . '/../views/pages/' . $view . '.php';
//     $contents = ob_get_clean();

//     require __DIR__ . '/../views/layouts/main.view.php';
// }