// Global variables
const tbody = document.querySelector(".listar-usuario");
const form = document.getElementById("regForm");
const editForm = document.getElementById("editForm");
const errorMsg = document.getElementById("error-msg");
const errorMsgEdit = document.getElementById("error-msg-edit");
const successMsg = document.getElementById("success-msg");
const regModal = new bootstrap.Modal(document.getElementById("regUser"));
const editModal = new bootstrap.Modal(document.getElementById("editUser"));
const nameUser = document.getElementById("nome");
const emailUser = document.getElementById("email");
const delUserMsg = document.getElementById("del-user");

/**
 * Retuns data response to tbody innerHMTL
 * @param {number} page number of page
 * @return {string} data to user's interface
 */
const listUser = async(page) => {
    const data = await fetch("./list.php?pagina=" + page);
    const dataResponse = await data.text();
    tbody.innerHTML = dataResponse;
};

form.addEventListener("submit", async(e) => {
    e.preventDefault();

    if (!nameUser.value || !emailUser.value) {
        errorMsg.innerHTML = "Necessário preencher todos os dados";
        console.log(emailUser, nameUser);
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
            listUser(1);
        }
    }
});

/**
 * Fetchs user's id and returns to modal action
 * @param {number} id fetch id user on view.php
 * @return {string} data to user's modal action
 */

async function viewUser(id) {
    const dados = await fetch("view.php?id=" + id);
    const response = await dados.json();

    if (response["erro"]) {
        errorMsg.innerHTML = response["msg"];
    } else {
        const viewModel = new bootstrap.Modal(document.getElementById("viewUser"));
        viewModel.show();

        document.getElementById("id-user").innerHTML = response["data"].id;
        document.getElementById("name-user").innerHTML = response["data"].nome;
        document.getElementById("email-user").innerHTML = response["data"].email;
    }
}

/**
 * Fetchs user's id and returns to modal action
 * @param {number} id fetch id user on view.php
 * @return {string} data to user's modal action
 */

async function editUser(id) {
    const editData = await fetch("view.php?id=" + id);
    const response = await editData.json();

    if (response["erro"]) return;

    editModal.show();
    document.getElementById("edit-id").value = response["data"].id;
    document.getElementById("edit-nome").value = response["data"].nome;
    document.getElementById("edit-email").value = response["data"].email;

    // On submit, fetchs user's on edit.php and returns it to modal window
    editForm.addEventListener("submit", async(e) => {
        e.preventDefault();
        const dataFormEdit = new FormData(editForm);

        const responseEdit = await fetch("edit.php", {
            method: "POST",
            body: dataFormEdit,
        });

        const responseEditJson = await responseEdit.json();

        // If there's an error, throws to user's modal, indicating that's something's wrong
        if (responseEditJson["erro"]) {
            errorMsgEdit.innerHTML = responseEditJson["msg"];
        } else {
            successMsg.innerHTML = responseEditJson["msg"];

            editModal.hide();
            listUser(1);
        }
    });
}

async function deleteUser(id) {
    const delUser = await fetch("delete.php?id=" + id);
    const responseDelData = await delUser.json();

    if (responseDelData["erro"]) return;

    successMsg.innerHTML = responseDelData["msg"];
    console.log(successMsg);
    listUser(1);
}
listUser(1);