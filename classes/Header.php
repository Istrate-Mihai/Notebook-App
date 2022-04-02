<?php

class Header
{

  public $titles;

  function __construct($title)
  {

    $this->title = $title;
  }


  protected function header($link_1, $link_2, $link_3, $link_4, $link_5)
  {


    if (!isset($_SESSION['userid'])) {

      if ($link_1 == 'Home') {

        $Title = '<h1>Your Notebook</h1>';
      } else if ($link_2 == 'Sign Up') {

        $Title = "<h1>$link_2</h1>";
      } else if ($link_3 == 'Sign In') {

        $Title = "<h1>$link_3</h1>";
      } else if ($link_4 == 'About') {

        $Title = "<h1>$link_4</h1>";
      } else if ($link_5 == 'Contact') {

        $Title = "<h1>$link_5</h1>";
      }
    } else {

      if ($link_1 == 'Home') {

        $Title = '<h1>Your Notebook</h1>';
      } else if ($link_2 == 'Agenda Options') {

        $Title = "<h1>$link_2</h1>";
      } else if ($link_3 == 'Your Profile') {

        $Title = "<h1>$link_3</h1>";
      } else if ($link_4 == 'About') {

        $Title = "<h1>$link_4</h1>";
      } else if ($link_5 == 'Contact') {

        $Title = "<h1>$link_5</h1>";
      }
    }


    echo "<header>
        $Title
         <nav>
            <ul>
               <li>${link_1}</li>
               <li>${link_2}</li>
               <li>${link_3}</li>
               <li>${link_4}</li>
               <li>${link_5}</li>  
            </ul> 
         
         </nav>
  
     </header>";
  }

  public function displayHeader()
  {

    if (!isset($_SESSION['userid'])) {

      if ($this->title == 'Home') {

        $this->header($this->title, '<a href="pages/Sign_Up.php">Sign Up</a>', '<a href="pages/Sign_In.php">Sign In</a>', '<a href="pages/About.php">About</a>', '<a href="pages/Contact.php">Contact</a>');
      } else if ($this->title == 'Sign Up') {

        $this->header('<a href="../index.php">Home</a>', $this->title, '<a href="Sign_In.php">Sign In</a>', '<a href="About.php">About</a>', '<a href="Contact.php">Contact</a>');
      } else if ($this->title == 'Sign In') {

        $this->header('<a href="../index.php">Home</a>', '<a href="Sign_Up.php">Sign Up</a>', $this->title, '<a href="About.php">About</a>', '<a href="Contact.php">Contact</a>');
      } else if ($this->title == 'About') {

        $this->header('<a href="../index.php">Home</a>', '<a href="Sign_Up.php">Sign Up</a>', '<a href="Sign_In.php">Sign In</a>', $this->title, '<a href="Contact.php">Contact</a>');
      } else if ($this->title == 'Contact') {

        $this->header('<a href="../index.php">Home</a>', '<a href="Sign_Up.php">Sign Up</a>', '<a href="Sign_In.php">Sign In</a>', '<a href="About.php">About</a>', $this->title);
      }
    } else {

      if ($this->title == 'Home') {

        $this->header($this->title, '<a href="pages/Agenda_Options.php">Agenda Options</a>', '<a href="pages/Profile.php">Your Profile</a>', '<a href="pages/About.php">About</a>', '<a href="pages/Contact.php">Contact</a>');
      } else if ($this->title == 'Agenda Options') {

        $this->header('<a href="../index.php">Home</a>', $this->title, '<a href="Profile.php">Your Profile</a>', '<a href="About.php">About</a>', '<a href="Contact.php">Contact</a>');
      } else if ($this->title == 'Your Profile') {

        $this->header('<a href="../index.php">Home</a>', '<a href="Agenda_Options.php">Agenda Options</a>', $this->title, '<a href="About.php">About</a>', '<a href="Contact.php">Contact</a>');
      } else if ($this->title == 'About') {

        $this->header('<a href="../index.php">Home</a>', '<a href="Agenda_Options.php">Agenda Options</a>', '<a href="Profile.php">Your Profile</a>', $this->title, '<a href="Contact.php">Contact</a>');
      } else if ($this->title == 'Contact') {

        $this->header('<a href="../index.php">Home</a>', '<a href="Agenda_Options.php">Agenda Options</a>', '<a href="Profile.php">Your Profile</a>', '<a href="About.php">About</a>', $this->title);
      }
    }
  }
}
