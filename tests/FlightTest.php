<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Flight.php";

$server = 'mysql:host=localhost:8889;dbname=airline_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);


class FlightTest extends PHPUnit_Framework_TestCase
{

    function tearDown()
    {
        Flight::deleteAll();
    }

    function test_save()
    {
        $id = 1;
        $departure_time = "16:00:00";
        $departure_city = "Portland";
        $arrival_city = "Denver";
        $flight_status = "delayed";
        $new_flight = new Flight($id,$departure_time, $departure_city, $arrival_city, $flight_status);
        $new_flight->save();

        $id = 1;
        $departure_time = "16:00:00";
        $departure_city = "Portland";
        $arrival_city = "Denver";
        $flight_status = "delayed";
        $new_flight2 = new Flight($id,$departure_time, $departure_city, $arrival_city, $flight_status);
        $new_flight2->save();

        $result = Flight::getAll();
        var_dump("results");
        var_dump($result);
        var_dump("expected");
        var_dump([$new_flight, $new_flight2]);


        $this->assertEquals($result,[$new_flight, $new_flight2]);
    }

    // function test_find()
    // {
    //     $city_name = "Portland";
    //     $id = 1;
    //     $new_city = new City($id, $city_name);
    //     $new_city->save();
    //     // $id = $new_city->getId();
    //
    //     $result = City::find($new_city->getId());
    //
    //     $this->assertEquals($result, $new_city);
    // }
    //
    // function testGetId()
    //     {
    //         //Arrange
    //         $name = "PDX";
    //         $id = 1;
    //         $test_category = new City($id, $name);
    //         // $test_category->save();
    //         //Act
    //         $result = $test_category->getId();
    //         //Assert
    //         $this->assertEquals(1, $result);
    //     }
}
 ?>
