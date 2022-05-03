const tbody = document.querySelector(".listar-usuario");

const list_user = async(page) => {
    const data = await fetch("./list.php?pagina=" + page);
    const dataResponse = await data.text();
    tbody.innerHTML = dataResponse;
};

list_user(1);