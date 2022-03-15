document.querySelector('#email').addEventListener('keyup', validateEmail);
document.querySelector('#email').addEventListener('blur', validateEmail);
//document.querySelector('#password').addEventListener('blur', validatePassword);

//document.querySelector('#username').addEventListener('blur', validateUsername);
document.querySelector('#fname').addEventListener('blur', validateFirstname);
document.querySelector('#mname').addEventListener('blur', validateMiddlename);
document.querySelector('#lname').addEventListener('blur', validateLastname);
document.querySelector('#studnum').addEventListener('blur', validateStudnum);
document.querySelector('#fname').addEventListener('keyup', validateFirstname);
document.querySelector('#mname').addEventListener('keyup', validateMiddlename);
document.querySelector('#lname').addEventListener('keyup', validateLastname);
document.querySelector('#studnum').addEventListener('keyup', validateStudnum);
document.querySelector('#course').addEventListener('change', validateCourse);
document.querySelector('#chk_agree').addEventListener('click', validateChkBox);
document.querySelector('#submit').addEventListener('click', validateChkBox);
document.querySelector('#submit').addEventListener('click', hasFnameVal);
document.querySelector('#submit').addEventListener('click', hasMnameVal);
document.querySelector('#submit').addEventListener('click', hasLnameVal);
document.querySelector('#submit').addEventListener('click', hasCourseVal);
document.querySelector('#submit').addEventListener('click', hasStudnumVal);
document.querySelector('#submit').addEventListener('click', hasEmailVal);


