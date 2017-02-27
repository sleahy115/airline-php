<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/City.php";

$server = 'mysql:host=localhost:8889;dbname=airline_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);


class CityTest extends PHPUnit_Framework_TestCase
{

    function tearDown()
    {
        City::deleteAll();
    }

    function test_save()
    {
        $city_name = "Portland";
        $id = 1;
        $new_city = new City($id,$city_name);
        $new_city->save();

        $city_name2 = "Denver";
        $id2 = 2;
        $new_city2 = new City($id2,$city_name2);
        $new_city2->save();

        $result = City::getAll();


        $this->assertEquals($result,[$new_city, $new_city2]);
    }

    function test_find()
    {
        $city_name = "Portland";
        $id = 1;
        $new_city = new City($id, $city_name);
        $new_city->save();
        // $id = $new_city->getId();

        $result = City::find($new_city->getId());

        $this->assertEquals($result, $new_city);
    }

    function testGetId()
        {
            //Arrange
            $name = "PDX";
            $id = 1;
            $test_category = new City($id, $name);
            // $test_category->save();
            //Act
            $result = $test_category->getId();
            //Assert
            $this->assertEquals(1, $result);
        }
}
 ?>
