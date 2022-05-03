const tbody = document.querySelector("tbody");

const list_user = async() => {
    const data = await fetch("./list.php");
    const dataResponse = await data.text();
    tbody.innerHTML = dataResponse;
    return dataResponse;
};

list_user();