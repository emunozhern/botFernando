require("./bootstrap");

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("startBot").addEventListener("click", function(e) {
        e.preventDefault();

        urls = document.querySelector("#urls").value;
        urls = urls.split("\n");

        user = document.querySelector("#users").value;
        user = user.split("\n");

        disabledUrlsAndUsers();

        urls.forEach((url, i) => {
            randomUser = user[Math.floor(Math.random() * user.length)];
            username = randomUser.split(":")[0];
            passwd = randomUser.split(":")[1];

            axios
                .post("/", {
                    url: url,
                    username: username,
                    passwd: passwd
                })
                .then(function(response) {
                    console.log(response.data);
                    isUserAuth(response.data);
                    isVoteProfile(response.data);
                    isVoteProfile(response.data);
                })
                .catch(function(error) {
                    console.log(error);
                });
        });
    });

    document.getElementById("stopBot").addEventListener("click", function(e) {
        e.preventDefault();
        enabledUrlsAndUsers();
    });

    function isUserAuth(data) {
        if (data.isUserAuth) {
            document
                .querySelector("#debugLog")
                .insertAdjacentHTML(
                    "afterend",
                    '<tr> <td><span class="badge badge-success">Conectado</span> <strong>' +
                        data.username +
                        "</strong> inicio sesion con exito</td></tr>"
                );
            return;
        }

        document
            .querySelector("#debugLog")
            .insertAdjacentHTML(
                "afterend",
                '<tr><td><span class="badge badge-danger">Conectado</span> <strong>' +
                    data.username +
                    "</strong> no pudo iniciar sesion</td></tr>"
            );
        return;
    }
    function isVoteView(data) {
        if (data.isVoteProfile && !data.isVoteView) {
            document
                .querySelector("#debugLog")
                .insertAdjacentHTML(
                    "afterend",
                    '<tr> <td><span class="badge badge-success">Voto Perfil</span> <strong>' +
                        data.username +
                        "</strong> voto en la url " +
                        data.url +
                        "</td></tr>"
                );
            return;
        }

        document
            .querySelector("#debugLog")
            .insertAdjacentHTML(
                "afterend",
                '<tr><td><span class="badge badge-danger">Voto Perfil</span> <strong>' +
                    data.username +
                    "</strong> no pudo votar en la url " +
                    data.url +
                    "</td></tr>"
            );
    }
    function isVoteProfile(data) {
        if (!data.isVoteProfile && data.isVoteView) {
            document
                .querySelector("#debugLog")
                .insertAdjacentHTML(
                    "afterend",
                    '<tr> <td><span class="badge badge-success">Voto Imagen</span> <strong>' +
                        data.username +
                        "</strong> voto en la url " +
                        data.url +
                        "</td></tr>"
                );
            return;
        }

        document
            .querySelector("#debugLog")
            .insertAdjacentHTML(
                "afterend",
                '<tr><td><span class="badge badge-danger">Voto Imagen</span> <strong>' +
                    data.username +
                    "</strong> no pudo votar en la url " +
                    data.url +
                    "</td></tr>"
            );
    }

    function disabledUrlsAndUsers() {
        document.querySelector("#urls").setAttribute("disabled", "disabled");
        document.querySelector("#users").setAttribute("disabled", "disabled");
    }

    function enabledUrlsAndUsers() {
        document.querySelector("#urls").removeAttribute("disabled", "disabled");
        document
            .querySelector("#users")
            .removeAttribute("disabled", "disabled");
    }
});
