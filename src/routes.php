<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

// Rute GET /books/ untuk menampilkan seluruh data pada database
$app->get("/shahih_bukhari/", function (Request $request, Response $response){
    $sql = "SELECT * FROM shahih_bukhari";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

// Rute GET /books/1 untuk menampilkan data sesuai nomor hadits
$app->get("/shahih_bukhari/{no_hadits}", function (Request $request, Response $response, $args){
    $no_hadits = $args["no_hadits"];
    $sql = "SELECT * FROM shahih_bukhari WHERE no_hadits=:no_hadits";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":no_hadits" => $no_hadits]);
    $result = $stmt->fetch();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

// Rute GET /books/search untuk melakukan pencarian hadits
$app->get("/shahih_bukhari/search/", function (Request $request, Response $response, $args){
    $keyword = $request->getQueryParam("keyword");
    $sql = "SELECT * FROM shahih_bukhari WHERE bab LIKE '%$keyword%' OR matan_inggris LIKE '%$keyword%'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

