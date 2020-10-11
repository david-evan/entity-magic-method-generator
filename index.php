<?php

if (!empty($_POST)) {
    $attributes = array_map(function ($v){ return trim($v);}, explode(PHP_EOL, $_POST['attributes']));

    $result = '';
    // Génération des getters
    foreach ($attributes as $attribute) {
        if (empty($attribute))
            break;
        $mask = explode(' ', $attribute);
        $property = [
            'visibility' => $mask[0],
            'type' => str_replace('?', 'null|', $mask[1]),
            'name' => trim($mask[2], '$;'),
        ];
        $result .= ' * @method ' . $property['type'] . ' get' . ucfirst($property['name']) . '();' . PHP_EOL;
    }

    // Génération des setters
    if (!empty($result)) {
        $result .= ' *' . PHP_EOL;
        foreach ($attributes as $attribute) {
            if (empty($attribute))
                break;
            $mask = explode(' ', $attribute);
            $property = [
                'visibility' => $mask[0],
                'type' => $mask[1],
                'name' => trim($mask[2], '$;'),
            ];
            $result .= ' * @method void set' . ucfirst($property['name']) . '(' . $property['type'] . ' $value);' . PHP_EOL;
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                         <meta http-equiv="X-UA-Compatible" content="ie=edge">
             <title>Magic Method Generator</title>
</head>
<body>
<h2>PHP Magic Method Generator</h2>
<form method="post">
    <textarea name="attributes" rows="25" cols="100" <?= isset($result) ? 'disabled' : '' ?>><?= isset($result) ? $result : '' ?></textarea>
    <br>
    <button type="submit">Générer</button>
    <a href="">Rafraichir</a>
</form>

