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

        $this->assertEquals($result,[$new_flight, $new_flight2]);
    }

    function test_find()
    {
        $id = 1;
        $departure_time = "16:00:00";
        $departure_city = "Portland";
        $arrival_city = "Denver";
        $flight_status = "delayed";
        $new_flight2 = new Flight($id,$departure_time, $departure_city, $arrival_city, $flight_status);
        $new_flight2->save();

        $result = Flight::find($new_flight2->getId());

        $this->assertEquals($result, $new_flight2);
    }

    function testGetId()
    {
        //Arrange
        $id = 1;
        $departure_time = "16:00:00";
        $departure_city = "Portland";
        $arrival_city = "Denver";
        $flight_status = "delayed";
        $new_flight2 = new Flight($id,$departure_time, $departure_city, $arrival_city, $flight_status);
        //Act
        $result = $new_flight2->getId();
        //Assert
        $this->assertEquals(1, $result);
    }
    function testUpdateStatus()
    {
        //Arrange
        $id = null;
        $departure_time = "16:00:00";
        $departure_city = "Boulder";
        $arrival_city = "Maui";
        $flight_status = "delayed";
        $new_status = "on time";
        $new_flight2 = new Flight($id,$departure_time, $departure_city, $arrival_city, $flight_status);
        $new_flight2->save();

        $new_flight2->updateStatus($new_status);

        $this->assertEquals($new_flight2->getFlightStatus(), $new_status);
    }

    function testUpdateArrivalCity()
    {
        //Arrange
        $id = null;
        $departure_time = "16:00:00";
        $departure_city = "Boulder";
        $arrival_city = "Maui";
        $flight_status = "delayed";
        $new_city = "Portland";
        $new_flight2 = new Flight($id,$departure_time, $departure_city, $arrival_city, $flight_status);
        $new_flight2->save();

        $new_flight2->updateStatus($new_city);

        $this->assertEquals($new_flight2->getFlightStatus(), $new_city);
    }

    function testUpdateDepartureCity()
    {
        //Arrange
        $id = null;
        $departure_time = "16:00:00";
        $departure_city = "Boulder";
        $arrival_city = "Maui";
        $flight_status = "delayed";
        $new_city = "Albuquerque";
        $new_flight2 = new Flight($id,$departure_time, $departure_city, $arrival_city, $flight_status);
        $new_flight2->save();

        $new_flight2->updateStatus($new_city);

        $this->assertEquals($new_flight2->getFlightStatus(), $new_city);
    }

    function testUpdateDepartureTime()
    {
        //Arrange
        $id = null;
        $departure_time = "16:00:00";
        $departure_city = "Boulder";
        $arrival_city = "Maui";
        $flight_status = "delayed";
        $new_time = "18:00:00";
        $new_flight2 = new Flight($id,$departure_time, $departure_city, $arrival_city, $flight_status);
        $new_flight2->save();

        $new_flight2->updateStatus($new_time);

        $this->assertEquals($new_flight2->getFlightStatus(), $new_time);
    }

}
 ?>
