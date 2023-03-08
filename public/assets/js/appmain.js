const menuToggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('nav');

menuToggle.addEventListener('click', () => {
    nav.classList.toggle('active');
});

const btn = document.querySelector(".section-addProducts__btn");
const closeBtn = document.querySelector(".slide-menu__closeModal");
const modal = document.querySelector(".slide-menu");
const menuSlider = document.querySelector(".product-counter");
const list = document.querySelector(".slide-menu__list"); //ul
const arrow = document.querySelector(".product-counter__arrow-back");
const range = document.querySelector(".product-counter__input");
const btnAddProduct = document.querySelector(".product-counter__btn");
const ulList = document.querySelector(".added-product__list");
const editModalWindow = document.querySelector(".edit-product");
const deleteProductBtn = document.querySelector(".added-product__close");
const changerBtn = document.querySelectorAll(".changer");
const obertka = document.querySelector(".obertka");
const arrows = document.querySelectorAll(".arrows");


// events
btn.addEventListener("click", openModal);
closeBtn.addEventListener("click", closeModal);
list.addEventListener("click", openProduct);
arrow.addEventListener("click", closeMenuSlider);
document.addEventListener("input", rangeAndCountCalories);
document.addEventListener("input", rangeAndCountCalories2);
document.addEventListener("click", addProductToCart);
document.addEventListener("click", addEditedProduct);
ulList.addEventListener("click", editProduct);
document.addEventListener("click", deleteProduct);
obertka.addEventListener("click", day_part_changer);
arrows.forEach((arrow) => {
    arrow.addEventListener("click", changer);

})
changerBtn.forEach((item) => {
    item.addEventListener("click", changer)
})

let change = 0;
let change_day_part = 0;

function day_part_changer(e) {
    if (e.target.classList.contains("breakfast")) {
        change_day_part = "breakfast";
        render();
    }
    if (e.target.classList.contains("dinner")) {
        change_day_part = "dinner";
        render();
    }
    if (e.target.classList.contains("lunch")) {
        change_day_part = "lunch";
        render();
    }
}

function changer(e) {
    e.preventDefault()
    if (e.target.classList.contains("previous")) {
        change--;
    }
    if (e.target.classList.contains("next")) {
        change++;
    }
    const items = document.querySelectorAll(".added-product__item");
    items.forEach((item) => {
        item.remove();
    })
    render();
}

window.addEventListener("DOMContentLoaded", render());

function render() {
    const span = document.querySelector('.section-addProducts__num');
    span.textContent = 0;
    const dateOnPage = document.querySelector('.date');
    dateOnPage.textContent = currentDate(change);
    addedProducts = document.querySelectorAll(".added-product__item");
    if (addedProducts) {
        addedProducts.forEach((product) => {
            product.remove()
        })
    }
    (async () => {
        try {
            const response = await fetch("face/render", {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    date: currentDate(change),
                    dayPart: day_part(change_day_part),
                }),
            });
            const data = await response.json();
            products = data.products
            if (products) {
                products.forEach((product) => {
                    // разметка
                    const markUp = `<li class="added-product__item" data-productName =${product.name} data-id = ${product.id} data-caloriesInBD=${product.cal}>
    <div class="added-product__content"> 
        <div class="added-product__left">
            <div class="added-product__img">
<!--                 <img src="./img/img products/${product.src}.png" alt="">-->
             </div>
             <div class="added-product__title">${product.name}
           </div>
          </div>
<div class="added-product__right">
  <div class="added-product__calories">${(product.cal * product.amount) / 100} калорий </div>
  <div class="added-product__quantity">${product.amount} грамм</div>
 
</div>
    </div>
    <div class="added-product__close"></div>
  </li>`;

                    const ulList = document.querySelector(".added-product__list");
                    // рендерим на страницу
                    ulList.insertAdjacentHTML("beforeend", markUp);
                    const span = document.querySelector('.section-addProducts__num');
                    span.textContent = data.totalCalories;
                });
            } else {

            }

        } catch (error) {
            console.error(error);
        }
    })();
}

//logic
function openModal() {
    modal.classList.add("slide-menu_active");
    list.innerHTML = "";
    //render
    console.log(getData())
    getData().then((products) => {
        products.forEach((product) => {
            const markup = `<li class="slide-menu__item product-card"
data-productName =${product.name}>
    <div class="product-card__body" 
             data-id="${product.id}"
    data-name="${product.name}"
     data-calories="${product.cal}">
      <div class="product-card__img">
      </div>
      <h2 class="product-card__title">${product.name}</h2>
    </div>
  </li>`;
            list.insertAdjacentHTML("beforeend", markup);
        });

        // console.log(products);
    });
}

