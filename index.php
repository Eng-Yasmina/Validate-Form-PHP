<!DOCTYPE html>
<html> 
    <head> 
        <title>ITI CMS PHP</title> 
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="style.css">
    </head> 
    <body> 
        <div class="container"> 
            <div class="row justify-content-center"> 
                <div class="col-md-8"> <div class="card"> 
                    <div class="card-header">Application name: ITI_PHP_LAB_3</div> 
                    <p class="card-body required" style="color:red;">Required field</p>
                    <div class="card-body"> 
                        <form action="<?php $_PHP_SELF ?>" method="POST"> 
                        <div class="form-group"> 
                            <label for="name" class="required">Name:</label> 
                            <input type="text" id="name" name="name" class="form-control"> 
                            <?php if (isset($_GET['nameerror'])) {
                                //----------------BONUS  -------------
                                // i removed the required attribute from the form to redirect the user to my error page
                                ?>
                                <div class="alert alert-danger msg">
                                    Name is required
                                </div>
                            <?php } ?>
                            <span>
                                <?php 
                                //invalid name characters
                                echo $nameErr ?>
                            </span> 
                        </div>

                        <div class="form-group"> 
                            <label for="email" class="required">Email:</label> 
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo $email;?>"> 
                            <?php if (isset($_GET['emailerror'])) {
                                //----------------BONUS  ---------------
                                ?>
                                <div class="alert alert-danger msg">
                                    Email is required
                                </div>
                            <?php } ?>
                            <span>
                                <?php 
                                //invalid email
                                echo $emailErr ?>
                            </span> 
                        </div> 

                        <div class="form-group"> 
                            <label for="group">Group #:</label> 
                            <input type="text" id="group" name="group" class="form-control"> 
                        </div>

                        <div class="form-group"> 
                            <label for="class_details">Class Details:</label> 
                            <textarea id="class_details" name="class_details" class="form-control"></textarea> 
                        </div> 

                        <div class="form-group"> 
                            <label for="gender" class="required">Gender:</label><br> 
                            <input type="radio" id="male" name="gender" value="male"> 
                            <label for="male">Male</label> 
                            <input type="radio" id="female" name="gender" value="female"> 
                            <label for="female">Female</label> 
                            <?php if (isset($_GET['gendererror'])) {
                                //----------------BONUS  ---------------
                                ?>
                                <div class="alert alert-danger msg">
                                    Gender is required
                                </div>
                            <?php } ?>
                        </div> 

                        <div class="form-group"> 
                            <label for="select_courses">Select Courses:</label> 
                            <select id="select_courses" name="select_courses[]" multiple class="form-control"> 
                                <option value="course1">PHP</option> 
                                <option value="course2">Java Script</option> 
                                <option value="course3">MySQL</option> 
                                <option value="course4">HTML</option> 
                            </select> 
                        </div> 

                        <div class="form-group"> 
                            <label for="agree" class="required">Agree</label> 
                            <input type="checkbox" id="agree" name="agree" value="agree"> 
                            <?php if (isset($_GET['agreerror'])) {
                                //----------------BONUS  ---------------
                                // my technique is to remove the required attribute from the form to redirect the user to my erre page
                                ?>
                                <div class="alert alert-danger msg">
                                    You must agree to ITI terms and conditions
                                </div>
                            <?php } ?>
                        </div> 

                        <div class="form-group"> 
                            <input type="submit" value="Submit" class="btn btn-primary" name="formSubmit"> 
                        </div> 
                    </form> 
                    
                    <script> setTimeout(function() { 
                        // Set a timer to remove the error msg after 3 secondes
                        document.querySelector(".msg").style.display = "none"; }, 3000);
                    </script>
                    
                    <?php 
                    $name="";
                    $email="";
                    $group="";
                    
                    if(isset($_POST['formSubmit'])) { 
                        $name = test_input($_POST["name"]); 
                        $email = test_input($_POST["email"]); 
                        $group = $_POST["group"]; 
                        $class_details = $_POST["class_details"]; 
                        $gender = $_POST["gender"]; 
                        $select_courses = $_POST["select_courses"]; 
                        $agree = $_POST["agree"]; 
                        $errors = [];
                        //form validation 
                        if(empty($name)) { $errors['name']  = 'required'; } 
                        // Check if name only contains letters and whitespace
                        elseif(!preg_match("/^[a-zA-Z ]*$/",$name)) {
                            $nameErr = "Only letters and white space allowed";
                        }

                        elseif(empty($email)) { $errors['email']  = 'required'; }
                        // Check if email address is well-formed 
                        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
                            $emailErr = "Invalid email format"; 
                            } 

                        elseif(empty($gender)) { $errors['gender']  = 'required'; } 

                        elseif(empty($agree)) { $errors['agree']  = 'required'; } 

                        // redirect the user to a specific error page for each missing required fields
                        if(!empty($errors['name']))
                        {
                            header("Location:http://localhost/PHP/?nameerror=true");
                            exit();
                        }
                        elseif(!empty($errors['email']))
                        {
                            header("Location:http://localhost/PHP/?emailerror=true");
                            exit();
                        }
                        elseif(!empty($errors['gender']))
                        {
                            header("Location:http://localhost/PHP/?gendererror=true");
                            exit();
                        }
                        elseif(!empty($errors['agree']))
                        {
                            header("Location:http://localhost/PHP/?agreerror=true");
                            exit();
                        }
                        //if the user doesn't exit, print the result
                            echo "<div class='alert alert-success'>"; 
                            echo "<h1> Your given values are as: </h1>"; 
                            echo "Name: " . $name . "<br>"; 
                            echo "Email: " . $email . "<br>"; 
                            echo "Group #: " . $group . "<br>"; 
                            echo "Class Details: " . $class_details . "<br>"; 
                            echo "Gender: " . $gender . "<br>"; 
                            echo "Your Courses are: "; 
                            foreach($select_courses as $course) { echo $course . ", "; } 
                    }
                    
                    function test_input($data) { 
                        $data = trim($data);
                         $data = stripslashes($data); 
                         $data = htmlspecialchars($data); 
                         return $data; 
                         } 
                    ?> 
                    </div> 
                </div> 
             </div> 
            </div>
        </div> 
    </body> 
</html>