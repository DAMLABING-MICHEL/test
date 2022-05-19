var equation = document.getElementById('equation');
equation.addEventListener('keyup' , function () {
    var afficher = document.getElementById('affiche');
    var  test1 = /\-?[0-9]*x\^2/ ;
    var  test2 = /\-?[0-9]*x(?!\^2)/  ;
    var  test3 = /[-?+?][0-9]*$/;
    var res = /^[-?0-9]*x\^2[\-\+]+[0-9]*x(?!\^2)[\-\+]+[0-9]*(?!x)$/;
    /*if (equation.value.match(res))  {
        afficher.textContent = "format d'équation valide";
        afficher.style.color = "limegreen";
        afficher.style.background = "white";
    }
    else{
        afficher.textContent = "format d'équation non valide! \nveuillez saisir chaque caractère selon le standard.";
        afficher.style.color = "red";
        afficher.style.background = "white"; 
    }*/
})

var saisie = document.getElementById('solve');
saisie.addEventListener('click' , function (event) {
    event.preventDefault();
    var equation = document.getElementById('equation').value;
    var geta = document.getElementById('vala');
    var getb = document.getElementById('valb');
    var getc = document.getElementById('valc');
    var  test1 = /\-?[0-9]*x\^2/ ;
    var  test2 = /\-?[0-9]*x(?!\^2)/;
    var  test3 = /[-?+?][0-9]*$/;
    //var regex = ;
    var a = " " , b = " " , c = " ";
    if (test1.test(equation) == true) {
        var item1 = equation.match(test1).toString();
         a = parseInt(item1.split("x")[0]);
         geta.textContent = "a = " + a;
    }
    if (test2.test(equation) == true) {
        var item2 = equation.match(test2).toString();
         b = parseInt(item2.split("x")[0]);
         getb.textContent = "b = " + b;
    }
    if (test3.test(equation) == true) {
        var item3 = equation.match(test3).toString();
        c = parseInt(item3)
         getc.textContent = "c = " + c;
    }
    if (item1.length == 3 && item1[0] == "x") {
        a = 1;
        geta.textContent = "a = " + a;
    }
    else{
        a = parseInt(item1.split("x")[0]);
        geta.textContent = "a = " + a;
    }
    if (item2.length == 1 && item2[0] != "-") {
        b = 1;
         getb.textContent = "b = " + b;
    }
    else{
        b = parseInt(item2.split("x")[0]);
        getb.textContent = "b = " + b;
    }
    if (test3.test(equation) == false) {
        c = 0;
        getc.textContent = "c = " + c;
    }else{
        c = parseInt(item3)
        getc.textContent = "c = " + c;
    }
    if (item1.length == 4 && item1[0] == "-") {
        a = -1;
        geta.textContent = "a = " + a;
    }
    if (item2.length == 2 && item2[0] == "-") {
        b = -1;
        getb.textContent = "b = " + b;
    }
    var d = (b*b)-4*(a*c),s1 = (-b-Math.sqrt(d))/(2*a),s2 = (-b+Math.sqrt(d))/(2*a),s0 = (-b)/(2*a);

    if (d == 0) {
        var getd = document.getElementById('solution');
        getd.innerHTML = "discriminant" + "=" + d + "\n" + "d= 0 donc l' équation admet une solution double s0 = " + s0;
    }
    else if (d > 0) {
        var getd = document.getElementById('solution');
        getd.innerHTML = "discriminant" + "=" + d + "\n" + d + ">" + 0 + " donc l'equation admet deux solutions:s1 = " +s1 + "et s2 = " + s2;
    }
    else{
        var getd = document.getElementById('solution');
        getd.innerHTML = "discriminant" + "=" + d + "\n" + d + "<" + 0 +  "donc l'equation n'a pas de solution";
     }
     /*alert(item1[0])
     alert(item1.length)*/
})
