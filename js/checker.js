email.onblur = function() {
     fetch('/unique_checker.php', {
          method: 'post',
          headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({cmd: "check_email", value: this.value})
    }).then(function(res){ return res.json(); })
    .then(function(data){ 
        if (!data.success) {
            submit.disabled = true;
            email.style.border = "2px solid red";
            email_error.textContent=data.error;
        } else{
            submit.disabled = false;
            email.style.border = "1px solid black";
            email_error.textContent="";
        }
    });
};

username.onblur = function() {
    fetch('/unique_checker.php', {
          method: 'post',
          headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({cmd: "check_username", value: this.value})
    }).then(function(res){ return res.json(); })
    .then(function(data){ 
        if (!data.success) {
            submit.disabled = true;
            username.style.border = "2px solid red";
            username_error.textContent=data.error;
        } else{
            submit.disabled = false;
            username.style.border = "1px solid black";
            username_error.textContent="";
        }
    });
};