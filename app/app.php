<?php
require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../src/City.php";
require_once __DIR__."/../src/Flight.php";

$app = new Silex\Application();

$server = 'mysql:host=localhost:8889;dbname=airline';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);
 $app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
));

use Symfony\Component\HttpFoundation\Request;
Request::enableHttpMethodParameterOverride();

$app->get("/", function() use ($app) {
    return $app['twig']->render('flight_search.html.twig', array( 'flights'=>Flight::getAll()));
});
$app->post("/", function() use ($app) {
    $departure_time = $_POST["departure_time"];
    $departure_city = $_POST["departure_city"];
    $arrival_city = $_POST["arrival_city"];
    $flight_status = $_POST["flight_status"];
    $new_flight = new Flight($id = null, $departure_time, $departure_city, $arrival_city, $flight_status);
    $new_flight->save();
    return $app['twig']->render('flight_search.html.twig', array('flights'=>Flight::getAll()));
});
$app->get("/delete", function() use ($app) {
    Flight::deleteAll();
    return $app['twig']->render('flight_search.html.twig', array('flights'=>Flight::getAll()));
});
$app->get("/update/{id}", function($id) use ($app) {
    $flight = Flight::find($id);
    return $app['twig']->render('update_flight.html.twig', array('flight'=>$flight));
});

$app->patch("/update/{id}", function($id) use ($app) {
    $flight = Flight::find($id);
    $flight->update($_POST['departure_time'], $_POST['departure_city'], $_POST['arrival_city'], $_POST['flight_status']);
    return $app->redirect("/");
});

$app->delete("/delete/{id}", function($id) use ($app) {
    $flight = Flight::find($id);
    $flight->delete();
    return $app->redirect("/");
});

$app->post("/flight_list", function() use ($app) {
    $flights = Flight::findByDepartureCity($_POST["departure_city_search"]);
    return $app['twig']->render('flight_list.html.twig', array('flights'=>$flights));
});



return $app;

 ?>