//const reSpaces = /^\S*$/;
const reSpaces = /\S+.*/;
const regexName = /^[a-zA-ZÑñ]+(([',. -][a-zA-Z Ññ])?[a-zA-ZÑñ]*)*$/;

function hasFnameVal(e) {
  const fname = document.querySelector('#fname');
  if ($('#fname').val()) {
    fname.classList.add('is-valid');
    fname.classList.remove('is-invalid');
    return true;
  } else {
    fname.classList.remove('is-valid');
    fname.classList.add('is-invalid');
    return false;
  }
}

function hasMnameVal(e) {
  const mname = document.querySelector('#mname');
  if ($('#mname').val()) {
    mname.classList.add('is-valid');
    mname.classList.remove('is-invalid');
    return true;
  } else {
    mname.classList.remove('is-valid');
    mname.classList.add('is-invalid');
    return false;
  }
}

function hasLnameVal(e) {
  const lname = document.querySelector('#lname');
  if ($('#lname').val()) {
    lname.classList.add('is-valid');
    lname.classList.remove('is-invalid');
    return true;
  } else {
    lname.classList.remove('is-valid');
    lname.classList.add('is-invalid');
    return false;
  }
}

function hasCourseVal(e) {
  const course = document.querySelector('#course');
  if ($('#course').val()) {
    course.classList.add('is-valid');
    course.classList.remove('is-invalid');
    return true;
  } else {
    course.classList.remove('is-valid');
    course.classList.add('is-invalid');
    return false;
  }
}

function hasStudnumVal(e) {
  const studnum = document.querySelector('#studnum');
  const pmForm = /^PM-[0-9]{2}-[0-9]{5}-[A-Z]$/;
  if (reSpaces.test(studnum.value) && pmForm.test(studnum.value)) {
    studnum.classList.add('is-valid');
    studnum.classList.remove('is-invalid');
    return true;
  } else {
    studnum.classList.remove('is-valid');
    studnum.classList.add('is-invalid');
    return false;
  }
}

function hasEmailVal(e) {
  const email = document.querySelector('#email');
  if ($('#email').val()) {
    email.classList.add('is-valid');
    email.classList.remove('is-invalid');
    return true;
  } else {
    email.classList.remove('is-valid');
    email.classList.add('is-invalid');
    return false;
  }
}


function validateChkBox(e) {
  if ($('#chk_agree').is(":checked")) {
    const chk_val = document.querySelector('#chk_agree');
    chk_val.classList.remove('is-invalid');
    chk_val.classList.add('is-valid');
    return true;
  } else {
    const chk_val = document.querySelector('#chk_agree');
    chk_val.classList.add('is-invalid');
    return false;
  }
}


function validateFirstname(e) {
  const fname = document.querySelector('#fname');
  if (reSpaces.test(fname.value) && regexName.test(fname.value)) {
    fname.classList.remove('is-invalid');
    fname.classList.add('is-valid');
    return true;
  } else {
    fname.classList.remove('is-valid');
    fname.classList.add('is-invalid');
    return false;
  }

}

function validateMiddlename(e) {
  const mname = document.querySelector('#mname');
  if (reSpaces.test(mname.value) && regexName.test(mname.value)) {
    mname.classList.remove('is-invalid');
    mname.classList.add('is-valid');
    return true;
  } else {
    mname.classList.remove('is-valid');
    mname.classList.add('is-invalid');
    return false;
  }

}

function validateLastname(e) {
  const lname = document.querySelector('#lname');
  if (reSpaces.test(lname.value) && regexName.test(lname.value)) {
    lname.classList.remove('is-invalid');
    lname.classList.add('is-valid');
    return true;
  } else {
    lname.classList.remove('is-valid');
    lname.classList.add('is-invalid');
    return false;
  }

}

function validateStudnum(e) {
  const studnum = document.querySelector('#studnum');
  const pmForm = /^PM-[0-9]{2}-[0-9]{5}-[A-Z]$/;
  if (reSpaces.test(studnum.value) && pmForm.test(studnum.value)) {
    studnum.classList.remove('is-invalid');
    studnum.classList.add('is-valid');
    return true;
  } else {
    studnum.classList.remove('is-valid');
    studnum.classList.add('is-invalid');
    return false;
  }

}

function validateEmail(e) {
  const email = document.querySelector('#email');
  const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

  if (reSpaces.test(email.value) && re.test(email.value)) {
    email.classList.remove('is-invalid');
    email.classList.add('is-valid');

    return true;
  } else {
    email.classList.remove('is-valid');
    email.classList.add('is-invalid');

    return false;
  }
}

function validateCourse(e) {
  const course = document.querySelector('#course');
  if (reSpaces.test(course.value)) {
    course.classList.remove('is-invalid');
    course.classList.add('is-valid');
    return true;
  } else {
    course.classList.remove('is-valid');
    course.classList.add('is-invalid');
    return false;
  }

}

/*
function validateUsername(e) {
  const username = document.querySelector('#username');
  if (reSpaces.test(username.value)) {
    username.classList.remove('is-invalid');
    username.classList.add('is-valid');
    return true;
  } else {
    username.classList.remove('is-valid');
    username.classList.add('is-invalid');
    return false;
  }
  
}

function validatePassword() {
  const password = document.querySelector('#password');
  const re = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})(?=.*[!@#$%^&*])/;
  if (re.test(password.value) && reSpaces.test(password.value)) {
    password.classList.remove('is-invalid');
    password.classList.add('is-valid');

    return true;
  } else {
    password.classList.add('is-invalid');
    password.classList.remove('is-valid');

    return false;
  }
}*/


(function () {

  const forms = document.querySelectorAll('.needs-validation');

  for (let form of forms) {
    form.addEventListener(
      'submit',
      function (event) {
        if (
          !form.checkValidity() ||
          !validateEmail() ||
          !validateFirstname() ||
          !validateMiddlename() ||
          !validateLastname() ||
          !validateStudnum() || 
          !validateCourse()
          // !validateUsername() ||
          // !validatePassword() ||

        ) {
          event.preventDefault();
          event.stopPropagation();
        } else {
          form.classList.add('was-validated');
          $('#submit').prop('disabled', true);
        }
      },
      false
    );
  }
})();