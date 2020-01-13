require("./bootstrap");

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("startBot").addEventListener("click", function(e) {
        e.preventDefault();

        user = document.querySelector("#users").value;
        user = user.split("\n");

        urls = document.querySelector("#urls").value;
        urls = urls.split("\n");

        disabledUrlsAndUsers();

        user.forEach(uuser => {
            userSplit = uuser.split(":");

            console.log(userSplit);

            username = userSplit[0];
            passwd = userSplit[1];

            urls.forEach(url => {
                axios
                    .post("/", {
                        url: url,
                        username: username,
                        passwd: passwd
                    })
                    .then(function(response) {
                        console.log(response.data);
                        allRw(response.data);
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            });
        });
    });

    document.getElementById("stopBot").addEventListener("click", function(e) {
        e.preventDefault();
        enabledUrlsAndUsers();
    });

    function insertHTML(html) {
        document
            .querySelector("#debugLog")
            .insertAdjacentHTML("afterend", html);
    }

    function allRw(data) {
        if (
            data.isUserAuth &&
            !data.isVoteView &&
            !data.isVoteProfile &&
            !data.isCreatedBlog &&
            !data.isDeletedBlog &&
            !data.isVoteBlog
        ) {
            html =
                '<tr> <td><span class="badge badge-success">Conectado</span> <strong>' +
                data.username +
                "</strong> inicio sesion con exito</td></tr>";
            insertHTML(html);
            return;
        }

        if (
            !data.isUserAuth &&
            !data.isVoteView &&
            !data.isVoteProfile &&
            !data.isCreatedBlog &&
            !data.isDeletedBlog &&
            !data.isVoteBlog
        ) {
            html =
                '<tr><td><span class="badge badge-danger">Conectado</span> <strong>' +
                data.username +
                "</strong> no pudo iniciar sesion</td></tr>";
            insertHTML(html);
            return;
        }

        if (data.isCreatedBlog) {
            html =
                '<tr> <td><span class="badge badge-success">Crear Blog</span> <strong>' +
                data.username +
                "</strong> se ha creado un blog exito</td></tr>";
            insertHTML(html);

            if (data.isDeletedBlog) {
                html =
                    '<tr> <td><span class="badge badge-success">Borrado Blog</span> <strong>' +
                    data.username +
                    "</strong> se han eliminado todas las entradas</td></tr>";
                insertHTML(html);
                return;
            }
        }

        if (data.isVoteView) {
            html =
                '<tr> <td><span class="badge badge-success">Voto Imagen</span> <strong>' +
                data.username +
                "</strong> voto en la url " +
                data.url +
                "</td></tr>";
            insertHTML(html);
            return;
        }

        if (!data.isVoteView && data.url.includes("MIView")) {
            html =
                '<tr><td><span class="badge badge-danger">Voto Imagen</span> <strong>' +
                data.username +
                "</strong> no pudo votar en la url " +
                data.url +
                "</td></tr>";
            insertHTML(html);
            return;
        }

        if (data.isVoteProfile) {
            html =
                '<tr> <td><span class="badge badge-success">Voto Perfil</span> <strong>' +
                data.username +
                "</strong> voto en la url " +
                data.url +
                "</td></tr>";
            insertHTML(html);
            return;
        }

        if (!data.isVoteProfile && data.url.includes("view_profile")) {
            html =
                '<tr><td><span class="badge badge-danger">Voto Perfil</span> <strong>' +
                data.username +
                "</strong> no pudo votar en la url " +
                data.url +
                "</td></tr>";
            insertHTML(html);
            return;
        }

        if (data.isVoteBlog) {
            html =
                '<tr> <td><span class="badge badge-success">Voto Blog</span> <strong>' +
                data.username +
                "</strong> voto en la url " +
                data.url +
                "</td></tr>";
            insertHTML(html);
            return;
        }

        if (!data.isVoteBlog && data.url.includes("view_blogDetail")) {
            html =
                '<tr><td><span class="badge badge-danger">Voto Blog</span> <strong>' +
                data.username +
                "</strong> no pudo votar en la url " +
                data.url +
                "</td></tr>";
            insertHTML(html);
            return;
        }
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
