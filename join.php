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
        
        <div id="result"></div>
        <div class="panel panel-default" style="max-width: 600px; margin-left: auto; margin-right: auto;">
            <div class="panel-heading">
                <h2 class="panel-title">Join Our Mailing Lists</h2>
            </div>
            <div class="panel-body">
                <p>
                We encourage you to get involved and stay informed by joining one of our mailing lists. To subscribe, please fill out the form below:
                </p>
                <form id="form" action="./include/request.php" method="post">
                    <input type="hidden" name="type" value="join">
                    
                    <div class="form-group">
                        <label for="joinName"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Name</label>
                        <input type="text" style="width:100%" name="name" placeholder="First and last name, optional" id="joinName">
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label" for="email"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Email (@mit.edu if available)</label>
                        <input type="text" style="width:100%" name="email" placeholder="benbitdiddle@mit.edu" required="required">
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label" for="email"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Class Year</label>
			<select name="year" class="form-control">
			    <option>MIT Class of 2025</option>
                            <option>MIT Class of 2024</option>
                            <option>MIT Class of 2023</option>
			    <option>MIT Class of 2022</option>
			    <option>MIT Class of 2021</option>
			    <option>MIT Post-Doc</option>
                            <option>MIT Graduate Student</option>
                            <option>MIT MSA Alumni</option>
                            <option>MIT Affiliated</option>
                            <option>Not MIT Affiliated</option>
                        </select>
                    </div>
                    <center>
                    <div class="form-group">
                        <label for="recaptcha_div">Please check the box below:</label>
                        <div name="recaptcha_div" class="g-recaptcha" data-sitekey="6LfltCITAAAAABPo418SBcY538u5Xtnhx7dNr1bu"></div>
                    </div>
                    <div class="form-group" style="padding-top:10px">
                        <button id="contact-submit" type="submit" class="btn btn-large btn-primary"><i class="icon-share-alt icon-white"></i> Send Request</button>
                    </div>
                    </center>
                </form>
            </div>
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
