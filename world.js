document.addEventListener("DOMContentLoaded", function() {
    function fetchData(endpoint) {
        const country = document.getElementById("country").value.trim();

        if (country === "") {
            document.getElementById("result").innerHTML = "<p>Please enter a country name.</p>"; // Message incase the user eenters a a blank text.
            return;
        }

    
        const xhr = new XMLHttpRequest();
        xhr.open("GET", `${endpoint}${encodeURIComponent(country)}`, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                const response = xhr.responseText;
                document.getElementById("result").innerHTML = response;
            } else {
                document.getElementById("result").innerHTML = "<p>Error fetching data.</p>";
            }
        };

        xhr.onerror = function() {
            document.getElementById("result").innerHTML = "<p>Network error. Please try again later.</p>";
        };
        xhr.send();
    }

    document.getElementById("lookup").addEventListener("click", function() {
        fetchData(`world.php?country=`);
    });

    
    document.getElementById("lookupCities").addEventListener("click", function() {
        fetchData(`world.php?lookup=cities&country=`);
    });
});   