<?php
if ($_SERVER['HTTP_HOST'] != "mitmsa.scripts.mit.edu:444") {
    // If not https redirect
    header("Location: https://mitmsa.scripts.mit.edu:444/www/members");
    exit;
}

$auth = 0;
if (@$_SERVER['SSL_CLIENT_S_DN_Email']) {
    $atpos = strpos($_SERVER['SSL_CLIENT_S_DN_Email'], "@");
    if ($atpos === false) {
        die("Error while processing credentials!");
    }
    
    $kerberos = strtolower(substr($_SERVER['SSL_CLIENT_S_DN_Email'], 0, $atpos));
    $authlist = file_get_contents("msa_access.txt");
    
    if (strpos($authlist, "\n".$kerberos."\n") === false) {
        $auth = 2; // Not authorized
    } else {
        $auth = 1; // Authorized
    }
} else {
    $auth = 3; // No certificates
}
?>
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
        
        <h2 style="margin-left:10px;">Member's Corner</h2>
        
        <?php if ($auth == 1) { /* Here comes the spaghetti code :| */ ?>
        
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>
                    Welcome to the MSA Members corner! Below are several resources to help MSA members with navigating classes, extracurricular activities, and more. We request everyone to take a few moments to contribute to these databases, as they are only useful if we add to them. The information you offer can make a big difference in helping someone in a class they're struggling with or with finding a new interest!
                    </p>
                    <h4>
                        <b>Note: Please do not share any of these links or information outside of the MSA community out of respect of everyone's privacy.</b>
                    </h4>
                    
                    <br>
                    
                    <h4><a href="https://docs.google.com/spreadsheets/d/1BcsZjj8wbxwHOCmYYh63mBpvgadlasOWJRXsxliK4Oc/edit#gid=593127633" target="_blank">MSA Database</a></h4>
                    <p>
                    A database of current members and their pertinent information, such as contact info, residence, course, past internships, and interests. 
                    </p>
                    <h4><a href="https://docs.google.com/spreadsheets/d/1Z19GNwZ0Msa1Ux8s5YXL5JmIir14GiwsfMn1LXtojYE/edit#gid=1741724652" target="_blank">Organizations & Activities</a></h4>
                    <p>
                    List of names and descriptions of organizations that MSA members are involved in. Use this list to find new clubs to get involved in and to find out who to contact about what organization.
                    </p>
                    <h4><a href="https://docs.google.com/spreadsheets/d/1IG5N5Ylp7DCt7At4ItEwBLKWh8_DbFbiT3okj8Ntpvc/edit#gid=1549278829" target="_blank">Current Classes</a> (Spring 2017)</h4>
                    <p>
                    List of what classes MSA members are taking this semester (Spring 2017). You can use this to find friends to pset with or ask someone about a class you're interested in. 
                    </p>
                    <h4><a href="https://docs.google.com/spreadsheets/d/1uSABAZ426S_phnJCfnl6weFLN198c1gVDlVI8Ht7z5o/edit#gid=242927177" target="_blank">Class Help</a></h4>
                    <p>
                    Need help with a class? Use this list to find people who are willing to help with specific classes. Please also add classes to this list that you are comfortable with informally helping others in.
                    </p>
                    <h4><a href="https://www.dropbox.com/sh/4tgrtsx71lsd7pc/AAChEO1mnsLDm-_NeUiDBW8Za?dl=0" target="_blank">MSA Diwan</a>* (Course Bible)</h4>
                    <p>
                    Resources from MIT classes compiled over the years, including past psets, exams, and notes. <b><i>Please use these resources responsibly and ethically.</i></b> It is ok to use these materials for extra practice and to reinforce your learning. However, it is not ok to copy answers for identical pset questions. We trust you to use your best moral judgment. 
                    </p>
                    <p>
                    *Please fill out this <a href="https://docs.google.com/forms/d/e/1FAIpQLSfPknaVg9hIWZcYse3HOXdY89Q_9jseQyy_CMmgr01Q4V5Xdw/viewform?usp=sf_link">survey</a> to get access to the folder. After that, you need to add the folder we share with you to your Dropbox account to get access to the folder using the <a href="https://www.dropbox.com/sh/4tgrtsx71lsd7pc/AAChEO1mnsLDm-_NeUiDBW8Za?dl=0">link</a>.
                    </p>
                    <h4><a href="https://docs.google.com/spreadsheets/d/1qb32uoUsbYF9QOpFbYglukNXvRKgSjZpTON-Azdx338/edit#gid=236340220" target="_blank">HASS/Cross-registered Class Recommendations</a></h4>
                    <p>
                    Looking for a HASS class? You can use this list to see what HASS classes and cross-registered classes (e.g. at Harvard, Wellesley) others recommend. Please add reviews for any classes you've taken, whether good or bad, to pass on the information to others!
                    </p>
                </div>
            </div>
        
        <?php } /* $auth = 1 */ ?>
        
        <?php if ($auth == 2) { ?>
        
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>
                        You are not authorized to see this page. Please fill out the <a href="http://msa.mit.edu/contact">contact form</a> providing your Kerberos ID to get authorization. The MSA Members Corner is currently under renovation.
                    </p>
                </div>
            </div>
        
        <?php } /* $auth = 2 */ ?>
        
        <?php if ($auth == 3) { ?>
        
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>
                        No MIT certificates found. Please login with your <a href="https://ist.mit.edu/certificates">MIT certificates</a>.
                    </p>
                </div>
            </div>
        
        <?php } /* $auth = 3 */ ?>
        
        <?php include 'include/footer.php'; ?>
        
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
