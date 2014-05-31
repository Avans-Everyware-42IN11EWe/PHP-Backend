<?php

doc(
    "wijkbewoner",
    "Profiel <span class='label label-danger'>Niet</span>",
    "GET <code>/buddy?id=2</code>",
    '
    <pre>
    {
        "naam": "Henk de Vries",
        "leeftijd": 31,
        "woonplaats": "Aawijk",
        "telefoon": "06-57107007",
        "email": "peter.buddy@gmail.com",
        "video": "http://glas.mycel.nl/uploads/videos/sample_mpeg4.mp4"
    }
    </pre>
    ');
$app->get('/buddy', function () {
    global $app;
    $app->response->headers->set('Content-Type', 'application/json');

    echo '{
        "naam": "Henk de Vries",
        "leeftijd": 31,
        "woonplaats": "Aawijk",
        "telefoon": "06-57107007",
        "email": "peter.buddy@gmail.com",
        "video": "http://glas.mycel.nl/uploads/videos/sample_mpeg4.mp4"
    }';
});