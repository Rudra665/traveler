<?php
$host = "localhost"; // server host
$port = 5500; // server port

// Create a TCP/IP socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// Bind the socket to the host and port
socket_bind($socket, $host, $port);

// Listen for incoming connections
socket_listen($socket);

// Accept incoming connections
$clientSocket = socket_accept($socket);

// Read data from the client
$request = socket_read($clientSocket, 1024);

// Parse the request
$data = json_decode($request, true);

// Extract email details from the request
$to = "info@alephcampeur.com";
// Extract additional data from the JSON request
$mobile = $data['mobile'];
$name = $data['name'];
$date = $data['date'];
$type = $data['type'];

// Include additional data in the email message
$message .= "Mobile No.: $mobile\n";
$message .= "Name: $name\n";
$message .= "Date: $date\n";
$message .= "Type of Data - Trip Booking: $type\n";

// Send the email
$headers = "From: $data['email']"; // Set the sender's email address here
$mailSent = mail($to, $subject, $message, $headers);

// Prepare the response
if ($mailSent) {
    $response = "Email sent successfully!";
} else {
    $response = "Failed to send email.";
}

// Send the response to the client
socket_write($clientSocket, $response, strlen($response));

// Close the client socket
socket_close($clientSocket);

// Close the server socket
socket_close($socket);
?>