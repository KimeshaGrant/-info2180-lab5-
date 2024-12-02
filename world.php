<?php

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    /
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    if (isset($_GET['country'])) {
        $country = $_GET['country'];

        if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities') {
           
            $stmt = $conn->prepare("
                SELECT cities.name AS cityname, cities.district, cities.population 
                FROM cities 
                JOIN countries ON cities.countrycode = countries.code 
                WHERE countries.name LIKE :country
            ");
            
            /
            $likeCountry = "%" . $country . "%";
            $stmt->bindParam(':country', $likeCountry);
            $stmt->execute();

           
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            
            if ($results) {
                
                echo "<h1>Cities in '" . htmlspecialchars($country) . "':</h1>";
                echo "<table border='1' cellpadding='5' cellspacing='0'>";
                echo "<tr>
                        <th>City Name</th>
                        <th>District</th>
                        <th>Population</th>
                      </tr>";

                
                foreach ($results as $result) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($result['cityname']) . "</td>";
                    echo "<td>" . htmlspecialchars($result['district']) . "</td>";
                    echo "<td>" . htmlspecialchars($result['population']) . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No cities found for the country: " . htmlspecialchars($country) . "</p>";
            }
        } else {
            
            $stmt = $conn->prepare("SELECT name, continent, independenceyear, headofstate FROM countries WHERE name LIKE :country");
            $likeCountry = "%" . $country . "%";
            $stmt->bindParam(':country', $likeCountry);
            $stmt->execute();

            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            
            if ($results) {
                
                echo "<h1>Countries matching '" . htmlspecialchars($country) . "':</h1>";
                echo "<table border='1' cellpadding='5' cellspacing='0'>";
                echo "<tr>
                        <th>Country Name</th>
                        <th>Continent</th>
                        <th>Independence Year</th>
                        <th>Head of State</th>
                      </tr>";

                
                foreach ($results as $result) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($result['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($result['continent']) . "</td>";
                    echo "<td>" . htmlspecialchars($result['independenceyear']) . "</td>";
                    echo "<td>" . htmlspecialchars($result['headofstate']) . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No information found for the country: " . htmlspecialchars($country) . "</p>";
            }
        }
    } else {
        echo "<p>provide a country name in the query parameter.</p>";
    }
} catch (PDOException $e) {
    /
    echo 'Connection failed: ' . $e->getMessage();
}

?>