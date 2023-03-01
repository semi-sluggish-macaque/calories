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

// events
btn.addEventListener("click", openModal);
closeBtn.addEventListener("click", closeModal);
list.addEventListener("click", openProduct);
arrow.addEventListener("click", closeMenuSlider);
document.addEventListener("input", rangeAndCountCalories);
document.addEventListener("click", addProductToCart);

// перед началом работы рендерим на страинцу те продукты, которые лежат в БД
// window.addEventListener("DOMContentLoaded", () => {
//     fetch("http://localhost:3000/my-products")
//         .then((response) => response.json())
//         .then((data) => {
//             data.forEach((product) => {
//                 // разметка
//                 const markUp = `<li class="added-product__item" data-productName =${product.name}>
//     <div class="added-product__left">
//       <div class="added-product__img">
//         <img src="./img/img products/${product.src}.png" alt="">
//       </div>
//       <div class="added-product__title">${product.name}</div>
//     </div>
//     <div class="added-product__right">
//       <div class="added-product__calories">${product.calories} калорий </div>
//       <div class="added-product__quantity">${product.quantity} грамм</div>
//     </div>
//   </li>`;
//
//                 const ulList = document.querySelector(".added-product__list");
//                 // рендерим на страницу
//                 ulList.insertAdjacentHTML("beforeend", markUp);
//                 countCalories();
//             });
//         });
// });

