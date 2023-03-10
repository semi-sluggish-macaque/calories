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
      <span> ?????? ????????????????: </span> ${infoAboutProduct.name}
    </h2>
  </div>
  <div class="product-counter__wrapper2">
    <div class="product-counter__info-card">

      <div class="product-counter__portion">????????????</div>
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
          <span class="product-counter__span"> ??????????</span>
        </div>
      </div>
      <ul class="product-counter__portions" data-calories="${infoAboutProduct.calories}" data-product="${infoAboutProduct.src}" data-id ="${infoAboutProduct.id}">
      <li class="product-counter__one-portion">
      <div class="product-counter__gramm">
        ?? 100 ?????????????? ${infoAboutProduct.name} ${infoAboutProduct.calories} ????????????????
      </div>
    </li>
    <li class="product-counter__one-portion">
      <div class="product-counter__gramm">
        ???????? ???????????? ${infoAboutProduct.name} - ?????? 150 ??????????
      </div>
    </li>
    <li class="product-counter__one-portion">
      <div class="product-counter__gramm" >
        ???? ?????????? <span data-summonFood="all-food"> 0 </span>  ????????????????
      </div>
    </li>
      </ul>
      <button class="product-counter__btn">
        ???????????????? ??????????????
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
            // ?????????????????? ???????????????? ????????
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

                // // ????????????????
                const markUp = `<li class="added-product__item" data-productName =${dataAboutProduct.name}>
<div class="added-product__left">
  <div class="added-product__img">
    <img src="./img/img products/${dataAboutProduct.name}.png" alt="">
  </div>
  <div class="added-product__title">${dataAboutProduct.name}</div>
</div>
<div class="added-product__right">
  <div class="added-product__calories">${dataAboutProduct.calories} ?????????????? </div>
  <div class="added-product__quantity">${dataAboutProduct.quantity} ??????????</div>
</div>
</li>`;

                // ???????????????? ???? ????????????????
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

// ?????????????? ?????????????? ?????????? ??????????????
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