function closeModal() {
    modal.classList.remove("slide-menu_active");
    menuSlider.classList.remove("product-counter_active");
}

function closeMenuSlider() {
    menuSlider.classList.remove("product-counter_active");
}

// open product and show counter
function openProduct(e) {
    // console.log(e.target); //product-card__body
    const out = document.querySelector(".product-counter__out");
    out.innerHTML = "";
    menuSlider.classList.add("product-counter_active");

    const infoAboutProduct = {
        id: e.target.dataset.id,
        name: e.target.querySelector(".product-card__title").innerHTML,
        src: e.target.dataset.name,
        calories: e.target.dataset.calories,
    };

    // console.log(infoAboutProduct);

    const markUp = `<div class="product-counter__card" data-id ="${infoAboutProduct.id}"
>
  <div class="product-counter__wrapper1">
    <div class="product-counter__img">
      <img
        src="./img/img products/img big size products/${infoAboutProduct.src}-xl-size.png"
        alt=""
      />
    </div>
    <h2 class="product-counter__title">
      <span> Имя продукта: </span> ${infoAboutProduct.name}
    </h2>
  </div>
  <div class="product-counter__wrapper2">
    <div class="product-counter__info-card">

      <div class="product-counter__portion">Порция</div>
      <div class="product-counter__range">
        <input
          type="range"
          class="product-counter__input"
          min="0"
          max="300"
          value="0"
        />
        <div class="product-counter__num">
          <span class="product-counter__quantity-gramm">
            0</span
          >
          <span class="product-counter__span"> грамм</span>
        </div>
      </div>
      <ul class="product-counter__portions" data-calories="${infoAboutProduct.calories}" data-product="${infoAboutProduct.src}" data-id ="${infoAboutProduct.id}">
      <li class="product-counter__one-portion">
      <div class="product-counter__gramm">
        В 100 граммах ${infoAboutProduct.name}  <span> ${infoAboutProduct.calories}</span> каллорий
      </div>
    </li>
    <li class="product-counter__one-portion">
      <div class="product-counter__gramm">
        Одна порция ${infoAboutProduct.name} - это 150 грамм
      </div>
    </li>
    <li class="product-counter__one-portion">
      <div class="product-counter__gramm" >
        Вы съели <span data-summonFood="all-food"> 0 </span>  каллорий
      </div>
    </li>
      </ul>
      <button class="product-counter__btn button-addProduct">
        Добавить продукт
      </button>
    </div>
  </div>
</div>`;

    out.insertAdjacentHTML("beforeend", markUp);
}

//range and count calories
function rangeAndCountCalories(e) {
    if (e.target.classList.contains("product-counter__input")) {
        const out = document.querySelector(".product-counter__quantity-gramm");
        out.innerHTML = e.target.value;
        const inputBox = e.target.closest(".product-counter__range");
        const card = inputBox.closest(".product-counter__info-card");
        const nameOfCurrentCard = card.querySelector("[data-product]");
        const caloriesOfProduct = nameOfCurrentCard.dataset.calories;
        const haveEaten = document.querySelector('[data-summonFood="all-food"]');
        const amountOfCalories =
            (parseInt(e.target.value) * parseInt(caloriesOfProduct)) / 100;
        haveEaten.innerText = amountOfCalories;
    }
}