//logic
function openModal() {
    modal.classList.add("slide-menu_active");
    list.innerHTML = "";
    //render
    getData().then((products) => {
        products.forEach((product) => {
            console.log(product)
            const markup = `<li class="slide-menu__item product-card"
data-productName =${product.name}>
    <div class="product-card__body" 
             data-id="${product.id}"
    data-name="${product.name}"
     data-calories="${product.cal}">
      <div class="product-card__img">
<!--        <img src="./img/img products/${product.src}.png" alt="" />-->
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
        В 100 граммах ${infoAboutProduct.name} ${infoAboutProduct.calories} каллорий
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
      <button class="product-counter__btn">
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
    const card = e.target.closest(".product-counter__info-card");
    if (e.target.classList.contains("product-counter__btn")) {
        if (card.querySelector(".product-counter__input").value > 0) {
            console.log(e.target);
            console.log(card)
            const id = e.target.closest(".product-counter__info-card").querySelector(".product-counter__portions").dataset.id;
            const name = card.querySelector("[data-product]").dataset.product;
            const quantity = card.querySelector(".product-counter__input").value;
            const calories = card.querySelector(
                '[data-summonfood="all-food"]'
            ).innerText;
            const dataAboutProduct = {
                id,
                name,
                quantity: parseInt(quantity),
                calories: parseInt(calories),
            };
            console.log(dataAboutProduct);
            // закрываем открытые окна
            modal.classList.remove("slide-menu_active");
            menuSlider.classList.remove("product-counter_active");

            // если продукт уже есть, мы не должны опять  его отрисовывать и добавлять в БДБ надо в существующем просто изменить количество и калории
            // const HTMLCollectionOfProducts = ulList.children;
            // const arrOfProducts = Array.from(HTMLCollectionOfProducts); // делаем с HTMLCollection массив
            //
            // // мы запускаем эту часть кода несколько раз для каждого ли в списке. В этом ошибка\
            // // изменил foreach на some
            // arrOfProducts.some((el) => {
            //     if (el.innerText.includes(name)) {
            //         console.log("ebat");
            //
            //         // находим в списке продуктов нужный нам, и меняем у него калории и грамы
            //         const alreadyExistedProduct = ulList.querySelector(
            //             `[data-productname=${name}]`
            //         );
            //         console.log(alreadyExistedProduct);
            //         let caloriesOfAlreadyExistedProduct = +alreadyExistedProduct
            //             .querySelector(".added-product__calories")
            //             .innerText.replace(/\D+\.?\D+/g, ""); // калории
            //         // console.log(caloriesOfAlreadyExistedProduct);
            //
            //         let quantityOfAlreadyExistedProduct = +alreadyExistedProduct
            //             .querySelector(".added-product__quantity")
            //             .innerText.replace(/\D+\.?\D+/g, ""); // граммы
            //         // console.log(quantityOfAlreadyExistedProduct);
            //
            //         // добавляем калории и граммы уже к существующим продуктам
            //         caloriesOfAlreadyExistedProduct =
            //             parseInt(caloriesOfAlreadyExistedProduct) + parseInt(calories);
            //         quantityOfAlreadyExistedProduct =
            //             parseInt(quantityOfAlreadyExistedProduct) + parseInt(quantity);
            //
            //         // console.log(caloriesOfAlreadyExistedProduct);
            //         alreadyExistedProduct.querySelector(
            //             ".added-product__calories"
            //         ).innerText = caloriesOfAlreadyExistedProduct + " калорий";
            //
            //         alreadyExistedProduct.querySelector(
            //             ".added-product__quantity"
            //         ).innerText = quantityOfAlreadyExistedProduct + " грамм";
            //
            //         // добавляем калории и граммы уже к существующим продуктам в БД
            //         // в url указываем id объекта который хочем поменять, сначала найдем id нужного нам объекта
            //         fetch(`http://localhost:3000/my-products`)
            //             .then((response) => response.json())
            //             .then((data) => {
            //                 const indexProd = data.findIndex((el) => el.name == name);
            //                 const Id = indexProd + 1;
            //                 // console.log(indexProd, Id);
            //
            //                 //надо заменить калории и количество на quantityOfAlreadyExistedProduct и caloriesOfAlreadyExistedProduct
            //                 const updatedProduct = {
            //                     name,
            //                     quantity: parseInt(quantityOfAlreadyExistedProduct),
            //                     calories: parseInt(caloriesOfAlreadyExistedProduct),
            //                     src: name,
            //                 };
            //
            //                 fetch(`http://localhost:3000/my-products/${Id}`, {
            //                     method: "PATCH",
            //                     headers: {
            //                         "Content-Type": "application/json",
            //                     },
            //                     body: JSON.stringify(updatedProduct),
            //                 })
            //                     .then((res) => res.json())
            //                     .then((json) => countCalories());
            //             });
            //
            //         k = true;
            //     }
            // });
            if (k == false) {
                console.log("rats");
                // // записываем новые продукты в массив в бд
                // fetch("face/addProduct", {
                //     method: "POST",
                //     body: JSON.stringify(dataAboutProduct),
                //     headers: {
                //         "Content-Type": "application/json",
                //         Accept: "application/json",
                //     },
                // })
                //     .then((response) => response.json())
                //     .then((data) => {
                //         // countCalories();
                //         console.log(response);
                //     });
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
                        if (responseData.status === "success") {
                            // const span = document.querySelector('.section-addProducts__num');
                            // span.textContent = '500';
                        } else {
                            // handle the error
                            // alert(responseData.message);
                            console.error(responseData.message);
                            // window.location.href = "http://calories";

                        }
                    } catch (error) {
                        // alert(responseData.message);
                        // window.location.href = "http://calories";
                        console.error(error);
                    }
                })();

                // // разметка
                const markUp = `<li class="added-product__item" data-productName =${dataAboutProduct.name}>
<div class="added-product__left">
  <div class="added-product__img">
    <img src="./img/img products/${dataAboutProduct.name}.png" alt="">
  </div>
  <div class="added-product__title">${dataAboutProduct.name}</div>
</div>
<div class="added-product__right">
  <div class="added-product__calories">${dataAboutProduct.calories} калорий </div>
  <div class="added-product__quantity">${dataAboutProduct.quantity} грамм</div>
</div>
</li>`;

                // рендерим на страницу
                ulList.insertAdjacentHTML("beforeend", markUp);

                k = true;
                // k = false
            }
        }
    }
}

//get data
async function getData() {
    const response = await fetch("face/getdata");
    const data = await response.json();
    // console.log(data);
    return data;
}

// считать сколько всего калорий
function countCalories() {
    const allCalories = document.querySelector(".section-addProducts__num");
    fetch("http://localhost:3000/my-products")
        .then((response) => response.json())
        .then((data) => {
            let sumOfCalories = 0;
            data.forEach((product) => {
                sumOfCalories += parseInt(product.calories);
            });
            allCalories.innerText = sumOfCalories;
        });
}

// const alertBlock = document.querySelector('.alert-block');
// const closeBtn = document.querySelector('.alert-block__close-btn');
//
// if (closeBtn) {
//     closeBtn.addEventListener('click', () => {
//         alertBlock.classList.add('alert-block--hidden');
//     });
// }
