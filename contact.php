<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>MIT MSA</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="css/additional.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
        
        <?php include 'include/menu.php'; ?>
        
        <h2 style="margin-left:10px;">Contact Us</h2>
        
        <div class='alert alert-info'>Thank you for visiting our website. If you would like to tell us about something or give feedback, please fill out the form below. <hr>
            <p>If you would like to send us mail, please send it to <strong>77 Massachusetts Avenue, Cambridge, MA 02139</strong>, with the recipient's name and building number (W11) noted.</p>
        </div>
        <div class='alert alert-danger'>
            <p>If you are contacting for housing purposes, please fill out the housing form below.</p>
        </div>
        <div id="result"></div>
        <div class="panel panel-default" style="max-width: 600px; margin-left: auto; margin-right: auto;">
            <div class="panel-heading">
                <h2 class="panel-title">Contact Form</h2>
            </div>
            <div class="panel-body">
                <form id="form" action="./include/request.php" method="post">
                <input type="hidden" name="type" value="contact">
                
                <div class="form-group">
                    <label for="name"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Full Name</label>
                    <input type="text" style="width:100%" name="name" placeholder="First and last Name" required="required">
                </div>
                
                <div class="form-group">
                    <label for="email"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Email</label>
                    <input type="text" style="width:100%" name="email" placeholder="email@domain.com" required="required">
                </div>
                
                <div class="form-group">
                    <label for="subject"><span class="glyphicon glyphicon-sign" aria-hidden="true"></span> Subject</label>
                    <input type="text" style="width:100%" name="subject" placeholder="what's this for?" required="required">
                </div>
                
                <div class="form-group">
                    <label for="message"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Message</label>
                    <textarea rows="6" style="width:100%" name="message" placeholder="Your Message" required="required" ></textarea>
                </div>
                <center>
                <div class="form-group">
                    <label for="recaptcha_div">Please check the box below:</label>
                    <div name="recaptcha_div" class="g-recaptcha" data-sitekey="6LfltCITAAAAABPo418SBcY538u5Xtnhx7dNr1bu"></div>
                </div>
                <div class="form-group" style="padding-top:10px">
                    <button id="contact-submit" type="submit" class="btn btn-large btn-primary"><i class="icon-share-alt icon-white"></i> Send Message</button>
                </div>
                </center>
                </form>
            </div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title">Housing Form</h2>
            </div>
            <div class="panel-body">
                <p>If you are looking for a roommate in the area you can contact people in the housing list below. You can also add listing if you are interested:</p>
                <center><a href="#myModal" role="button" class="btn btn-primary" data-toggle="modal"><i class="icon-plus icon-white"></i> Add Listing</a></center>
                <br>
                <p>If you would like to delete your posting, please send us a note through the contact form.</p>
                <p>You can also use <a href="http://muslimsofboston.com" target="_blank">muslimsofboston.com</a> website to search for housing in Boston area.</p>
                
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Add Listing</h3>
                        </div>
                        <div class="modal-body" style="max-height: 600px;width: 100%; overflow: scroll; -webkit-overflow-scrolling: touch;">
                            <iframe src="https://docs.google.com/spreadsheet/embeddedform?formkey=dFNqTUI5VTJaUkZNSDMwamtQaDhvZFE6MA" width="100%" height="550px" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        
        <div style="width: 100%; overflow-x: scroll; -webkit-overflow-scrolling: touch;">
            <iframe width="100%" height="500px" frameborder='1' src='https://docs.google.com/spreadsheet/ccc?key=0Ao804KHyJVUBdFNqTUI5VTJaUkZNSDMwamtQaDhvZFE&output=html'></iframe>
        </div>
        
        <?php include 'include/footer.php'; ?>
        
    </div> <!-- /container -->

    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script> 
    $(document).ready(function() {
            var options = { 
                target: '#result',   // target element(s) to be updated with server response 
                success: function () {
                    $('#formdiv').hide(500);
                    $('html, body').animate({ scrollTop: $('#result').offset().top }, 'fast');
                    grecaptcha.reset();
                },
                error: function (data) {
                    $('#result').html(data.responseText);
                    $('html, body').animate({ scrollTop: $('#result').offset().top }, 'fast');
                    grecaptcha.reset();
                },
                clearForm: true,      // clear all form fields after successful submit 
                resetForm: true,      // reset the form after successful submit 
                timeout:   3000 
            }; 
            $('#form').ajaxForm(options);  
        });
    </script>
  </body>
</html>