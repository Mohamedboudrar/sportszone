<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../vendor/autoload.php';

function sendBookingConfirmationEmail($bookingDetails) {
    error_log("Starting email sending process...");
    
    if(empty($bookingDetails['EmailId'])) {
        error_log("No email address found in booking details");
        throw new Exception("No email address found in booking details");
    }

    $mail = new PHPMailer(true);

    try {
        // MailerSend SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.mailersend.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'MS_Q7EOC4@trial-7dnvo4dx6yng5r86.mlsender.net';
        $mail->Password = 'elNT3UDmCQXBAkqs';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        
        // Debug mode
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Debugoutput = function($str, $level) {
            error_log("SMTP Debug: $str");
        };

        // Set UTF-8 encoding
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        // From and To addresses - Using verified domain from MailerSend
        $mail->setFrom('noreply@trial-7dnvo4dx6yng5r86.mlsender.net', 'SportsZone');
        $mail->addAddress($bookingDetails['EmailId']);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Booking Confirmation - " . $bookingDetails['BookingNumber'];
        
        // Create email body
        $emailBody = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .booking-details { 
                    background: #f8f9fa;
                    padding: 20px;
                    border-radius: 8px;
                    margin: 20px 0;
                }
                .total-price {
                    font-size: 18px;
                    font-weight: bold;
                    color: #2563eb;
                    margin-top: 15px;
                }
            </style>
        </head>
        <body>
            <h2>Your Booking Has Been Confirmed!</h2>
            <div class='booking-details'>
                <p><strong>Booking Number:</strong> {$bookingDetails['BookingNumber']}</p>
                <p><strong>Zone:</strong> {$bookingDetails['BoatName']}</p>
                <p><strong>Date:</strong> {$bookingDetails['BookingDate']}</p>
                <p><strong>Time:</strong> {$bookingDetails['TimeFrom']} to {$bookingDetails['TimeTo']}</p>
                <p><strong>Number of People:</strong> {$bookingDetails['NumnerofPeople']}</p>
                <p><strong>Price per Person:</strong> {$bookingDetails['Price']} MAD</p>
                <div class='total-price'>
                    Total Price: " . ($bookingDetails['Price'] * $bookingDetails['NumnerofPeople']) . " MAD
                </div>
            </div>
            <p>Thank you for choosing our services!</p>
            <p>If you have any questions, please don't hesitate to contact us.</p>
        </body>
        </html>
        ";
        
        $mail->Body = $emailBody;

        // Send email
        $result = $mail->send();
        error_log("Email send attempt completed. Result: " . ($result ? 'Success' : 'Failed'));
        
        return $result;
    } catch (Exception $e) {
        error_log("Mail Error: " . $e->getMessage());
        error_log("Detailed Error Info: " . $mail->ErrorInfo);
        throw new Exception("Failed to send email: " . $e->getMessage());
    }
}

function sendBookingRejectionEmail($bookingDetails) {
    error_log("Starting rejection email process...");
    
    if(empty($bookingDetails['EmailId'])) {
        error_log("No email address found in booking details");
        throw new Exception("No email address found in booking details");
    }

    $mail = new PHPMailer(true);

    try {
        // MailerSend SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.mailersend.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'MS_Q7EOC4@trial-7dnvo4dx6yng5r86.mlsender.net';
        $mail->Password = 'elNT3UDmCQXBAkqs';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        
        // Debug mode
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Debugoutput = function($str, $level) {
            error_log("SMTP Debug: $str");
        };

        // Set UTF-8 encoding
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        // From and To addresses
        $mail->setFrom('noreply@trial-7dnvo4dx6yng5r86.mlsender.net', 'SportsZone');
        $mail->addAddress($bookingDetails['EmailId']);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Booking Rejected - " . $bookingDetails['BookingNumber'];
        
        // Create email body
        $emailBody = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .booking-details { 
                    background: #f8f9fa;
                    padding: 20px;
                    border-radius: 8px;
                    margin: 20px 0;
                }
                .rejection-reason {
                    background: #fee2e2;
                    border-left: 4px solid #dc2626;
                    padding: 15px;
                    margin: 20px 0;
                }
            </style>
        </head>
        <body>
            <h2>Booking Request Rejected</h2>
            <div class='booking-details'>
                <p><strong>Booking Number:</strong> {$bookingDetails['BookingNumber']}</p>
                <p><strong>Zone:</strong> {$bookingDetails['BoatName']}</p>
                <p><strong>Date:</strong> {$bookingDetails['BookingDate']}</p>
                <p><strong>Time:</strong> {$bookingDetails['TimeFrom']} to {$bookingDetails['TimeTo']}</p>
            </div>
            <div class='rejection-reason'>
                <h3>Reason for Rejection:</h3>
                <p>{$bookingDetails['AdminRemark']}</p>
            </div>
            <p>We apologize for any inconvenience. Please feel free to make another booking or contact us if you have any questions.</p>
        </body>
        </html>
        ";
        
        $mail->Body = $emailBody;

        // Send email
        $result = $mail->send();
        error_log("Email send attempt completed. Result: " . ($result ? 'Success' : 'Failed'));
        
        return $result;
    } catch (Exception $e) {
        error_log("Mail Error: " . $e->getMessage());
        error_log("Detailed Error Info: " . $mail->ErrorInfo);
        throw new Exception("Failed to send email: " . $e->getMessage());
    }
}
