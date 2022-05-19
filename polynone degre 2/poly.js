var saisie = document.getElementById('solve');
saisie.addEventListener('click' , function (event) {
    event.preventDefault();
    var equation = document.getElementById('equation').value;
    //var remplace = equation.split("-").join("+-");
    for (let i = 1; i < equation.length; i++) {
        if(equation[i] == '-'){
            equation = equation.slice(0,i) + '+-' + equation.slice(i+1);
            i++
        }
        
    }
    var tableau = equation.split("+");
    var item1 = tableau[0],item2 = tableau[1],item3 = tableau[2];
    var a = ""
    var b = ""
    var c = ""
    if (item1.length == 3) {
          a = 1;
         var geta = document.getElementById('vala');
         geta.textContent = "a = " + a;
    }
    else{
        a = parseInt(item1.split("x")[0]);
        var geta = document.getElementById('vala');
         geta.textContent = "a = " + a;
    }
    if (item2.length == 1) {
        b = 1;
        var getb = document.getElementById('valb');
         getb.textContent = "b = " + b;
    }
    else{
        b = parseInt(item2.split("x")[0]);
        var getb = document.getElementById('valb');
         getb.textContent = "b = " + b;
    }
    if (item3.length == 0) {
        c == 0;
        var getc = document.getElementById('valc');
        getc.textContent = "c = " + c;
    }
    else{
        c = parseInt(item3.split("x")[0])
        var getc = document.getElementById('valc');
         getc.textContent = "c = " + c;    }

    var d = (b*b)-4*(a*c),s1 = (-b-Math.sqrt(d))/(2*a),s2 = (-b+Math.sqrt(d))/(2*a),s0 = (-b-Math.sqrt(d))/(2*a);

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
})
var equation = document.getElementById('equation');
equation.addEventListener('keyup' , function () {
    var afficher = document.getElementById('affiche');
    afficher.textContent = equation.value;
})