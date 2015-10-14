<?php
namespace view;
class HTMLView
{
    public function Render($body){
        echo '
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Workshop 2</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        ' . $body . '
    </div>
</body>
</html>
        ';
    }
}
