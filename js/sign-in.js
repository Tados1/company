const checkbox = document.getElementById('inpLock');

document.addEventListener("DOMContentLoaded", function() {
    const signInBtn = document.querySelector('.btn');
    const loginNameInput = document.querySelector('.login_name');
    const loginPasswordInput = document.querySelector('.login_password');
    
    signInBtn.addEventListener("click", function(event) {
        if (loginNameInput.value && loginPasswordInput.value) {
            checkbox.checked = true;
        } else {
            event.preventDefault();
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    checkbox.addEventListener("click", function(event) {
        checkbox.checked = false; 
    });
});

function delayRedirect(form) {
    setTimeout(function() {
        form.submit(); 
    }, 1000); 
    return false; 
}

