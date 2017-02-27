<?php
class Flight
{
        private $id;
        private $departure_time;
        private $departure_city;
        private $arrival_city;
        private $flight_status;

    function __construct($id= null, $departure_time, $departure_city, $arrival_city, $flight_status)
    {
        $this->id = $id;
        $this->departure_time = $departure_time;
        $this->departure_city = $departure_city;
        $this->arrival_city = $arrival_city;
        $this->flight_status = $flight_status;
    }

    function getId()
    {
        return $this->id;
    }

    function getDepartureTime()
    {
        return $this->departure_time;
    }

    function setDepartureTime($departure_time)
    {
        $this->departure_time = $departure_time;
    }
    function getDepartureCity()
    {
        return $this->departure_city;
    }

    function setDepartureCity($departure_city)
    {
        $this->departure_city = $departure_city;
    }
    function getArrivalCity()
    {
        return $this->arrival_city;
    }

    function setArrivalCity($arrival_city)
    {
        $this->arrival_city = $arrival_city;
    }
    function getFlightStatus()
    {
        return $this->flight_status;
    }

    function setFlightStatus($flight_status)
    {
        $this->flight_status = $flight_status;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO flights (departure_time, departure_city, arrival_city, flight_status) VALUES ('{$this->departure_time}', '{$this->departure_city}', '{$this->arrival_city}', '{$this->flight_status}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $flights = array();
        $returned_flights = $GLOBALS['DB']->query("SELECT * FROM flights;");
        foreach ($returned_flights as $flight) {
            $id = $flight['id'];
            $departure_time = $flight['departure_time'];
            $departure_city = $flight['departure_city'];
            $arrival_city = $flight['arrival_city'];
            $flight_status = $flight['flight_status'];
            $new_flight = new Flight($id,$departure_time, $departure_city, $arrival_city, $flight_status);
            array_push($flights, $new_flight);
        }
        return $flights;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM flights");
    }

    static function find($search_id)
    {
        $found_flight = null;
        $flights = Flight::getAll();
        foreach($flights as $flight)
        {
            $flight_id = $flight->getId();
            if ($flight_id == $search_id){
                $found_flight = $flight;
            }
            return $found_flight;
        }
    }

    function update($new_time, $new_departure_city, $new_arrival_city, $new_status)
    {
        $GLOBALS['DB']->exec("UPDATE flights SET arrival_city = '{$new_arrival_city}', departure_city = '{$new_departure_city}', departure_time = '{$new_time}', flight_status ='{$new_status}' WHERE id = {$this->getId()};");
        $this->setArrivalCity($new_arrival_city);
        $this->setDepartureCity($new_departure_city);
        $this->setDepartureTime($new_time);
        $this->setFlightStatus($new_status);
    }


}
 ?>
