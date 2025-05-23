window.login_code = 0;

var code = 1;



  document.addEventListener("DOMContentLoaded", function () {
    const signInBtn = document.getElementById("Signin-btn");
    const signUpBtn = document.getElementById("Signup-btn");

    signInBtn.addEventListener("click", function () {
      document.getElementById("Log-btn").innerHTML = "Sign In";
      // You can replace this with any logic you want
    });

    signUpBtn.addEventListener("click", function () {
        document.getElementById("Log-btn").innerHTML = "Sign Up";
      // You can replace this with any logic you want
    });
  });

  document.getElementById("Log-btn").addEventListener("click", function () {
    if (document.getElementById("Log-btn").innerHTML == "Sign In") code = 1;
    if (document.getElementById("Log-btn").innerHTML == "Sign Up") code = 2;
    document.getElementById("Log-btn").innerHTML = "Loading";
        });

  document.addEventListener("DOMContentLoaded", function () {
    const logBtn = document.getElementById("Log-btn");

    logBtn.addEventListener("click", function () {
      const username = document.getElementById("LoginInput").value;
      const password = document.getElementById("PasswordInput").value;

      const xhr = new XMLHttpRequest();
      if (code == 1) xhr.open("POST", "signin.php", true);
      if (code == 2) xhr.open("POST", "signup.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            alert(xhr.responseText);
            console.log("Login response:", xhr.responseText);
            if (xhr.responseText == "Confirmed"){
                document.getElementById("Log-btn").innerHTML = "Confirmed";
                window.location.href = "map.html";
                window.login_code = 1;
                document.getElementById("allMap").style.display = "block"
                }
            if (xhr.responseText == "Denied"){
                document.getElementById("Log-btn").innerHTML = "Denied";
                }
            if (xhr.responseText == "User registered successfully."){
                document.getElementById("Log-btn").innerHTML = "Registered";
                }
            if (xhr.responseText == "Username already exists. Please choose a different one."){
                document.getElementById("Log-btn").innerHTML = "Account Exist";
                }

                setTimeout(() => {
                    document.getElementById("Log-btn").innerHTML = "Sign In";
                    document.getElementById("LoginInput").value = "";
                    document.getElementById("PasswordInput").value = "";
                    code = 1;
                  }, 3000);
          } else {
            //alert(xhr.responseText);
            document.getElementById("Log-Btn").innerHTML = "Failed";
            // Handle error
          }
        }
      };

      const params = `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`;
      xhr.send(params);
    });
  });

