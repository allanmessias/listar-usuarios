/**
 * Retuns data response to tbody innerHMTL
 * @param {number} page number of page
 * @return {string} data to user's interface
 */

const tbody = document.querySelector(".listar-usuario");
const form = document.getElementById("regForm");
const errorMsg = document.getElementById("error-msg");
const successMsg = document.getElementById("success-msg");
const regModal = new bootstrap.Modal(document.getElementById("regUser"));
const name = document.getElementById("nome").value;
const email = document.getElementById("email").value;

const list_user = async(page) => {
    const data = await fetch("./list.php?pagina=" + page);
    const dataResponse = await data.text();
    tbody.innerHTML = dataResponse;
};

form.addEventListener("submit", async(e) => {
    e.preventDefault();

    if (name === "" || email === "") {
        errorMsg.innerHTML = "Necessário preencher o nome";
    } else {
        const dataForm = new FormData(form);
        dataForm.append("add", 1);

        const response = await fetch("register.php", {
            method: "POST",
            body: dataForm,
        });

        const responseJson = await response.json();
        if (responseJson["erro"]) {
            errorMsg.innerHTML = responseJson["msg"];
        } else {
            successMsg.innerHTML = responseJson["msg"];
            form.reset();
            regModal.hide();
            list_user(1);
        }
    }
});

list_user(1);