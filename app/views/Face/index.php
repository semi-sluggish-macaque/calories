<main class="main">

    <section class="main__addProducts section-addProducts">
        <div class="section-addProducts__container">
            <div class="section-addProducts__block">
                <div class="section-addProducts__header">
                    <div class="section-addProducts__title"><?= $day_part ?></div>
                    <div class="section-addProducts__summary">
                        Итого: <span class="section-addProducts__num"> <?php echo $totalCalories ?> </span> калорий
                    </div>
                </div>
                <div class="section-addProducts__begin">
                    <div class="section-addProducts__content">
                        <div class="added-product">
                            <ul class="added-product__list">
                                <?php foreach ($data as $product): ?>

                                    <li class="added-product__item" data-productName=<?php echo $product['name'] ?>
                                    data-id=<?php echo $product["id"] ?>
                                        data-caloriesInBD=<?php echo $product['cal'] ?>>
                                        <div class="added-product__content">
                                            <div class="added-product__left">
                                                <div class="added-product__img">
                                                    <!--                                                    <img src="./img/img products/${product.src}.png" alt="">-->
                                                </div>
                                                <div class="added-product__title"><?php echo $product["name"] ?>
                                                </div>
                                            </div>
                                            <div class="added-product__right">
                                                <div class="added-product__calories"><?php echo($product["amount"] * $product["cal"] / 100) ?>
                                                    калорий
                                                </div>
                                                <div class="added-product__quantity"><?php echo $product["amount"] ?>
                                                    грамм
                                                </div>

                                            </div>
                                        </div>
                                        <div class="added-product__close"></div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <!-- <h2 class="section-addProducts__title">Начать!</h2> -->
                        <p class="section-addProducts__text">
                            Нажмите "+" чтобы добавить запись в журнал.
                        </p>
                        <div class="section-addProducts__btn"></div>
                        <div class="slide-menu">
                            <div class="slide-menu__wrapper">
                                <h2 class="slide-menu__title">Добавить продукт</h2>
                                <div class="slide-menu__closeModal"></div>
                            </div>
                            <form action="" class="slide-menu__form">
                                <label for="find-product">
                                    <input
                                            type="text"
                                            id="find-product"
                                            placeholder="Имя продукта"
                                    />
                                </label>
                            </form>
                            <div class="slide-menu__boxForProducts">
                                <h2 class="slide-menu__subtitle">Популярные продукты</h2>

                                <ul class="slide-menu__list">
                                    <!-- <li class="slide-menu__item product-card">
                                      <div class="product-card__body">
                                        <div class="product-card__img">
                                          <img src="./img/img products/apple.png" alt="" />
                                        </div>
                                        <h2 class="product-card__title">Яблоко</h2>
                                      </div>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                        <div class="product-counter">
                            <div class="product-counter__body">
                                <div class="product-counter__arrow-back">
                                    <img src="./img/arrow.png" alt=""/>
                                </div>
                                <div class="product-counter__out">
                                    <div class="product-counter__card">
                                        <div class="product-counter__wrapper1">
                                            <div class="product-counter__img">
                                                <img
                                                        src="./img/img products/img big size products/apple-xl-size.png"
                                                        alt=""
                                                />
                                            </div>
                                            <h2 class="product-counter__title">
                                                <span> Имя продукта: </span> Apple
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
                                                        <span class="product-counter__span">
                                  грамм</span
                                                        >
                                                    </div>
                                                </div>
                                                <ul class="product-counter__portions">
                                                    <li class="product-counter__one-portion">
                                                        <div class="product-counter__gramm">
                                                            В 100 граммах Яблок 100 каллорий
                                                        </div>
                                                    </li>
                                                    <li class="product-counter__one-portion">
                                                        <div class="product-counter__gramm">
                                                            Одна порция Яблок - это 150 грамм
                                                        </div>
                                                    </li>
                                                    <li class="product-counter__one-portion">
                                                        <div
                                                                class="product-counter__gramm"
                                                                data-summonFood="all-food"
                                                        >
                                                            Вы съели 500 каллорий
                                                        </div>
                                                    </li>
                                                    <!-- <li class="product-counter__one-portion">
                                                      <div class="product-counter__gramm">100g</div>
                                                      <div class="product-counter__gram-num">
                                                        100 грамм
                                                      </div>
                                                      <div class="product-counter__close"></div>
                                                    </li>
                                                    <li class="product-counter__one-portion">
                                                      <p class="product-counter__gramm">1 порция</p>
                                                      <p class="product-counter__gram-num">
                                                        150 грамм
                                                      </p>
                                                      <div class="product-counter__close"></div>
                                                    </li>
                                                    <li class="product-counter__one-portion">
                                                      <p class="product-counter__gramm">1 чашка</p>
                                                      <p class="product-counter__gram-num">
                                                        210 грамм
                                                      </p>
                                                      <div class="product-counter__close"></div>
                                                    </li> -->
                                                </ul>
                                                <button class="product-counter__btn">
                                                    Добавить продукт
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="edit-product">
                            <div class="edit-product__body">
                                <!-- <div class="edit-product__arrow-back">
                                  <img src="./img/arrow.png" alt="" />
                                </div> -->
                                <div class="edit-product__content"></div>
                                <div class="edit-product__close"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>