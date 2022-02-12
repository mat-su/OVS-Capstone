function displayBallot() {
    document.getElementById("voted").innerHTML = "";

    var ele = document.getElementsByTagName('input');
    var ele2 = document.getElementsByTagName('label');
    for(i = 0; i < ele.length; i++) {
          
        if(ele[i].type=="radio") {
          
            if(ele[i].checked){
                document.getElementById("voted").innerHTML
                += ele[i].name + " : "
                + ele2[i].textContent + "<br>";
            }
               
        }
        if(ele[i].type=="checkbox") {
          
            if(ele[i].checked){
                document.getElementById("voted").innerHTML
                += ele2[i].id + " : "
                + ele[i].id + "<br>";
            }
               
        }
    }
}


function clearRadio() {
    var ele = document.getElementsByTagName('input');
    for(var i=0; i<ele.length;i++)
    ele[i].checked = false;
}
