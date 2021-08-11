<?php
require_once "Mail.php";

$contactdestination = "msa-webforms@mit.edu";
$joindestination = "msa-webmaster@mit.edu";

if (isset($_POST['g-recaptcha-response'])) {
    $privatekey = "6LfltCITAAAAAPvJSHBJ0WhA1z6ZsI6chS3IFiY2";
    $captcha = $_POST['g-recaptcha-response'];
    
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$privatekey."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR'];
    $response = file_get_contents($url);
    
    // We don't have json_decode :(, also sometimes response is empty
    if ($response == "" || strpos($response, 'true') !== false) {
        if (isset($_POST['email'])) {
            if (!(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))) {
                returnError("<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Error:</strong> The email you provided is invalid.</div>");
            }
        }
        if (isset($_POST['type'])) {
            if($_POST['type'] == 'contact') {
                contactForm();
            } else if($_POST['type'] == 'join') {
                joinForm();
            }
        }
    } else {
        returnError("<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Error:</strong> reCAPTCHA error!</div>");
    }
}

function contactForm() {
    global $contactdestination; // PHP :/
    $subject = "MIT MSA Contact Form: ".$_POST['subject'];
    $body = "From: ".$_POST['name']." <".$_POST['email'].">\r\nSubject: ".$_POST['subject']."\r\n\r\nMessage:\r\n".$_POST['message'];
    $replyto = $_POST['name']." <".$_POST['email'].">, ".$contactdestination;
    if(smtpMail($contactdestination, $subject, $body, $replyto)) {
        echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Thank you:</strong> Your request has been submitted.</div>";
        $con = mysqli_connect("sql.mit.edu", "mitmsa", "43f1ff5", "mitmsa+webforms");
        if(mysqli_connect_errno()) return;
        $s = mysqli_real_escape_string($con, $_POST['subject']);
        $n = mysqli_real_escape_string($con, $_POST['name']);
        $e = mysqli_real_escape_string($con, $_POST['email']);
        $m = mysqli_real_escape_string($con, $_POST['message']);
        mysqli_query($con, "INSERT into contactform (subject, name, email, message, timestamp) VALUES ('$s', '$n', '$e', '$m', '".time()."')");
        mysqli_close($con);
    } else {
        returnError("<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Error:</strong> Message delivery failed. Please try again.</div>");
    }
}

function joinForm() {
    global $joindestination;
    $subject = "MIT MSA Mailing List Join Request From: ".$_POST['name'].' <'.$_POST['email'].'> of year '.$_POST['year'];
    $body = "Name: ".$_POST['name']." <".$_POST['email'].">\r\nYear: ".$_POST['year'];
    if(smtpMail($joindestination, $subject, $body, $joindestination)) {
        echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Thank you:</strong> Your request has been submitted.</div>";
        $con = mysqli_connect("sql.mit.edu", "mitmsa", "43f1ff5", "mitmsa+webforms");
        if(mysqli_connect_errno()) return;
        $n = mysqli_real_escape_string($con, $_POST['name']);
        $e = mysqli_real_escape_string($con, $_POST['email']);
        $y = mysqli_real_escape_string($con, $_POST['year']);
        mysqli_query($con, "INSERT into joinform (name, email, year, timestamp) VALUES ('$n', '$e', '$y', '".time()."')");
        mysqli_close($con);
    } else {
        returnError("<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Error:</strong> Message delivery failed. Please try again.</div>");
    }
}

// PHP default mail function sometimes fails. So use PEAR mail instead.
// See: https://scripts.mit.edu/faq/160/how-can-i-reliably-send-email-from-scripts
function smtpMail($to, $subject, $body, $replyto) {
    $from = "MSA Webforms <msa-webforms@mit.edu>";
    $host = "outgoing.mit.edu:25";
    $headers = array ('From' => $from,
      'Reply-To' => $replyto,
      'To' => $to,
      'Subject' => $subject);
    $smtp = Mail::factory('smtp',
      array ('host' => $host));
    $mail = $smtp->send($to, $headers, $body);
    if (PEAR::isError($mail)) {
        return FALSE;
    } else {
        return TRUE;
    }
}

function returnError($msg) {
    http_response_code(403);
    die($msg);
}
?>