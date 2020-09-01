const soma = (num1, num2) => num1 + num2;


/* Método, URL, async */
var xhr = new XMLHttpRequest();
xhr.open("GET", "https://viacep.com.br/ws/01001000/json/", true);
xhr.onload = function (e) {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            var dados = JSON.parse(xhr.responseText);
            console.log("sucesso");
            console.log(dados);
        } else {
            console.error(xhr.statusText);
        }
    }
};
xhr.onerror = function (e) {
    console.error(xhr.statusText);
};
xhr.send(); 

function hello(name) {
    alert('Oi ' + name);
  }
  
  function processUserInput(callback) {
    var name = prompt('Por favor, insira seu nome.');
    callback(name);
  }
  
  processUserInput(hello);