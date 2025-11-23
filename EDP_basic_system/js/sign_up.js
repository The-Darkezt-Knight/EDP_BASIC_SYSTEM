//declaring the variables
const form = document.querySelector("form");
const pw_wrappers = document.querySelectorAll(".password-wrapper");
const submit = document.getElementById("submit-btn");
const terms = document.getElementById("terms");
const allFields = document.querySelectorAll(".fields");
const password = document.getElementById("password");
const confirm = document.getElementById("confirm");
const pw_notification = document.querySelectorAll(".pw-notification");
const email = document.getElementById("email");
const email_notification = document.getElementById("email-notification");

// Prevent form submission on Enter in ANY field (forces use of submit button)
form.addEventListener("keydown", function(e) {
  if (e.key === "Enter") {
    e.preventDefault();
  }
});

//toggling the view-password icon
//fixed the issue where the pw_notification translate downward whenever the password icon is clicked
pw_wrappers.forEach(wrapper => {
  const icon = wrapper.querySelector(".icon");
  const field = wrapper.querySelector(".fields");
  const pw_notification = wrapper.querySelectorAll(".pw-notification");

  icon.addEventListener("click", (e) => {
    e.preventDefault();
    field.type = (field.type === "password") ? "text" : "password";
    
    pw_notification.forEach(notif => {
        if(field.type  === "text")
        {
            notif.style.transform = "translateY(-25px)";
        }else
        {
            notif.style.transform = "translateY(0)";
        }
    }) 
  });
});

//validate the email (basic check)
email.addEventListener("input", function() {
    const emailValue = this.value.trim();

    // Hide notification if empty
    if (emailValue === "") {
        email_notification.style.display = "none";
        return;
    }

    // Basic client-side check
    if (!emailValue.includes("@")) {
        email_notification.textContent = "Must contain e.g. @gmail.com";
        email_notification.style.display = "block";
        email_notification.style.color = "tomato";
        return;
    }

    // AJAX request
    $.ajax({
        url: "http://localhost/Projects/EDP_Prefinals/php/email_check.php",
        method: "POST",
        data: { email: emailValue },
        success: function(data) {  // rename 'response' -> 'data'
          try {
              if (data.error) {
                  email_notification.textContent = data.error;
                  email_notification.style.display = "block";
                  email_notification.style.color = "tomato";
              } else if (data.exists) {
                  email_notification.textContent = "Email already exists.";
                  email_notification.style.display = "block";
                  email_notification.style.color = "tomato";
              } else {
                  email_notification.textContent = "Email is available";
                  email_notification.style.display = "block";
                  email_notification.style.color = "green";
              }
          } catch (e) {
              console.error("Error handling AJAX response:", e, data);
              email_notification.textContent = "Error checking email.";
              email_notification.style.display = "block";
              email_notification.style.color = "tomato";
                }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error, xhr.responseText);
            email_notification.textContent = "Error checking email.";
            email_notification.style.display = "block";
            email_notification.style.color = "tomato";
        }
    });
});



//validating the password
function validatePasswords() {
  if(password.value === confirm.value || (password.value === "" && confirm.value === "")) {
  confirm.style.outline = "";
  password.style.outline = "";
  pw_notification.forEach(notif => notif.style.display = "none");
  } else {
    confirm.style.outline = "2px solid red";
    password.style.outline = "2px solid red";
    pw_notification.forEach(notif => notif.style.display = "flex");
  }
}

password.addEventListener("input", validatePasswords);
confirm.addEventListener("input", validatePasswords);

//submitting
//fixed the issue where client-side js blocks the submission
submit.addEventListener("click", (e) => {
  let hasError = false;
  let firstEmpty = null;

  allFields.forEach(field => { 
    if (field.value.trim() === "") {
      field.classList.add("empty");
      if (!firstEmpty) firstEmpty = field;
      hasError = true;
    } else {
      field.classList.remove("empty");
    }
  });

  if (firstEmpty) {
    firstEmpty.focus();
    toastr.error("You must fill all the required fields to proceed", "Validation Error");
    e.preventDefault();
    return;
  }

  if (!terms.checked) {
    toastr.error("You must agree to the terms and conditions.", "Validation Error");
    e.preventDefault();
    return;
  }

  // If no errors, allow form submission (POST to sign_up.php)
});