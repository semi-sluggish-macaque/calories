const form = document.querySelector(".form-registration");
const btnSignIn = document.querySelector(".card-registr__sign-in-btn");
const card = document.querySelector(".card-registr");
const cardRegistration = document.querySelector('[data-block="registration"]');
const cardSignIn = document.querySelector('[data-block="sign-in"]');

if (window.location.href == "http://calories/") {
    cardRegistration.addEventListener("submit", getDataFromRegistration);
    cardSignIn.addEventListener("submit", getDataFromSignIn);
    document.addEventListener("click", showSignInForm);
}


function getDataFromRegistration(e) {
    e.preventDefault();

    const regForm = document.querySelector("#form-1");
    // get data from form
    const inputName = regForm.querySelector(".form-registration__name");
    const inputEmail = regForm.querySelector(".form-registration__email");
    const inputPassword = regForm.querySelector(".form-registration__password");

    const dataObj = {
        name: inputName.value,
        email: inputEmail.value,
        password: inputPassword.value,
    };


    (async () => {
        try {
            const response = await fetch("main/registration", {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(dataObj),
            });
            const responseData = await response.json();
            console.log(responseData);

            if (responseData.status === "success") {
                // redirect to the success page
                window.location.href = "http://calories/face";
            } else {
                // handle the error
                console.error(responseData.message);
                window.location.href = "http://calories";

            }
        } catch (error) {
            window.location.href = "http://calories";
            console.error(error);
        }
    })();
    console.log(dataObj);
    // очистка формы
    inputName.value = "";
    inputEmail.value = "";
    inputPassword.value = "";
}

function getDataFromSignIn(e) {
    e.preventDefault();

    // get data from form
    const signForm = document.querySelector("#form-2");
    // const inputName = signForm.querySelector(".form-registration__name");
    const inputEmail = signForm.querySelector(".form-registration__email");
    const inputPassword = signForm.querySelector(".form-registration__password");

    const dataObj = {
        email: inputEmail.value,
        password: inputPassword.value,
    };

    console.log(dataObj);


    (async () => {
        try {
            const response = await fetch("main/login", {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(dataObj),
            });
            const responseData = await response.json();
            console.log(responseData);

            if (responseData.status === "success") {
                // redirect to the success page
                window.location.href = "http://calories/face";
            } else {
                // handle the error
                // alert(responseData.message);
                console.error(responseData.message);
                window.location.href = "http://calories";

            }
        } catch (error) {
            // alert(responseData.message);
            window.location.href = "http://calories";
            console.error(error);
        }
    })();
    // очистка формы
    inputName.value = "";
    inputEmail.value = "";
    inputPassword.value = "";
}

function showSignInForm(e) {
    if (e.target.dataset.id == "sign-in") {
        console.log("pizda");
        cardRegistration.classList.add("hide");
        cardSignIn.classList.remove("hide");
    }

    if (e.target.dataset.id == "create-account") {
        console.log("xuy");
        cardRegistration.classList.remove("hide");
        cardSignIn.classList.add("hide");
    }
}

const alertBlock = document.querySelector('.alert-block');
const closeBtn = document.querySelector('.alert-block__close-btn');

if (closeBtn) {
    closeBtn.addEventListener('click', () => {
        alertBlock.classList.add('alert-block--hidden');
    });
}

