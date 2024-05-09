document.addEventListener("DOMContentLoaded", main);


function main() {
    changeColor();
    tamañoDiv();
    let texto = document.getElementsByClassName("texto");
    for (let index = 0; index < texto.length; index++) {
        texto[index].addEventListener("click", function (e) {
            ocultar(e.currentTarget);
            e.stopPropagation();
        });
    }
    hora();
}



function tamañoDiv() {
    let fontSize = 16;
    let contador = Math.pow(fontSize, 2);
    let content = document.getElementById('content');

    content.addEventListener("click", function () {
        if (content.style.fontSize === "2em") {
            while (fontSize < contador) {
                fontSize += 1;
                content.style.fontSize = fontSize + "px";
            }

        } else {
            content.style.fontSize = "2em";
        }
    });
}


function changeColor() {
    document.getElementById('abstract').addEventListener("click", function () {
        let abstract = document.getElementById('abstract');
        if (abstract.style.backgroundColor === "blue") {
            abstract.style.backgroundColor = "";
        } else {
            abstract.style.backgroundColor = "blue";
        }
    });
}

