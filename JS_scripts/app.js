$(document).ready(function () {
  function quotes_Parameters() {
    let l = quotes.length;
    let r = Math.random();
    let i = Math.floor(r * l);
    return i;
  }
  let i = 0;
  let menuDisplayed = true;
  let indexGallery = [
    "images/index_gallery1.jpg",
    "images/index_gallery2.jpg",
    "images/index_gallery3.jpg",
    "images/index_gallery4.jpg",
    "images/index_gallery5.jpg",
    "images/index_gallery6.jpg",
    "images/index_gallery7.jpg",
    "images/index_gallery8.jpg",
    "images/index_gallery9.jpg",
    "images/index_gallery10.jpg",
    "images/index_gallery11.jpg",
    "images/index_gallery12.jpg",
  ];
  let Calculator_Displayed = false;
  let quotes = [
    "If you set your goals ridiculously high and it's a failure, you will fail above everyone else's success.-James Cameron",
    "Always remember that you are absolutely unique. Just like everyone else.-Margaret Mead",
    "The greatest glory in living lies not in never falling, but in rising every time we fall.-Nelson Mandela",
    "Your time is limited, so don't waste it living someone else's life. Don't be trapped by dogma — which is living with the results of other people's thinking.-Steve Jobs",
    "I failed my way to success.-Thomas Edison",
    "You become what you believe.-Oprah Winfrey",
    "Whatever the mind of man can conceive and believe, it can achieve.-Napoleon Hill",
    "The question isn't who is going to let me; it's who is going to stop me.-Ayn Rand",
    "There are no secrets to success. It is the result of preparation, hard work, and learning from failure.-Colin Powell",
    "Life is made of ever so many partings welded together.-Charles Dickens",
    "Everything you've ever wanted is on the other side of fear.-George Addair",
    "I have learned over the years that when one's mind is made up, this diminishes fear.-Rosa Parks",
    "First, have a definite, clear practical ideal; a goal, an objective. Second, have the necessary means to achieve your ends; wisdom, money, materials, and methods. Third, adjust all your means to that end.-Aristotle",
    "You miss 100% of the shots you don't take.-Wayne Gretzky",
    "People who succeed have momentum. The more they succeed, the more they want to succeed and the more they find a way to succeed. Similarly, when someone is failing, the tendency is to get on a downward spiral that can even become a self-fulfilling prophecy.-Tony Robbins",
  ];

  //Functionality for the Menu Button
  $("#Menu_Button").click(function () {
    if (menuDisplayed) {
      $(this).text("Show menu");
      $("nav").css("display", "none");
      menuDisplayed = false;
    } else {
      $(this).text("Hide menu");
      $("nav").css("display", "block");
      menuDisplayed = true;
    }
  });

  //Functionality for the Image Gallery on the home page
  setInterval(function () {
    $("#index_page_gallery").css({
      "background-image": "url(" + indexGallery[i] + ")",
      "background-size": "cover",
    });

    i += 1;
    if (i == 12) {
      i = 0;
    }
  }, 6000);

  //Functionality for displaying and hiding content on the about page
  $("#read_More_for_About").click(function () {
    $(this).css("display", "none");
    $("#further_reading_for_About").css("display", "block");
  });

  $("#collapse_read_More_for_About").click(function () {
    $("#further_reading_for_About").css("display", "none");
    $("#read_More_for_About").css("display", "inline");
  });

  //Functionality for displaying and hiding calculator on the home page
  $("#Calculator_Button").click(function () {
    if (!Calculator_Displayed) {
      $(this).text("Hide calculator");
      $("#Calculator").css("display", "block");
      Calculator_Displayed = true;
    } else {
      $(this).text("Show calculator");
      $("#Calculator").css("display", "none");
      Calculator_Displayed = false;
    }
  });

  //Functionality for password visibility
  $("#passwordVisibility").mousedown(function () {
    $("#password").attr("type", "text");
  });

  $("#passwordVisibility").mouseup(function () {
    $("#password").attr("type", "password");
  });

  //Initialization of first quote
  let index = quotes_Parameters();
  $("#quote").text(quotes[index]);
  //Functionality for generating quotes
  $("#Quote_Generator_Button").click(function () {
    let index = quotes_Parameters();

    $("#quote").text(quotes[index]);
  });
  let showEdit_Name,
    showEdit_Firstname,
    showEdit_Username,
    showEdit_Password,
    showEdit_Gender,
    showEdit_Email;
  showEdit_Name = false;
  showEdit_Firstname = false;
  showEdit_Username = false;
  showEdit_Password = false;
  showEdit_Gender = false;
  showEdit_Email = false;

  //Functionality for editing profile data
  $(".edit_profile_data").click(function () {
    let id = this.getAttribute("id");

    switch (id) {
      case "Name":
        if (!showEdit_Name) {
          $("#Edit_name").css({ display: "block" });
          $("#Name").text("Hide Edit Name");
          showEdit_Name = true;
        } else {
          $("#Edit_name").css({ display: "none" });
          $("#Name").text("Edit Name");
          showEdit_Name = false;
        }
        break;
      case "Firstname":
        if (!showEdit_Firstname) {
          $("#Edit_firstname").css({ display: "block" });
          $("#Firstname").text("Hide Edit Firstname");
          showEdit_Firstname = true;
        } else {
          $("#Edit_firstname").css({ display: "none" });
          $("#Firstname").text("Edit Firstname");
          showEdit_Firstname = false;
        }
        break;
      case "Username":
        if (!showEdit_Username) {
          $("#Edit_username").css({ display: "block" });
          $("#Username").text("Hide Edit Username");
          showEdit_Username = true;
        } else {
          $("#Edit_username").css({ display: "none" });
          $("#Username").text("Edit Username");
          showEdit_Username = false;
        }
        break;
      case "Password":
        if (!showEdit_Password) {
          $("#Edit_password").css({ display: "block" });
          $("#Password").text("Hide Edit Password");
          showEdit_Password = true;
        } else {
          $("#Edit_password").css({ display: "none" });
          $("#Password").text("Edit Password");
          showEdit_Password = false;
        }
        break;
      case "Gender":
        if (!showEdit_Gender) {
          $("#Edit_gender").css({ display: "block" });
          $("#Gender").text("Hide Edit Gender");
          showEdit_Gender = true;
        } else {
          $("#Edit_gender").css({ display: "none" });
          $("#Gender").text("Edit Gender");
          showEdit_Gender = false;
        }
        break;
      case "Email":
        if (!showEdit_Email) {
          $("#Edit_email").css({ display: "block" });
          $("#Email").text("Hide Edit Email");
          showEdit_Email = true;
        } else {
          $("#Edit_email").css({ display: "none" });
          $("#Email").text("Edit Email");
          showEdit_Email = false;
        }
        break;
    }
  });
  let showRegisterActivity = true;
  let showSong = true;
  //Functionality for agenda options buttons for menus
  $("#controlActivity").click(function () {
    if (showRegisterActivity) {
      $("#ActivityForm").slideUp();
      $(this).text("Show Activity Menu");
      showRegisterActivity = false;
    } else {
      $("#ActivityForm").slideDown();
      $(this).text("Hide Activity Menu");
      showRegisterActivity = true;
    }
  });

  $("#controlSong").click(function () {
    if (showSong) {
      $("#SongForm").slideUp();
      $(this).text("Show Song Menu");
      showSong = false;
    } else {
      $("#SongForm").slideDown();
      $(this).text("Hide Song Menu");
      showSong = true;
    }
  });
  let accountDeletion_Displayed = false;
  //Functionality for account deletion options
  $("#accountDeletion").click(function () {
    if (!accountDeletion_Displayed) {
      $(this).text("Hide Delete Options");
      $("#accountDeletion_Form").css("display", "block");
      accountDeletion_Displayed = true;
    } else {
      $(this).text("Show Delete Options");
      $("#accountDeletion_Form").css("display", "none");
      accountDeletion_Displayed = false;
    }
  });
});