// add product to your daily ration
function addProductToCart(e) {
    let k = false;
    console.log(e.target)
    const card = e.target.closest(".product-counter__info-card");
    console.log(card)

    if (e.target.classList.contains("product-counter__btn")) {
        if (card.querySelector(".product-counter__input").value > 0) {
            console.log('piska')
            console.log(e.target);
            console.log(card)
            const id = e.target.closest(".product-counter__info-card").querySelector(".product-counter__portions").dataset.id;
            const name = card.querySelector("[data-product]").dataset.product;
            const quantity = card.querySelector(".product-counter__input").value;
            const calories = card.querySelector(
                '[data-summonfood="all-food"]'
            ).innerText;

            const caloriesInBD = parseInt(
                card.querySelector(".product-counter__gramm").querySelector("span")
                    .innerText
            );
            const dataAboutProduct = {
                id,
                name,
                quantity: parseInt(quantity),
                calories: parseInt(calories),
                caloriesInBD,
                day_part: day_part(change_day_part),
                currentDate: currentDate(change),
            };
            console.log(dataAboutProduct);
            // закрываем открытые окна
            modal.classList.remove("slide-menu_active");
            menuSlider.classList.remove("product-counter_active");


            if (k == false) {
                console.log("rats");
                (async () => {
                    try {
                        const response = await fetch("face/addProduct", {
                            method: "POST",
                            headers: {
                                Accept: "application/json",
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify(dataAboutProduct),
                        });
                        const responseData = await response.json();
                        console.log(responseData);
                        const span = document.querySelector('.section-addProducts__num');
                        span.textContent = responseData;
                    } catch (error) {
                        // alert(responseData.message);
                        // window.location.href = "http://calories";
                        console.error(error);
                    }
                })();

                // // разметка
                const markUp = `<li class="added-product__item" data-id =${dataAboutProduct.id} data-productName =${dataAboutProduct.name} data-caloriesInBD=${dataAboutProduct.caloriesInBD}>
        <div class="added-product__content"> 
        <div class="added-product__left">
      <div class="added-product__img">
<!--        <img src="./img/img products/${dataAboutProduct.name}.png" alt="">-->
      </div>
      <div class="added-product__title">${dataAboutProduct.name}</div>
    </div>
    <div class="added-product__right">
      <div class="added-product__calories">${dataAboutProduct.calories} калорий </div>
      <div class="added-product__quantity">${dataAboutProduct.quantity} грамм</div>
     
    </div>
        </div>
        <div class="added-product__close"></div>
</li>`;

                // рендерим на страницу
                ulList.insertAdjacentHTML("beforeend", markUp);

                k = true;
                // k = false
            }
        }
    }
}

function editProduct(e) {
    if (e.target.classList.contains("added-product__content")) {
        console.log(e.target); // <div class="added-product__content"></div>
        const liProduct = e.target.closest(".added-product__item"); // <li class="added-product__item"/>
        console.log(liProduct);
        editModalWindow.classList.add("edit-product_active");

        const data = {
            id: liProduct.dataset.id,
            name: liProduct.dataset.productname,
            quantity: parseInt(
                liProduct
                    .querySelector(".added-product__quantity")
                    .innerText.replace(/\D+\.?\D+/g, "")
            ),
            calories: parseInt(
                liProduct
                    .querySelector(".added-product__calories")
                    .innerText.replace(/\D+\.?\D+/g, "")
            ),
            caloriesInBD: liProduct.dataset.caloriesinbd,
        };

        console.log(data);
        const out = document.querySelector(".edit-product__content");
        const markUp = `<div class="product-counter__card" data-id ="${data.id}" >
    <div class="product-counter__wrapper1">
      <div class="product-counter__img">
        <img
          src="./img/img products/img big size products/${data.name}-xl-size.png"
          alt=""
        />
      </div>
      <h2 class="product-counter__title">
        <span> Имя продукта: </span> ${data.name}
      </h2>
    </div>
    <div class="product-counter__wrapper2">
      <div class="product-counter__info-card" data-name ="${data.name}">
  
        <div class="product-counter__portion">Порция</div>
        <div class="product-counter__range">
          <input
            type="range"
            class="product-counter__input2"
            min="0"
            max="300"
            value="${data.quantity}"
          />
          <div class="product-counter__num">
            <span class="product-counter__quantity-gramm">
            ${data.quantity}</span
            >
            <span class="product-counter__span"> грамм</span>
          </div>
        </div>
        <ul class="product-counter__portions" data-calories="${data.calories}" data-product="${data.name}" data-id ="${data.id}" data-caloriesInBD="${data.caloriesInBD}">
        <li class="product-counter__one-portion">
        <div class="product-counter__gramm">
          В 100 граммах ${data.name} ${data.caloriesInBD} каллорий
        </div>
      </li>
      <li class="product-counter__one-portion">
        <div class="product-counter__gramm">
          Одна порция ${data.name} - это 150 грамм
        </div>
      </li>
      <li class="product-counter__one-portion">
        <div class="product-counter__gramm" >
          Вы съели <span data-summonFood="all-food"> ${data.calories} </span>  каллорий
        </div>
      </li>
        </ul>
        <button class="product-counter__btn button-edit">
         Редактировать
        </button>
      </div>
    </div>
  </div>`;

        out.insertAdjacentHTML("beforeend", markUp);

        out
            .closest(".edit-product")
            .querySelector(".edit-product__close")
            .addEventListener("click", () => {
                editModalWindow.classList.remove("edit-product_active");
                out.innerHTML = "";
            });
    }
}

//
function rangeAndCountCalories2(e) {
    if (e.target.classList.contains("product-counter__input2")) {
        console.log("gavno");
        const input = e.target;
        const card = input.closest(".product-counter__info-card");
        console.log(card);
        const outGram = card.querySelector(".product-counter__quantity-gramm");
        outGram.innerHTML = e.target.value;
        const outCalories = card.querySelector('[data-summonfood="all-food"]');

        const nameOfCurrentCard = card.querySelector("[data-product]");
        const caloriesOfProduct = nameOfCurrentCard.dataset.caloriesinbd;

        const amountOfCalories = (parseInt(e.target.value) * parseInt(caloriesOfProduct)) / 100;
        outCalories.innerText = amountOfCalories;
    }
}

function addEditedProduct(e) {
    if (e.target.classList.contains("button-edit")) {
        const card = e.target.closest(".product-counter__info-card");
        const name = card.dataset.name;
        const id = card.querySelector(".product-counter__portions").dataset.id;
        const quantity = card.querySelector(
            ".product-counter__quantity-gramm"
        ).innerText;

        const calories = card.querySelector(
            '[data-summonfood="all-food"]'
        ).innerText;

        // ---------------------------------------------------
        const dataAboutProduct = {
            id,
            name,
            quantity: parseInt(quantity),
            calories: parseInt(calories),
            day_part: day_part(change_day_part),
            currentDate: currentDate(change),
        };

        console.log(dataAboutProduct);

        // закрываем открытые окна
        editModalWindow.classList.remove("edit-product_active");
        const out = document.querySelector(".edit-product__content");
        out.innerHTML = "";

        // перезаписываем значение калорий и вес
        const productToChange = ulList.querySelector(
            `[data-productname = ${dataAboutProduct.name}]`
        );
        console.log(productToChange); // li
        productToChange.querySelector(".added-product__quantity").innerText =
            dataAboutProduct.quantity + " грамм";
        productToChange.querySelector(".added-product__calories").innerText =
            dataAboutProduct.calories + " калорий";

        // Записываем обновленные данные в БД

        (async () => {
            try {
                const response = await fetch("face/edit", {
                    method: "POST",
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(dataAboutProduct),
                });
                const responseData = await response.json();
                console.log(responseData);
                const span = document.querySelector('.section-addProducts__num');
                span.textContent = responseData;
            } catch (error) {
                console.error(error);
            }
        })();
    }
}

async function deleteProduct(e) {
    if (e.target.classList.contains("added-product__close")) {
        console.log("kotiki");
        const productWeWantToDelete = e.target.closest("li");
        console.log(productWeWantToDelete);
        const id = productWeWantToDelete.dataset.id;
        console.log(id);
        // удаляем продукт с разметки
        productWeWantToDelete.remove();
        // const dayPart = day_part(change_day_part)
        // const currentDate = currentDate(change)

        const deleteBody = {
            dayPart: day_part(change_day_part),
            currentDate: currentDate(change),
            id
        }
        // удаляем с БД

        try {
            const response = await fetch("face/delete", {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(deleteBody),
            });
            const responseData = await response.json();
            console.log(responseData);
            const span = document.querySelector('.section-addProducts__num');
            span.textContent = responseData;
        } catch (error) {
            console.error(error);
        }

    }
}

//get data
async function getData() {
    try {
        const response = await fetch("face/getdata", {
            method: "POST",
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                date: currentDate(change),
                dayPart: day_part(change_day_part),
            }),
        });
        const data = await response.json();
        return data;
    } catch (error) {
        console.error(error);
    }
}

function currentDate(change) {
    let today = new Date();
    let formattedDate = today.toISOString().slice(0, 10); // gives format 'Y-m-d'
    let oneDayAgo = new Date(formattedDate);
    oneDayAgo.setDate(oneDayAgo.getDate() + change);
    let formattedOneDayAgo = oneDayAgo.toISOString().slice(0, 10); // gives format 'Y-m-d'
    return formattedOneDayAgo;
}

function day_part(day_part = 0) {
    if (day_part) {
        document.querySelector('.active').classList.remove('active')
        const day_part_var = document.querySelector(`.${day_part}`);
        day_part_var.classList.add("active")
        return day_part
    } else {
        const current_time = new Date().getHours();
        if (current_time >= 4 && current_time <= 12) {
            const breakfast = document.querySelector(".breakfast");
            breakfast.classList.add("active")
            return 'breakfast';
        }
        if (current_time >= 13 && current_time <= 17) {
            const dinner = document.querySelector(".dinner");
            dinner.classList.add("active")
            return 'dinner';
        }
        if (current_time >= 18) {
            const lunch = document.querySelector(".lunch");
            lunch.classList.add("active")
            return 'lunch';
        }
    }

}
