<?php 


    class Plesk_API {

        public function get_website()
        {
            // Plesk API Configuration
            $url = "https://m2.server.inoya.cloud:8443/api/v2/server";

            $username = "root";
            $password = "WUeipb6w?Qt14qur";

     
            // Initialize cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
            ]);

            // Execute Request
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Check Response Status
            if ($httpCode !== 200) {
                die("Error: Unable to fetch data from Plesk API. HTTP Code: $httpCode");
            }

            // Convert XML to JSON
            $xml = simplexml_load_string($response);
            $json = json_encode($xml);

            // Print JSON Response
            header('Content-Type: application/json');
            echo $json;
        }

    }