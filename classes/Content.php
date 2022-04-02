<?php
class Content
{
  public $content_for_Page;
  public $data_for_Signed_User;
  public $protection_CSRF;

  public function __construct($content_for_Page, $data_for_user = array(), $protection_CSRF)
  {

    $this->content_for_Page = $content_for_Page;
    $this->data_for_Signed_User = $data_for_user;
    $this->protection_CSRF = $protection_CSRF;
  }

  public function displayContent()
  {

    if ($this->content_for_Page == 'Contact Page') {

      echo '    <p style="font-size:24px;">For any support regarding the app you can send an email to: <a href="mailto:notebookappcontact@gmail.com?subject=Title">notebookappcontact@gmail.com</a></p>';
    } else if ($this->content_for_Page == 'About Page') {

      echo '<p class="about_reading">Welcome to this app. It\'s a great pleasure to find you here. This application was made in order to give you an interactive way of storing information on the objectives you can have in the short or long term, thus realizing a small and easy to use tool for an agenda type web application for the user.<span  id="read_More_for_About">...(read more)</span></p>
          
          <p class="about_reading" id="further_reading_for_About">The technologies that were used in the development of this application include:HTML5, CSS3, Bootstrap4, Javascript(the jQuery library),PHP and SQL!The main developer whishes to learn more about your opinion about this application, and will gladly continue to improve the user experience, based on your suggestions.
          <br>Thank you for reading!!! 
          <span  id="collapse_read_More_for_About"> (hide content)</span></p>';
    } else if ($this->content_for_Page == 'Home Page') {

      echo '
                
               <form id="Calculator" name="Calculator">
                    <label>Last selected field is: <span id="current_Selected_Field"></span></label>
                    <br>
                    <input type="number" id="value1" name="value1" class="calculatorField"><br><br>
                    <input type="number" id="value2" name="value2" class="calculatorField"><br><br>

                   <table id="Calculator_Buttons">
                      <tr>
                       <td class="calculator_button"><input type="button" value="9" class="calculatorButton"></td>
                       <td class="calculator_button"><input type="button" value="8" class="calculatorButton"></td>
                       <td class="calculator_button"><input type="button" value="7" class="calculatorButton"></td>
                       <td class="calculator_button"><input type="button" value="+" class="operation" name="Addition"></td>
                      </tr> 
                      
                      <tr>
                      <td class="calculator_button"><input type="button" value="6" class="calculatorButton"></td>
                      <td class="calculator_button"><input type="button" value="5" class="calculatorButton"></td>
                      <td class="calculator_button"><input type="button" value="4" class="calculatorButton"></td>
                      <td class="calculator_button"><input type="button" value=" -" class="operation" name="Subtraction"></td>
                     </tr>
                     
                     <tr>
                       <td class="calculator_button"><input type="button" value="3" class="calculatorButton"></td>
                       <td class="calculator_button"><input type="button" value="2" class="calculatorButton"></td>
                       <td class="calculator_button"><input type="button" value="1" class="calculatorButton"></td>
                       <td class="calculator_button"><input type="button" value="x" class="operation" name="Multiplication"></td>
                      </tr>
                   
                      <tr>
                      <td class="calculator_button"><input type="button" value="0" class="calculatorButton"></td>
                      <td class="calculator_button"><input type="button" value="." class="calculatorButton"></td>
                      <td class="calculator_button"><input type="button" value="=" id="equal" name="equal"></td>
                      <td class="calculator_button"><input type="button" value="/" class="operation" name="Division"></td>
                     </tr> 
                      
                     <tr>
                     <td class="calculator_button" ><input type="button" value="^" class="operation" name="Power"></td>
                     
                     <td class="calculator_button"><input type="button" value="&radic;" class="operation" name="Root Extraction"></td>
               
                    </tr>

                   </table>     
                   
                   <label>Selected Operation is: <span id="operation_Selected"></span></label><br><br>
                   <label>Result: <span id="operation_Result"></span></label>
               </form>   
               
          ';
    } else if ($this->content_for_Page == 'Profile Page') {

      $submitted_To = htmlspecialchars($_SERVER['PHP_SELF']);

      echo '<h2 style="color:blue; font-size: 24px;">Your data is:</h2>';
      echo '<ul class="userData">';
      foreach ($this->data_for_Signed_User as $key => $data) {

        $edit_profile_Form = '
               <br> 
               <form action="' . $submitted_To . '" method="POST" class="form_Edit_Data" id="Edit_' . $key . '" >
                  <input type="text" id="' . $key . '" name="' . $key . '" placeholder="' . $key . '"></input>
                  <input type="hidden" name="token"  value="' . $this->protection_CSRF . '">
                  <input type="submit" name="submit_edit_info" value="Submit this edit">   
               </form>
                ';


        $key = ucfirst($key);
        echo '<li>' . $key . ' : ' . $data . '</li><button id="' . $key . '" class="edit_profile_data">Edit ' . $key . '</button>' . $edit_profile_Form;
      }
      echo '</ul>';

      echo '<hr style="width:100%;height:1px;background:blue;">';

      $change_photo_form = '<form action="' . $submitted_To . '" method="POST" enctype="multipart/form-data">
            
                                    <label>Change photo</label> 
                                    <input type="file" name="change_photo">
                                    <input type="hidden" name="token"  value="' . $this->protection_CSRF . '">  
                                    <input type="submit" name="submit_change_photo" value="Submit Photo">
                                  
                                 </form>';

      echo $change_photo_form;

      $delete_account_form = ' <button id="accountDeletion">Show Delete Options</button>
                                   <form id="accountDeletion_Form" action="' . $submitted_To . '" method="POST">
                                    
                                    <label for="account_deletion_checked">If you want to confirm account deletion,select this checkbox: <input id="account_deletion_checked" name="account_deletion_checked" type="checkbox"></label> 
                                    <br>
                                    <input type="hidden" name="token"  value="' . $this->protection_CSRF . '">
                                    <input type="submit" name="delete_account" value="Delete Account">
            
                                    </form>';

      echo  $delete_account_form;
    } else if ($this->content_for_Page == 'Agenda Options Page') {

      $submitted_To = htmlspecialchars($_SERVER['PHP_SELF']);

      echo '        
                <button id="controlActivity">Hide Activity Menu</button>
                <br>
                
               <form id="ActivityForm"  action="' . $submitted_To . '" method="POST">
               
                    <label for="activity_title">Enter the title of your activity here:</label>
                    <input type="text" id="activity_title" name="activity_title">
                    <br><br>
                         
                    <label for="activity_date">Enter the date of your activity here:</label>
                    <input type="date" id="activity_date" name="activity_date">
                    <br><br>

                    <label for="activity_description">Enter the description of your activity here:</label><br><br>
                    <textarea id="activity_description" name="activity_description"></textarea>
                    <br><br>
               
                    <input type="submit" id="register_agenda_activity" name="register_agenda_activity" value="Register this activity">
                    <br><br><br><br>
                    <input type="hidden" name="token"  value="' . $this->protection_CSRF . '">
                    <input type="submit" id="show_agenda_activities" name="show_agenda_activities" value="Generate My Agenda">
                    </form>
                 
                 <br>  
                 <button id="controlSong">Hide Song Menu</button>
          
                    <form id="SongForm" action="' . $submitted_To . '" method="POST" enctype="multipart/form-data">
                    
                         <label for="song">Enter the name of your track here: <span style="color:red; font-size: 20px;">*</span></label>
                         <input type="text" id="song" name="song"><br><br>
                         <input type="file" name="songUploaded" id="songUploaded">
                         <br><br>

                         <input type="submit" id="register_song" name="register_song" value="Register this song"><br><br>
                         <span style="font-weight:bold;font-size: 18px;"><span style="color:red; font-size: 20px;">*</span> This field is optional, if you complete it, the song will be renamed!</span> 
                         <br><br>
                         <input type="hidden" name="token"  value="' . $this->protection_CSRF . '">
                         <input type="submit" id="Generate_Playlist" name="Generate_Playlist" value="Generate My Playlist">  
                    </form>';
    }
  }
}
