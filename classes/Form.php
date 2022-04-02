<?php
class Form
{

  public $which_Form;
  public $file_executed;
  public $protection_CSRF;

  public function __construct($which_Form, $file_executed = '', $protection = '')
  {

    $this->which_Form = $which_Form;
    $this->file_executed = $file_executed;
    $this->protection_CSRF = $protection;
  }

  public function displayForm()
  {


    if ($this->which_Form == 'Sign Up') {

      $given_signUp_Data = func_get_args();

      if (!empty($given_signUp_Data)) {

        if (isset($given_signUp_Data[0]['Name'])) {

          $name = $given_signUp_Data[0]['Name'];
        } else {
          $name = '';
        }


        if (isset($given_signUp_Data[0]['Firstname'])) {

          $firstname = $given_signUp_Data[0]['Firstname'];
        } else {
          $firstname = '';
        }


        if (isset($given_signUp_Data[0]['Email'])) {

          $email = $given_signUp_Data[0]['Email'];
        } else {
          $email = '';
        }


        if (isset($given_signUp_Data[0]['Username'])) {

          $username = $given_signUp_Data[0]['Username'];
        } else {
          $username = '';
        }


        if (isset($given_signUp_Data[0]['Password'])) {

          $password = $given_signUp_Data[0]['Password'];
        } else {
          $password = '';
        }

        if (isset($given_signUp_Data[0]['Gender'])) {

          $gender = $given_signUp_Data[0]['Gender'];

          if ($gender === 'Male') {

            $selected_male = 'selected';
            $selected_female = '';
          } else if ($gender === 'Female') {

            $selected_male = '';
            $selected_female = 'selected';
          }
        } else {

          $selected_male = '';
          $selected_female = '';
        }

        if (isset($given_signUp_Data[0]['Policy'])) {

          $checked = 'checked';
        } else {

          $checked = '';
        }
      } else {
        $name = '';
        $firstname = '';
        $email = '';
        $username = '';
        $password = '';
        $selected_male = '';
        $selected_female = '';
        $checked = '';
      }



      echo "
            <form action=\"$this->file_executed\" method=\"POST\" name=\"signUp_Form\" id=\"signUp_Form\" enctype=\"multipart/form-data\"> 
                <label for=\"name\">Name: <span style=\"color:red;\">*</span></label><br>
                <input type=\"text\" id=\"name\" name=\"name\" value=\"$name\" required><br><br>
                
                <label for=\"firstname\">First Name: <span style=\"color:red;\">*</span></label><br>
                <input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"$firstname\" required><br><br>
            
                <label for=\"email\">Email: <span style=\"color:red;\">*</span></label><br>
                <input type=\"email\" id=\"email\" name=\"email\" value=\"$email\" required><br><br>
                
                <label for=\"username\">User Name: <span style=\"color:red;\">*</span></label><br>
                <input type=\"text\" id=\"username\" name=\"username\" value=\"$username\" required><br><br>
             
                <label for=\"password\">Password: <span style=\"color:red;\">*</span></label><br>
                <input type=\"password\" id=\"password\" name=\"password\" value=\"$password\" required><button id=\"passwordVisibility\">Show</button><br><br>
                
                <label for=\"userPhoto\" id=\"userPhoto\">Profile photo: <span style=\"color:blue;\">**</span></label><br>
                <input type=\"file\" id=\"userPhoto\" name=\"userPhoto\"><br><br>

                <label>Select gender: <span style=\"color:red;\">*</span></label><br>
                <select name=\"genderSelection\">
                <option value=\"No Gender Selected\">No Gender Selected</option>
                <option value=\"Male\" $selected_male>Male</option>
                <option value=\"Female\" $selected_female>Female</option>
                </select><br><br>

                <input type=\"checkbox\" id=\"check_Conditions\" value=\"Privacy Policy Accepted\" name=\"check_Conditions\" $checked> 
                <label for=\"check_Conditions\"> <span style=\"color:red;\">*</span> I Agree to Privacy Policy</label><br><br>

                <input type=\"submit\" name=\"submit\" value=\"Register\">
                <input type=\"reset\" name=\"reset\" value=\"Clear Fields\"><br><br>
                <input type=\"hidden\" name=\"token\"  value=\"$this->protection_CSRF\">
                <label> <span style=\"color:red;\">* - Required &nbsp;</span></label><br>
                <label> <span style=\"color:blue;\">** - Optional &nbsp;</span></label>
            </form>";
    } else if ($this->which_Form == 'Sign In') {

      echo '
            <form action="' . $this->file_executed . '" method="POST" name="signIn_Form" id="signIn_Form"> 
                
                <label for="username">User Name:</label><br>
                <input type="text" id="username" name="username" required><br><br>
             
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <input type="hidden" name="token"  value="' . $this->protection_CSRF . '">
                <input type="submit" name="submit" value="Sign In">
        
            
            </form>';
    }
  }
}
