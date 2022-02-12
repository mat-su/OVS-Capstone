<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/bootstrap/css/style.css">
    <title>test</title>
    <script>
        $(document).ready(function() {
            
            $('#btnSubmit').click(function(e) {
                e.preventDefault();
                
                var fullname = $('#fullname').val();
                $.ajax({
                    url: "test2.php",
                    method: "POST",
                    data: {
                        fullname: fullname
                    },
                    success: function(data) {

                        $('#getMsg').html(data);
                    }
                });
            });
        });
    </script>

</head>

<body>
<div class="loader">
   <center>
       <img class="loading-image" src="loading.jpg" alt="loading..">
   </center>
</div>
    <div class="container mt-5">
        <div class="getMsg" id="getMsg"></div>
        <form method="POST" id="myForm">
            <label for="fullname"> Fullname</label>
            <input id="fullname" name="fullname" type="text" class="form-control" required>
            <button class="btn btn-success mt-3" id="btnSubmit" form="myForm" type="submit">Submit</button>
        </form>

    </div>
    <div>
        
    b>Name:</b> bye[] <b>Limit:</b> 5<br>
<input type="checkbox" class="boxes" data-max="5" name="bye[]"/>
<input type="checkbox" class="boxes" data-max="5" name="bye[]"/>
<input type="checkbox" class="boxes" data-max="5" name="bye[]"/>
<input type="checkbox" class="boxes" data-max="5" name="bye[]"/>
<input type="checkbox" class="boxes" data-max="5" name="bye[]"/>
<input type="checkbox" class="boxes" data-max="5" name="bye[]"/>
<hr/>
  <b>Name:</b> hello[] <b>Limit:</b> 2<br>
<input type="checkbox" class="boxes" data-max="2" name="hello[]"/>
<input type="checkbox" class="boxes" data-max="2" name="hello[]"/>
<input type="checkbox" class="boxes" data-max="2" name="hello[]"/>
                        <script>
                            function limit() {
                                var count = 0;
                                //Get all elements with the class name of Boxes
                                var boxes = document.getElementsByClassName('boxes');
                                // ---- Or ------  
                                //Get all input elements with the type of checkbox.
                                //var boxes=document.querySelectorAll("input[type=checkbox]");
                                //(this) is used to target the element triggering the function.
                                for (var i = 0; i < boxes.length; i++) {
                                    //If checkbox is checked AND checkbox name is = to (this) checkbox name +1 to count
                                    if (boxes[i].checked && boxes[i].name == this.name) {
                                        count++;
                                    }
                                }
                                //If count is more then data-max="" of that element, uncheck last selected element
                                if (count > this.getAttribute("data-max")) {
                                    this.checked = false;
                                    alert("Maximum of " + this.getAttribute("data-max") + ".");
                                }
                            }
                            //----Stack Overflow Snippet use---\\
                            window.onload = function() {
                                var boxes = document.getElementsByClassName('boxes');
                                // Use if you don't want to add a class name to the elements
                                //var boxes=document.querySelectorAll("input[type=checkbox]");
                                for (var i = 0; i < boxes.length; i++) {
                                    boxes[i].addEventListener('change', limit, false);
                                }
                            }
                        </script>

    </div>
    <div class="container">
        <form class="row g-3 needs-validation" novalidate>
            <div class="col-md-4">
                <label for="validationCustom01" class="form-label">First name</label>
                <input type="text" class="form-control" id="validationCustom01" value="Mark" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustom02" class="form-label">Last name</label>
                <input type="text" class="form-control" id="validationCustom02" value="Otto" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustomUsername" class="form-label">Username</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
                    <div class="invalid-feedback">
                        Please choose a username.
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom03" class="form-label">City</label>
                <input type="text" class="form-control" id="validationCustom03" required>
                <div class="invalid-feedback">
                    Please provide a valid city.
                </div>
            </div>
            <div class="col-md-3">
                <label for="validationCustom04" class="form-label">State</label>
                <select class="form-select" id="validationCustom04" required>
                    <option selected disabled value="">Choose...</option>
                    <option>...</option>
                </select>
                <div class="invalid-feedback">
                    Please select a valid state.
                </div>
            </div>
            <div class="col-md-3">
                <label for="validationCustom05" class="form-label">Zip</label>
                <input type="text" class="form-control" id="validationCustom05" required>
                <div class="invalid-feedback">
                    Please provide a valid zip.
                </div>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                    <label class="form-check-label" for="invalidCheck">
                        Agree to terms and conditions
                    </label>
                    <div class="invalid-feedback">
                        You must agree before submitting.
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit form</button>
            </div>
        </form>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()

    </script>


</body>

</html>