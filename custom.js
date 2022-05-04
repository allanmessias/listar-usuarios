/**
 * Retuns data response to tbody innerHMTL
 * @param {number} page number of page
 * @return {string} data to user's interface
 */

const tbody = document.querySelector(".listar-usuario");

const list_user = async(page) => {
    const data = await fetch("./list.php?pagina=" + page);
    const dataResponse = await data.text();
    tbody.innerHTML = dataResponse;
};

list_user(1);