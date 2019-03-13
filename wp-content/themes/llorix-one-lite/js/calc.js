// function plus(){
//   var num1, num2, result;
//
//   num1 = document.getElementById('n1').value;
//   num1 = parseInt(num1);
//
//   num2 = document.getElementById('n2').value;
//   num2 = parseInt(num2);
//
//   result = num1 + num2;
//
//
//   document.getElementById('out').innerHTML = result;
// }
//
// function minus(){
//   var num1, num2, result;
//
//   num1 = document.getElementById('n1').value;
//   num1 = parseInt(num1);
//
//   num2 = document.getElementById('n2').value;
//   num2 = parseInt(num2);
//
//   result = num1 - num2;
//
//
//   document.getElementById('out').innerHTML = result;
// }
//
// function multiplay(){
//   var num1, num2, result;
//
//   num1 = document.getElementById('n1').value;
//   num1 = parseInt(num1);
//
//   num2 = document.getElementById('n2').value;
//   num2 = parseInt(num2);
//
//   result = num1 * num2;
//
//
//   document.getElementById('out').innerHTML = result;
// }
//
//
// function calc(){
//   var choise1, choise2, result;
//
//
//   choise1 = document.getElementById('ch1').value;
//   choise1 = parseInt(num1);
//
//   choise2 = document.getElementById('n2').value;
//   choise2 = parseInt(num2);
//
//   result = choise1 + choise2;
//
//
//   document.getElementById('in').innerHTML = result;
// }
//
// function show_alert()
// {
//   if (myCheckBox.checked)
//   {
//     alert("Флажок установлен"); }
//   else
//   {
//     alert("Флажок не установлен")
//   }
// }

function myFunc ()
{
var rez = 0; var stand ;

with (document)
{




// if (getElementById ('b2').checked == true) (getElementById ('b4').checked = true);

// if (document.getElementById('b2').checked == true){
// document.getElementById('b4').checked = true;}


// if (document.getElementById('b2').checked == true){
// document.getElementById('b4').checked = true;}

if (getElementById ('b1').checked) (getElementById('img3').className = 'img11');


if (getElementById ('b2').checked) (getElementById('st1').className = 'newclass');
else  (getElementById('st1').className = 'oldclass');

if (getElementById ('b2').checked) (getElementById('img2').className = 'img11');
else  (getElementById('img2').className = 'img1');



if (getElementById ('b2').checked) (getElementById('img1').className = 'img1');
else  (getElementById('img1').className = 'img11');

if (getElementById ('b4').checked) (getElementById('img3').className = 'img11');
else  (getElementById('img3').className = 'img1');
if (getElementById ('b4').checked) (getElementById('img2').className = 'img1');



if (getElementById ('b1').checked) (getElementById ('b7').checked = false);
if (getElementById ('b1').checked) (getElementById ('b6').checked = false);
if (getElementById ('b1').checked) (getElementById ('b4').checked = false);
if (getElementById ('b1').checked) (getElementById ('b5').checked = false);

if (getElementById ('b2').checked) (getElementById ('b7').checked = false) ;
if (getElementById ('b2').checked) (getElementById ('b6').checked = false);





if (getElementById ('b3').checked) (getElementById ('b4').checked = false);
if (getElementById ('b3').checked) (getElementById ('b5').checked = false);

if (getElementById ('b3').checked) rez += parseFloat (getElementById ('s3').innerHTML);
if (getElementById ('b3').checked) (getElementById('pr').className = 'newclass');
else  (getElementById('pr').className = 'oldclass');

if (getElementById ('b1').checked) rez += parseFloat (getElementById ('s1').innerHTML);
if (getElementById ('b2').checked) rez += parseFloat (getElementById ('s2').innerHTML);

if (getElementById ('b4').checked) rez += parseFloat (getElementById ('s4').innerHTML);
if (getElementById ('b5').checked) rez += parseFloat (getElementById ('s5').innerHTML);
if (getElementById ('b6').checked) rez += parseFloat (getElementById ('s6').innerHTML);
if (getElementById ('b7').checked) rez += parseFloat (getElementById ('s7').innerHTML);
getElementById ('r').innerHTML = rez;
}





// document.getElementById('finish').onclick = function (){
// if (document.getElementById('finish').checked == true){
// document.getElementById('finish2').checked = false;}
// }

}
