<?php
$data = [
    'Game of Thrones' => ['Jaime Lannister','Catelyn Stark','Cersei Lannister']
    'Black Mirror' => ['Nanette Cole','Selma Telse','Karin Parke']
];
echo '<h1>Famous TV Series and Actors';
foreach ($data as $series => $actors){
    echo "<h2>$series</h2>";
    foreach ($actors as $actor){
        echo "<div>$actor</div>";
    }
}