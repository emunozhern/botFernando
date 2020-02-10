require("./bootstrap");

$(document).ready(function() {
    $("form").submit(function(e) {
        e.preventDefault();

        loadingBtn(true);

        let formData = new FormData($(this)[0]);

        $.ajax({
            type: "POST",
            url: "/load-accounts",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status) {
                    loadingBtn(false);
                    loginAccounts();
                }

                if (!data.status) {
                    loadingBtn(false);
                    console.log("Error");
                }
            },
            error: function(data) {
                console.error(data);
            }
        });
    });

    getAccountFile();

    $("#voteBlog").on("click", function(e) {
        let flagCount = 0;
        let urlBlogs = $("#url_blogs").val();

        if (urlBlogs.length == 0) {
            return;
        }

        urlBlogs = urlBlogs.split("\n");

        console.log(urlBlogs);
        console.log(urlBlogs.length);

        loadingBtn(true);

        urlBlogs.forEach(url => {
            console.log(url);

            axios
                .post("/votar-blogs", {
                    url: url
                })
                .then(function(response) {
                    console.log(response);

                    if (response.data.status) {
                        flagCount += 1;
                        console.log(response.data);
                        printUserHtml(response.data.accounts);
                        printLogHtml(response.data.message);
                    }

                    if (!response.data.status) {
                        flagCount += 1;
                    }

                    if ((urlBlogs.length = flagCount)) {
                        loadingBtn(false);
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        });
    });

    $("#voteProfile").on("click", function(e) {
        let flagCount = 0;
        let urlBlogs = $("#url_profiles").val();

        if (urlBlogs.length == 0) {
            return;
        }

        urlBlogs = urlBlogs.split("\n");

        console.log(urlBlogs);
        console.log(urlBlogs.length);

        loadingBtn(true);

        urlBlogs.forEach(url => {
            console.log(url);

            axios
                .post("/votar-perfiles", {
                    url: url
                })
                .then(function(response) {
                    console.log(response);

                    if (response.data.status) {
                        flagCount += 1;
                        console.log(response.data);
                        printUserHtml(response.data.accounts);
                        printLogHtml(response.data.message);
                    }

                    if (!response.data.status) {
                        flagCount += 1;
                    }

                    if ((urlBlogs.length = flagCount)) {
                        loadingBtn(false);
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        });
    });

    $("#voteImage").on("click", function(e) {
        let flagCount = 0;
        let urlBlogs = $("#url_images").val();

        if (urlBlogs.length == 0) {
            return;
        }

        urlBlogs = urlBlogs.split("\n");

        console.log(urlBlogs);
        console.log(urlBlogs.length);

        loadingBtn(true);

        urlBlogs.forEach(url => {
            console.log(url);

            axios
                .post("/votar-imagenes", {
                    url: url
                })
                .then(function(response) {
                    console.log(response);

                    if (response.data.status) {
                        flagCount += 1;
                        console.log(response.data);
                        printUserHtml(response.data.accounts);
                        printLogHtml(response.data.message);
                    }

                    if (!response.data.status) {
                        flagCount += 1;
                    }

                    if ((urlBlogs.length = flagCount)) {
                        loadingBtn(false);
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        });
    });

    $("#createBlog").on("click", function(e) {
        loadingBtn(true);

        axios
            .post("/crear-blog")
            .then(function(response) {
                console.log(response);

                if (response.data.status) {
                    console.log(response.data);
                    loadingBtn(false);
                    printUserHtml(response.data.accounts);
                    printLogHtml(response.data.message);
                }
            })
            .catch(function(error) {
                console.log(error);
            });
    });

    $("#destroyBlog").on("click", function(e) {
        loadingBtn(true);

        axios
            .post("/eliminar-blog")
            .then(function(response) {
                console.log(response);

                if (response.data.status) {
                    console.log(response.data);
                    loadingBtn(false);
                    printUserHtml(response.data.accounts);
                    printLogHtml(response.data.message);
                }
            })
            .catch(function(error) {
                console.log(error);
            });
    });

    function getAccountFile() {
        loginAccounts();
    }

    function loginAccounts() {
        loadingBtn(true);

        axios
            .get("/login-accounts")
            .then(function(response) {
                if (response.data.status) {
                    console.log(response.data);
                    loadingBtn(false);
                    printUserHtml(response.data.accounts);
                }

                if (!response.data.status) {
                    loadingBtn(false);
                    console.log("Error");
                }
            })
            .catch(function(error) {
                console.log(error);
            });
    }

    function loadingBtn(flag) {
        if (flag) {
            $(".load").removeClass("d-none");
        } else {
            $(".load").addClass("d-none");
        }
    }

    function printUserHtml(users = []) {
        $(".list-group").html("");

        _.forEach(users, function(user, i) {
            console.log(user);
            console.log(i);
            $(".list-group").append(
                '<li id="' +
                    i +
                    '" class="list-group-item">' +
                    i +
                    ' <span class="badge badge-primary">' +
                    user.point +
                    "</span></li>"
            );
        });
    }

    function printLogHtml(html) {
        if (html) {
            if (_.isArray(html)) {
                _.forEach(html, function(el) {
                    $("#debugLog").append(el);
                });
            } else {
                $("#debugLog").append(html);
            }
        }
    }

    // function allRw(data) {

    //     if (
    //         !data.isUserAuth &&
    //         !data.isVoteView &&
    //         !data.isVoteProfile &&
    //         !data.isCreatedBlog &&
    //         !data.isDeletedBlog &&
    //         !data.isVoteBlog
    //     ) {
    //         html =
    //             '<tr><td><span class="badge badge-danger">Conectado</span> <strong>' +
    //             data.username +
    //             "</strong> no pudo iniciar sesion</td></tr>";
    //         insertHTML(html);
    //         return;
    //     }

    //     if (data.isCreatedBlog) {
    //         html =
    //             '<tr> <td><span class="badge badge-success">Crear Blog</span> <strong>' +
    //             data.username +
    //             "</strong> se ha creado un blog exito</td></tr>";
    //         insertHTML(html);

    //         if (data.isDeletedBlog) {
    //             html =
    //                 '<tr> <td><span class="badge badge-success">Borrado Blog</span> <strong>' +
    //                 data.username +
    //                 "</strong> se han eliminado todas las entradas</td></tr>";
    //             insertHTML(html);
    //             return;
    //         }
    //     }

    // function disabledUrlsAndUsers() {
    //     document.querySelector("#urls").setAttribute("disabled", "disabled");
    //     document.querySelector("#users").setAttribute("disabled", "disabled");
    // }

    // function enabledUrlsAndUsers() {
    //     document.querySelector("#urls").removeAttribute("disabled", "disabled");
    //     document
    //         .querySelector("#users")
    //         .removeAttribute("disabled", "disabled");
    // }
});
