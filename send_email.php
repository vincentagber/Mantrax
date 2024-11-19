<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = $_POST['applicantName'];
      $position = $_POST['position'];
      $cv = $_FILES['cv'];

      // Email settings
      $to = "info@mantraxglobalservices.com, ceo@mantraxglobalservices.com";
      $subject = "New Job Application: $position";
      $headers = "From: $name <" . $_POST['email'] . ">\r\n";
      $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

      $message = "--boundary\r\n";
      $message .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
      $message .= "Content-Transfer-Encoding: 7bit\r\n";
      $message .= "Name: $name\r\n";
      $message .= "Position: $position\r\n";

      // Handle file attachment
      if (isset($cv) && $cv['error'] == 0) {
            $cvData = file_get_contents($cv['tmp_name']);
            $cvName = $cv['name'];
            $cvMimeType = mime_content_type($cv['tmp_name']);
            $cvEncoded = chunk_split(base64_encode($cvData));

            $message .= "--boundary\r\n";
            $message .= "Content-Type: $cvMimeType; name=\"$cvName\"\r\n";
            $message .= "Content-Disposition: attachment; filename=\"$cvName\"\r\n";
            $message .= "Content-Transfer-Encoding: base64\r\n";
            $message .= "$cvEncoded\r\n";
      }

      $message .= "--boundary--";

      // Send email
      if (mail($to, $subject, $message, $headers)) {
            echo "Application submitted successfully!";
      } else {
            echo "There was an error submitting your application. Please try again.";
      }
}
?>