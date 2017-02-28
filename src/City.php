<?php
    class City
    {
            private $id;
            private $city_name;

        function __construct($id= null, $city_name)
        {
            $this->id = $id;
            $this->city_name = $city_name;
        }

        function getId()
        {
            return $this->id;
        }

        function getName()
        {
            return $this->city_name;
        }

        function setName($city_name)
        {
            $this->city_name = $city_name;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cities (city_name) VALUES ('{$this->city_name}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $cities = array();
            $returned_cities = $GLOBALS['DB']->query("SELECT * FROM cities;");
            foreach ($returned_cities as $city) {
                $city_name = $city['city_name'];
                $id = $city['id'];
                $new_city = new City($id, $city_name);
                array_push($cities, $new_city);
            }
            return $cities;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cities");
        }

        static function find($search_id)
        {
            $found_city = null;
            $cities = City::getAll();
            foreach($cities as $city)
            {
                $city_id = $city->getId();
                if ($city_id == $search_id){
                    $found_city = $city;
                }
            }
            return $found_city;
        }


        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE cities SET city_name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM cities WHERE id = '{$this->getId()}';");
        }

    }
 ?>
