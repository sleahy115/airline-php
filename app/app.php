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
    return $app['twig']->render('flight_search.html.twig', array( 'flights'=>Flight::getAll(), 'cities'=>City::getAll()));
});

$app->post("/", function() use ($app) {
    $departure_time = $_POST["departure_time"];
    $departure_city = $_POST["departure_city"];
    $arrival_city = $_POST["arrival_city"];
    $flight_status = $_POST["flight_status"];
    $new_flight = new Flight($id = null, $departure_time, $departure_city, $arrival_city, $flight_status);
    $new_flight->save();
    return $app['twig']->render('flight_search.html.twig', array('flights'=>Flight::getAll(), 'cities'=>City::getAll()));
});

$app->get("/city_list", function() use ($app) {
    return $app['twig']->render('city_list.html.twig', array( 'cities'=>City::getAll(),));
});
$app->post("/city_list", function() use ($app) {
    $city_name = $_POST['city_name'];
    $new_city = new City($id= null, $city_name);
    $new_city->save();
    return $app['twig']->render('city_list.html.twig', array( 'cities'=>City::getAll()));
});

$app->get("/delete", function() use ($app) {
    Flight::deleteAll();
    City::deleteAll();
    return $app['twig']->render('flight_search.html.twig', array( 'flights'=>Flight::getAll(), 'cities'=>City::getAll()));
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

$app->get("/update/city/{id}", function($id) use ($app) {
    $city = City::find($id);
    var_dump("app");
    var_dump($id);
    return $app['twig']->render('update_city.html.twig', array('city'=>$city));
});

$app->patch("/update/city/{id}", function($id) use ($app) {
    $city = City::find($id);
    $city->update($_POST['city_name']);

    return $app['twig']->render('city_list.html.twig', array('city'=>$city,  'cities'=>City::getAll()));
});

$app->delete("/delete/city/{id}", function($id) use ($app) {
    $city = City::find($id);
    $city->delete();
    return $app->redirect("/city_list");
});

return $app;

 ?>
