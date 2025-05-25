<?php
session_start();

if (isset($_SESSION['user'])) {
    // User is already logged in, redirect to map.php
    header("Location: map.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Local Highways</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="Visuals/visual_logo.png" type="image/png">
  <style>
    @font-face {
      font-family: 'Brokstate SemiBold';
      src: url('Font/BROKSTATE-Semibold.otf') format('opentype');
      font-weight: 600;
      font-style: normal;
    }

    * {
      box-sizing: border-box;
    }

    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: sans-serif;
    }

    body {
      position: relative;
    }

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      position: fixed;
      z-index: -1;
    }

    #container {
      position: absolute;
      top: 20%;
      left: 50%;
      width: 80px;
      z-index: 3;
    }

    #menu_logo {
      max-width: 100%;
      height: auto;
      transform: translate(-50%, -50%);
    }

    #menuContainer {
      position: absolute;
      top: 50%;
      left: 50%;
      padding: 40px 70px;
      transform: translate(-50%, -50%);
      background-color: rgba(50, 50, 50, 0.8);
      border-radius: 30px;
      text-align: center;
    }

    #Apptitle {
      margin-bottom: 30px;
    }

    #Apptitle img {
      left: 50%;
      width: 80%;
      height: auto;
      transform: translate(-50%, -50%);
    }

    #buttonContainer {
      display: flex;
      justify-content: space-around;
      margin-bottom: 20px;
    }

    #Signin-btn, #Signup-btn {
      font-family: 'Brokstate SemiBold', sans-serif;
      font-size: 20px;
      color: white;
      cursor: pointer;
      transition: text-shadow 0.3s ease;
    }

    #Signin-btn:hover, #Signup-btn:hover {
      text-shadow: 0 0 3px rgba(255, 255, 255, 0.5),
                   0 0 16px rgba(255, 255, 255, 0.4);
    }

    #LoginWrapper, #PasswordWrapper {
      position: relative;
      width: 100%;
      margin: 10px 0;
    }

    #LoginInput, #PasswordInput {
      width: 110%;
      height: 50px;
      margin-left: -10px;
      padding: 0 15px;
      font-size: 16px;
      border: none;
      background-color: rgba(70, 70, 70, 0.9);
      color: white;
      
    }

    #LoginInput:focus, #PasswordInput:focus {
      outline: none;
    }

    #MenuNameLine, #PasswordNameLine {
      position: absolute;
      bottom: -3px;
      left: 50%;
      transform: translateX(-50%) scaleX(0);
      transform-origin: center;
      height: 2px;
      background-color: white;
      width: 110%;
      transition: transform 0.3s ease;
    }

    #LoginWrapper:focus-within #MenuNameLine,
    #PasswordWrapper:focus-within #PasswordNameLine {
      transform: translateX(-50%) scaleX(1);
    }

    #Log-btn {
      position: absolute;
      left: 50%;
      background-color: white;
      color: black;
      font-family: 'Brokstate SemiBold', sans-serif;
      font-size: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      border: none;
      transform: translate(-50%, -50%);
    }

    /* Default styles (applies to all devices unless overridden below) */
/* Already written earlier in your <style> tag */

/* Smartphones */
@media (max-width: 600px) {
  #menu_logo {
      position: relative;
      max-width: 100%;
      height: auto;
      transform: translate(-50%, -50%);
      margin-top: -30px;
    }
    #Apptitle {
      position: relative;
      top: 40%;
      margin-top: -50px;
    }
  #menuContainer {
    width: 95%;
    height: 500px;
    padding: 30px 50px;
    
  }

  #Signin-btn, #Signup-btn {
    top: 100%;
    font-size: 18px;
    margin-top: 180px;
  }

  #Log-btn {
    top: 85%;
    font-size: 20px;
    width: 70%;
    height: 50px;
    margin-top: 10px;
  }

  #LoginInput, #PasswordInpu{
    position: relative;
    top: 10%;
    height: 45px;
    margin-top: 0px;
    font-size: 14px;
  }

}

/* Tablets */
@media (min-width: 601px) and (max-width: 1024px) {
  #menuContainer {
    width: 90%;
    padding: 40px 20px;
  }

  #Signin-btn, #Signup-btn {
    font-size: 22px;
  }

  #Log-btn {
    font-size: 24px;
  }

  #LoginInput, #PasswordInput {
    height: 50px;
    font-size: 16px;
  }
}

/* Laptops & Desktops */
@media (min-width: 1025px) {
  #menu_logo {
      position: relative;
      max-width: 70%;
      height: auto;
      margin-top: -30px;
  }
  #Apptitle {
      position: relative;
      top: 40%;
      margin-top: -60px;
      
    }
  #menuContainer {
    width: 300px;
    height: 70%;
    padding: 60px 60px;
    
  }

  #Signin-btn, #Signup-btn {
    font-size: 24px;
    margin-top: 140px;
  }

  #Log-btn {
    top: 85%;
    font-size: 30px;
    width: 70%;
    height: 15%;
  }

  #LoginInput {
    height: 40px;
    font-size: 18px;
    margin-top: -10px;
  }
  #PasswordInput{
    height: 40px;
    font-size: 18px;
    margin-top: 0px;
  }
}

  </style>
</head>
<body>
  <img src="Visuals/visual_bg_2.png" alt="Background">

  <div id="menuContainer">
    <div id="container">
      <img src="Visuals/visual_logo.png" id="menu_logo" alt="Logo">
    </div>
    <div id="Apptitle">
      <img src="Visuals/visual_title.png" alt="App Title">
    </div>

    <div id="buttonContainer">
      <div id="Signin-btn">Sign In</div>
      <div id="Signup-btn">Sign Up</div>
    </div>

    <div id="LoginWrapper">
      <input type="text" id="LoginInput" placeholder="Username" />
      <div id="MenuNameLine"></div>
    </div>

    <div id="PasswordWrapper">
      <input type="password" id="PasswordInput" placeholder="Password" />
      <div id="PasswordNameLine"></div>
    </div>

    <div id="Log-btn">Sign Up</div>
  </div>
  <script src = "script.js"></script>
</body>
</html>