<main class="welcome">
    <div class="welcome__container">
        <div class="welcome__left">
            <img src="<?php echo PATH ?>/public/assets/img/joseph-gonzalez-fdlZBWIP0aM-unsplash.jpg" alt=""/>

        </div>
        <div class="welcome__right">
            <div class="welcome__block card-registr">
                <div class="card-registr__body hide" data-block="registration">
                    <h2 class="card-registr__title">Create an account</h2>
                    <h3 class="card-registr__subtitle">Let's get started</h3>
                    <form class="card-registr__form form-registration" id="form-1">
                        <label for="input_name">Name</label>
                        <input data-id="input_name" type="text" tabindex="1" name="name"
                               class="form-registration__name"/>
                        <label for="input_email">Email</label>
                        <input data-id="input_email" type="email" tabindex="2" name="email"
                               class="form-registration__email"/>
                        <label for="input_password">Password</label>
                        <input data-id="input_password" type="password" tabindex="3" name="password"
                               class="form-registration__password"/>
                        <button data-id="create-account" class="form-registration__btn">
                            Create an account
                        </button>
                    </form>
                    <button data-id="sign-in" class="card-registr__sign-in-btn">
                        I already have an account
                    </button>
                </div>
                <div class="card-registr__body " data-block="sign-in">
                    <h2 class="card-registr__title">Sign in</h2>
                    <h3 class="card-registr__subtitle">Let's get started</h3>
                    <form  class="card-registr__form form-registration" id="form-2">
                        <label for="input_email">Email</label>
                        <input data-id="input_email" type="email" tabindex="2" name="email"
                               class="form-registration__email"/>
                        <label for="input_password">Password</label>
                        <input data-id="input_password" type="password" tabindex="3" name="password"
                               class="form-registration__password"/>
                        <button data-id="sign-in" class="form-registration__btn" type="submit">
                            Sign in
                        </button>
                    </form>
                    <button data-id="create-account" class="card-registr__sign-in-btn">
                        Create an account
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
